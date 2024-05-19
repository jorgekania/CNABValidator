<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class CnabController extends Controller
{
    protected int $layout;

    public function uploadForm()
    {
        return view('cnab.upload');
    }

    public function validateCnab(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:txt',
        ]);

        $file = $request->file('file');
        $content = file_get_contents($file->getRealPath());

        try {
            $this->layout = $this->detectLayout($content);
            $validationResults = $this->validateCnabContent($content, $this->layout);

            $status = $this->determineStatus($validationResults);

            $response = [
                'layout' => $this->layout,
                'status' => $status,
                'response' => $validationResults,
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'response' => ['error' => $e->getMessage()],
            ]);
        }
    }

    private function detectLayout($content)
    {
        $lines = explode("\n", $content);
        $firstLineLength = strlen(trim($lines[0]));

        return match ($firstLineLength) {
            240 => 240,
            400 => 400,
            444 => 444,
            default => throw new Exception("Layout desconhecido ou com quantidade de caracteres errado: Header com $firstLineLength caracteres.")
        };
    }

    private function validateCnabContent($content, $layout)
    {
        $errors = [
            'header' => [],
            'details' => [],
            'trailer' => [],
        ];
        $lines = explode("\n", $content);

        foreach ($lines as $line) {
            if (! empty(trim($line))) {
                $recordType = mb_substr($line, 0, 1);

                if ($recordType == '0') {
                    $this->validateCnab444Header($line, $errors['header']);
                } elseif ($recordType == '1') {
                    $this->validateCnab444Details($line, $errors['details']);
                } elseif ($recordType == '9') {
                    $this->validateCnab444Trailer($line, $errors['trailer']);
                }
            }
        }

        return $this->formatValidationResults($errors);
    }

    private function determineStatus($validationResults)
    {
        $hasErrors = false;
        $hasWarnings = false;

        foreach ($validationResults as $block => $result) {
            if (is_array($result) && ! empty($result)) {
                $hasErrors = true;
            } else {
                $hasWarnings = true;
            }
        }

        if ($hasErrors && ! $hasWarnings) {
            return 'error';
        }

        if ($hasErrors && $hasWarnings) {
            return 'warning';
        }

        return 'success';
    }

    private function formatValidationResults($errors)
    {
        $formattedResults = [];
        foreach ($errors as $block => $messages) {
            if (empty($messages)) {
                $formattedResults[$block] = ucfirst($block).' validado com sucesso';
            } else {
                $formattedResults[$block] = $messages;
            }
        }

        return $formattedResults;
    }

    private function validateCnab444Header($line, &$errors)
    {
        $fields = [
            ['Identificação do Registro', 1, 1, 1, '9(1)', '0'],
            ['Identificação do Arquivo Remessa', 2, 2, 1, '9(1)', '1'],
            ['Literal Remessa', 3, 9, 7, 'X(7)', 'REMESSA'],
            ['Código de Serviço', 10, 11, 2, '9(2)', '01'],
            ['Literal Serviço', 12, 26, 15, 'X(15)', 'COBRANCA '],
            ['Código do Originador', 27, 46, 20, '9(20)', null],
            ['Nome do Originador', 47, 76, 30, 'X(30)', null],
            ['Número do Banco', 77, 79, 3, '9(3)', null],
            ['Nome do Banco', 80, 94, 15, 'X(15)', null],
            ['Data da Gravação do Arquivo', 95, 100, 6, '9(6)', null],
            ['Branco', 101, 108, 8, 'X(8)', str_repeat(' ', 8)],
            ['Identificação do Sistema', 109, 110, 2, 'X(2)', 'MX'],
            ['Nº Sequencial do Arquivo', 111, 117, 7, '9(7)', null],
            ['Número do banco do cedente', 118, 120, 3, '9(3)', null],
            ['Número da agencia do banco', 121, 125, 5, '9(5)', null],
            ['Digito verificador da agencia', 126, 126, 1, '9(1)', null],
            ['Número da conta corrente', 127, 138, 12, '9(12)', null],
            ['Digito verificador da conta corrente', 139, 139, 1, '9(1)', null],
            ['Branco', 140, 438, 299, 'X(299)', str_repeat(' ', 299)],
            ['Nº Sequencial do Registro', 439, 444, 6, '9(6)', '000001'],
        ];

        $this->validateFields($fields, $line, $errors);
    }

    private function validateCnab444Details($line, &$errors)
    {
        $fields = [
            ['Identificação do registro', 1, 1, 1, '9(1)', '1'],
            ['Data de Carência', 2, 7, 6, '9(6)', null],
            ['Tipo de Juros', 8, 8, 1, '9(1)', null],
            ['Branco', 9, 10, 2, 'X(2)', str_repeat(' ', 2)],
            ['Taxa de Juros', 11, 20, 10, '9(10)', null],
            ['Coobrigação', 21, 22, 2, '9(2)', null],
            ['Característica especial', 23, 24, 2, '9(2)', null],
            ['Modalidade da operação', 25, 28, 4, '9(4)', null],
            ['Natureza da operação', 29, 30, 2, '9(2)', null],
            ['Origem do recurso', 31, 34, 4, '9(4)', null],
            ['Classe risco da operação', 35, 36, 2, 'X(2)', null],
            ['Zeros', 37, 37, 1, '9(1)', '0'],
            ['Nº de controle do participante', 38, 62, 25, 'X(25)', null],
            ['Número do banco', 63, 65, 3, '9(3)', null],
            ['Zeros', 66, 70, 5, '9(5)', '00000'],
            ['Identificação do título no banco', 71, 81, 11, '9(11)', null],
            ['Dígito do nosso número', 82, 82, 1, 'X(1)', null],
            ['Valor pago', 83, 92, 10, '9(10)', null],
            ['Condição para emissão da papeleta de cobrança', 93, 93, 1, 'X(1)', null],
            ['Ident. Se emite papeleta para débito automático', 94, 94, 1, 'X(1)', null],
            ['Data da liquidação', 95, 100, 6, '9(6)', null],
            ['Identificação da operação do banco', 101, 104, 4, 'X(4)', null],
            ['Indicador rateio crédito', 105, 105, 1, 'X(1)', null],
            ['Endereçamento para aviso do débito automático', 106, 106, 1, 'X(1)', null],
            ['Branco', 107, 108, 2, 'X(2)', str_repeat(' ', 2)],
            ['Identificação ocorrência', 109, 110, 2, '9(2)', null],
            ['Nº do documento', 111, 120, 10, 'X(10)', null],
            ['Data do vencimento do título', 121, 126, 6, '9(6)', null],
            ['Valor do título (face) (Valor nominal)', 127, 139, 13, '9(13)', null],
            ['Banco encarregado da cobrança', 140, 142, 3, '9(3)', null],
            ['Agência depositária', 143, 147, 5, '9(5)', null],
            ['Espécie de título', 148, 149, 2, '9(2)', null],
            ['Identificação', 150, 150, 1, 'X(1)', null],
            ['Data da emissão do título', 151, 156, 6, '9(6)', null],
            ['1ª instrução', 157, 158, 2, '9(2)', null],
            ['2ª instrução', 159, 159, 1, '9(1)', null],
            ['Tipo de pessoa do cedente', 160, 161, 2, 'X(2)', null],
            ['Juros/Mora', 162, 173, 12, 'X(12)', null],
            ['Número do termo de cessão', 174, 192, 19, 'X(19)', null],
            ['Valor presente da parcela (Valor de aquisição)', 193, 205, 13, '9(13)', null],
            ['Valor do abatimento', 206, 218, 13, '9(13)', null],
            ['Identificação do tipo de inscrição do sacado', 219, 220, 2, '9(2)', null],
            ['Número da inscrição do sacado', 221, 234, 14, '9(14)', null],
            ['Nome do sacado', 235, 274, 40, 'X(40)', null],
            ['Endereço completo', 275, 314, 40, 'X(40)', null],
            ['Número da nota fiscal da duplicata', 315, 323, 9, 'X(9)', null],
            ['Número da série da nota fiscal da duplicata', 324, 326, 3, 'X(3)', null],
            ['CEP', 327, 334, 8, '9(8)', null],
            ['Cedente', 335, 394, 60, 'X(60)', null],
            ['Chave da nota', 395, 438, 44, 'X(44)', null],
            ['Nº sequencial do registro', 439, 444, 6, '9(6)', null],
        ];

        $this->validateFields($fields, $line, $errors);
    }

    private function validateCnab444Trailer($line, &$errors)
    {
        $fields = [
            ['Identificação do Registro', 1, 1, 1, '9(1)', '9'],
            ['Branco', 2, 438, 437, 'X(437)', str_repeat(' ', 437)],
            ['Nº Sequencial do Registro', 439, 444, 6, '9(6)', null],
        ];

        $this->validateFields($fields, $line, $errors);
    }

    private function validateFields(array $fields, $line, &$errors)
    {
        $layout = $this->layout;
        $lengthLine = strlen(trim($line));

        if ($lengthLine !== $layout) {
            $errors[] = "Comprimento do layout inválido. Esperado $layout caracteres e foram detectado $lengthLine.";
        }

        foreach ($fields as $index => $field) {
            $fieldNumber = $index + 1;
            $name = $field[0];
            $start = $field[1] - 1;
            $length = $field[3];
            $type = $field[4];
            $firstType = substr($type, 0, 1);
            $expectedValue = $field[5];

            $actualValue = mb_substr($line, $start, $length);

            if (strlen($actualValue) !== $length) {
                $errors[] = "Campo $fieldNumber: '$name' com comprimento inválido. Esperado $length caracteres.";
            }

            if ($expectedValue !== null && $actualValue !== $expectedValue) {
                if (rtrim($actualValue) !== rtrim($expectedValue)) {
                    $errors[] = "Campo $fieldNumber: '$name' com valor inválido. Esperado '$expectedValue', encontrado '$actualValue'.";
                }
            }

            if (is_numeric($firstType)) {
                if (trim($actualValue) !== '' && ! ctype_digit($actualValue)) {

                    $errors[] = "Campo $fieldNumber: '$name' com valor não numérico. Encontrado '$actualValue'.";
                }
            } else {
                if (preg_match('/[^A-Za-z0-9 .-]/', $actualValue)) {
                    $errors[] = "Campo $fieldNumber: '$name' contém caracteres inválidos. Encontrado '$actualValue'.";
                }
            }
        }

        return $errors;
    }
}
