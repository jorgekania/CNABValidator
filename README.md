# Documentação do Sistema de Validação de Arquivos CNAB

![Imagem de demonstração de retorno da validação](https://github.com/jorgekania/CNABValidator/blob/jk/public/tela_exemplo_validador_cnab.png)

## Introdução

O Sistema de Validação de Arquivos CNAB é uma aplicação web desenvolvida com o framework Laravel v11.7.0 (PHP v8.2.18). Seu objetivo é permitir o upload de arquivos no formato CNAB (Centro Nacional de Automação Bancária) e validar se esses arquivos estão formatados corretamente de acordo com os layouts especificados.

## Implementações Futuras

-   [ ] Adicionar validação para CNAB 240
-   [ ] Adicionar validação para CNAB 400
-   [ ] Adicionar validação para CNAB de outros layouts
-   [x] Maior detalhamento campo a campo para facilitar o entendimento do usuário

Caso queria contribuir coim este projeto, faça um fork do mesmo e solicite uma PR, vamos colaborar

## Visão Geral

O sistema consiste em duas principais partes:

1.  **Frontend:** Uma interface web onde os usuários podem fazer upload de arquivos CNAB.
2.  **Backend:** Uma API RESTful para lidar com a validação dos arquivos.

## Exemplo de retorno

A chave `status` no Json de retorno, pode conter:

-   `error`: Quando algum campo do arquivo retornou erro na validação.
-   `success`: Quando todos os campos foram validados com sucesso.

Abaixo apenas um exemplo do retorno, porem o Json vem com todas as chaves contidas no layout que passaram pela validação.

```json
{
    "layout": 444,
    "status": "error",
    "response": {
        "header": [
            {
                "required": true,
                "validate": true,
                "field_number": 1,
                "field_name": "Identificação do Registro",
                "start_position": 1,
                "end_position": 1,
                "value": "0",
                "expected_value": "0",
                "format": "9(1)",
                "message": "Campo validado com sucesso"
            }
        ],
        "details": [
            {
                "required": true,
                "validate": true,
                "field_number": 1,
                "field_name": "Identificação do registro",
                "start_position": 1,
                "end_position": 1,
                "value": "1",
                "expected_value": "1",
                "format": "9(1)",
                "message": "Campo validado com sucesso"
            }
        ],
        "trailler": [
            {
                "required": true,
                "validate": true,
                "field_number": 1,
                "field_name": "Identificação do Registro",
                "start_position": 1,
                "end_position": 1,
                "value": "9",
                "expected_value": "9",
                "format": "9(1)",
                "message": "Campo validado com sucesso"
            }
        ]
    }
}
```

## Componentes Principais

### 1. Rotas Web

O sistema define duas rotas principais para interação com o frontend:

-   `/cnab`: Uma rota GET que exibe o formulário de upload do arquivo CNAB.
-   `/cnab/validate`: Uma rota POST que recebe o arquivo CNAB enviado pelo usuário e o valida.

### 2. Controlador CnabController

O `CnabController` é responsável por lidar com as solicitações relacionadas aos arquivos CNAB. Ele contém os seguintes métodos:

-   **`uploadForm()`:** Exibe o formulário de upload de arquivos CNAB.
-   **`validateCnab(Request $request)`:** Valida o arquivo CNAB enviado pelo usuário. Este método realiza as seguintes ações:
    -   Valida se um arquivo foi enviado e se está no formato esperado.
    -   Determina o layout do arquivo CNAB com base na primeira linha do arquivo.
    -   Valida o conteúdo do arquivo CNAB de acordo com o layout detectado.
    -   Retorna um JSON com os resultados da validação.

A classe `Service\CNABValidatorService` que recebe e processa a validação do arquivo.

### 3. Visualizações

O sistema possui uma visualização Blade para o formulário de upload de arquivos CNAB em `resources/views/layouts/app.blade.php`. Esta visualização contém um formulário simples que permite aos usuários fazerem upload de arquivos CNAB, após o processamento do formulário, caso a detecção do layout não de erro, é apresentada o resultado da validação campo a campo, facilitando ao usuário entender onde deve efetuar um determinada correção.

## Funcionamento da Validação

### Detecção do Layout

O sistema utiliza o comprimento da primeira linha do arquivo CNAB para determinar o layout do arquivo. Com base no comprimento, ele identifica se o arquivo segue os layouts de 240, 400 ou 444 caracteres.

### Validação do Conteúdo

Após determinar o layout, o sistema valida o conteúdo do arquivo CNAB de acordo com o layout detectado. Ele verifica se cada campo do arquivo está de acordo com as especificações do layout. Se forem encontrados erros, eles são registrados e retornados ao usuário.

### Determinação do Status da Validação

Depois de validar o conteúdo do arquivo, o sistema determina o status global da validação com base nos erros encontrados. Ele retorna "error" se houver erros críticos, "warning" se houver erros não críticos e "success" se o arquivo for validado com sucesso.

## Conclusão

O Sistema de Validação de Arquivos CNAB oferece uma maneira fácil e eficaz de validar arquivos CNAB. Ele permite aos usuários verificar rapidamente se seus arquivos estão formatados corretamente, garantindo assim uma integração suave com sistemas bancários.

##

**DCOUMENTAÇÃO FEBRABAN LAYOUT CNAB 444 - REMESSA (MERCADO)**

Regras Para Preenchimento Dos Campos

-   **Campos Numéricos:** Todos os campos numéricos devem ter seus conteúdos alinhados à direita. Quando não forem completamente preenchidos, as demais posições à esquerda devem conter zeros;
-
-   Campos não preenchidos deverão estar preenchidos com zeros;

-   **Campos alfanuméricos:** Na apresentação dos campos que compõem os registros do layout, os campos alfanuméricos estão representados pela simbologia: X(k), onde “k” indica o tamanho de caracteres do campo;

-   Todos os campos alfanuméricos devem ter seus conteúdos alinhados à esquerda. Quando não forem completamente preenchidas as demais posições à direita devem conter brancos (espaços);

-   Todos os caracteres deverão estar em maiúsculo não sendo permitidos caracteres especiais (ex.: “Ç”, “?”, “@”, etc.) e acentuados (ex.: “Á”, “É”, “Ê”, etc.);

-   **Valores monetários:** Os valores monetários deverão utilizar 2 (duas) casas decimais para sua formatação sem pontuação ou virgula para separação dos decimais;

-   Exemplo: Os valores deverão ser formatados da seguinte maneira:

| **Campo**        | **Formato** | **Valor lido no arquivo** | **Valor já formatado** |
| ---------------- | ----------- | ------------------------- | ---------------------- |
| Valor da parcela | 9(015)      | 000000000247056           | R$ 2.470,56            |

##

**REGISTRO HEADER**

| **Num** | **Nome do campo**                     | **Início** | **Fim** | **Tam.** | **Obrig.** | **Tip.(dig.)** | **Dec.** | **Conteúdo**                                                                                       |
| ------- | ------------------------------------- | ---------- | ------- | -------- | ---------- | -------------- | -------- | -------------------------------------------------------------------------------------------------- |
| 1       | Identificação do Registro             | 1          | 1       | 001      | Sim        | 9(1)           |          | 0                                                                                                  |
| 2       | Identificação do Arquivo Remessa      | 2          | 2       | 001      | Sim        | 9(1)           |          | 1                                                                                                  |
| 3       | Literal Remessa                       | 3          | 9       | 007      | Sim        | X(7)           |          | REMESSA                                                                                            |
| 4       | Código de Serviço                     | 10         | 11      | 002      | Sim        | 9(2)           |          | 01                                                                                                 |
| 5       | Literal Serviço                       | 12         | 26      | 015      | Sim        | X(15)          |          | COBRANCA                                                                                           |
| 6       | Código do Originador (Consultoria)    | 27         | 46      | 020      | Sim        | 9(20)          |          | <p>Será fornecido pelo Custodiante, quando do Cadastramento. </p><p>Vide tópico 2.1 - Seção A </p> |
| 7       | Nome do Originador (Consultoria)      | 47         | 76      | 030      | Sim        | X(30)          |          | Razão Social                                                                                       |
| 8       | Número do Banco                       | 77         | 79      | 003      | Sim        | 9(3)           |          | Número do Banco                                                                                    |
| 9       | Nome do Banco                         | 80         | 94      | 015      | Sim        | X(15)          |          | Nome do Banco                                                                                      |
| 10      | Data da Gravação do Arquivo           | 95         | 100     | 006      | Sim        | 9(6)           |          | <p>DDMMAA </p><p>Vide tópico 2.1 - Seção B </p>                                                    |
| 11      | Branco                                | 101        | 108     | 008      | Sim        | X(8)           |          | Branco                                                                                             |
| 12      | Identificação do Sistema              | 109        | 110     | 002      | Sim        | X(2)           |          | MX                                                                                                 |
| 13      | Nº Sequencial do Arquivo              | 111        | 117     | 007      | Sim        | 9(7)           |          | Sequencial                                                                                         |
| 14      | Número do banco                       | 118        | 120     | 003      | Não        | 9(3)           |          | Número do banco do cedente                                                                         |
| 15      | Número da agencia do banco            | 121        | 125     | 005      | Não        | 9(5)           |          | Agência do Cedente                                                                                 |
| 16      | Digito verificador da agencia         | 126        | 126     | 001      | Não        | 9(1)           |          | Dígito verificador da agência do cedente                                                           |
| 17      | Número da conta corrente              | 127        | 138     | 012      | Não        | 9(12)          |          | Número da conta corrente do cedente                                                                |
| 18      | Digito verificador da conta corrente  | 139        | 139     | 001      | Não        | 9(1)           |          | Dígito verificador da conta corrente do                                                            |
| 19      | Branco                                | 140        | 438     | 299      | Sim        | X(299)         |          | Branco                                                                                             |
| 20      | Nº Sequencial do Registro (de 1 em 1) | 439        | 444     | 006      | Sim        | 9(6)           |          | 000001                                                                                             |

##

**2.1. Descrição dos campos**

**A Nº do campo 6 - Código do Originador (Consultoria):** Será informado pelo
Custodiante, quando do cadastramento na Custódia.

**B Nº do campo 10 - Data da Gravação do Arquivo: 10:** Data do dia da Operação.

##

**REGISTRO DETALHE**

| **Num** | **Nome do campo**                                               | **Início** | **Fim** | **Tam.** | **Obrig.**                         | **Tip.(dig.)** | **Dec.** | **Conteúdo**                                                                                                                                       |
| ------- | --------------------------------------------------------------- | ---------- | ------- | -------- | ---------------------------------- | -------------- | -------- | -------------------------------------------------------------------------------------------------------------------------------------------------- |
| 1       | Identificação do registro                                       | 1          | 1       | 001      | Sim                                | 9(1)           |          | 1                                                                                                                                                  |
| 2       | Data de Carência                                                | 2          | 7       | 006      | Não                                | 9(6)           |          | DDMMAA Data de carência                                                                                                                            |
| 3       | Tipo de Juros                                                   | 8          | 8       | 001      | Não                                | 9(1)           |          | <p>0 - Título sem correção; </p><p>1 - Juros Fixo; 2 - CDI; </p><p>3 - IPCA-15; 4 - IPCA; </p><p>5 - IGPM; </p><p>Para recebíveis pós-fixados </p> |
| 4       | Branco                                                          | 9          | 10      | 002      | Não                                | X(2)           |          | Branco                                                                                                                                             |
| 5       | Taxa de Juros                                                   | 11         | 20      | 010      | Não                                | 9(10)          | 7        | Juros para a correção do título seja correção fixa ou % do indexador para recebíveis pós-fixados                                                   |
| 6       | Coobrigação                                                     | 21         | 22      | 002      | Sim                                | 9(2)           |          | <p>01 =com coobrigação </p><p>02 = sem coobrigação </p>                                                                                            |
| 7       | Característica especial                                         | 23         | 24      | 002      | Não                                | 9(2)           |          | <p>Src3040 do BACEN </p><p>Preencher de acordo com o anexo 8 </p>                                                                                  |
| 8       | Modalidade da operação                                          | 25         | 28      | 004      | Não                                | 9(4)           |          | <p>Src3040 do BACEN </p><p>Preencher de acordo com o anexo 3 </p><p>Preencher o domínio e o subdomínio </p>                                        |
| 9       | Natureza da operação                                            | 29         | 30      | 002      | Não                                | 9(2)           |          | <p>Src3040 do BACEN </p><p>Preencher de acordo com o anexo 2 </p>                                                                                  |
| 10      | Origem do recurso                                               | 31         | 34      | 004      | Não                                | 9(4)           |          | <p>Src3040 do BACEN </p><p>Preencher de acordo com o anexo 4 </p><p>Preencher o domínio e o subdomínio </p>                                        |
| 11      | Classe risco da operação                                        | 35         | 36      | 002      | Não                                | X(2)           |          | <p>Src3040 do BACEN </p><p>Preencher de acordo com o anexo 17 </p><p>Preencher da esquerda para direita </p>                                       |
| 12      | Zeros                                                           | 37         | 37      | 001      | Não                                | 9(1)           |          | Zeros                                                                                                                                              |
| 13      | Nº de controle do participante                                  | 38         | 62      | 025      | Sim                                | X(25)          |          | Número de identificação do título na consultoria (Este campo deve ser o mesmo informado ao banco cobrador)                                         |
| 14      | Número do banco                                                 | 63         | 65      | 003      | Sim Para cheque                    | 9(3)           |          | Número do banco pertencente ao cheque                                                                                                              |
| 15      | Zeros                                                           | 66         | 70      | 005      | Sim                                | 9(5)           |          | Zeros                                                                                                                                              |
| 16      | Identificação do título no banco                                | 71         | 81      | 011      | Não                                | 9(11)          |          | Branco                                                                                                                                             |
| 17      | Dígito do nosso número                                          | 82         | 82      | 001      | Não                                | X(1)           |          | Branco                                                                                                                                             |
| 18      | Valor pago                                                      | 83         | 92      | 010      | Sim para ocorrências de liquidação | 9(10)          | 2        | Se ocorrência diferente de liquidação preencher com zeros                                                                                          |
| 19      | Condição para emissão da papeleta de cobrança                   | 93         | 93      | 001      | Não                                | X(1)           |          | Branco                                                                                                                                             |
| 20      | Ident. Se emite papeleta para débito automático                 | 94         | 94      | 001      | Não                                | X(1)           |          | Branco                                                                                                                                             |
| 21      | Data da liquidação                                              | 95         | 100     | 006      | Sim Para ocorrências de liquidação | 9(6)           |          | <p>DDMMAA </p><p>(Somente para liquidação do título) </p>                                                                                          |
| 22      | Identificação da operação do banco                              | 101        | 104     | 004      | Não                                | X(4)           |          | Branco                                                                                                                                             |
| 23      | Indicador rateio crédito                                        | 105        | 105     | 001      | Não                                | X(1)           |          | Branco                                                                                                                                             |
| 24      | Endereçamento para aviso do débito automático em conta corrente | 106        | 106     | 001      | Não                                | X(1)           |          | Branco                                                                                                                                             |
| 25      | Branco                                                          | 107        | 108     | 002      | Não                                | X(2)           |          | Branco                                                                                                                                             |
| 26      | Identificação ocorrência                                        | 109        | 110     | 002      | Sim                                | 9(2)           |          | Vide seção 3.1 - seção A                                                                                                                           |
| 27      | Nº do documento                                                 | 111        | 120     | 010      | Sim                                | X(10)          |          | <p>Número de identificação do documento na consultoria </p><p>(Este campo deve ser o mesmo informado ao banco cobrador) </p>                       |
| 28      | Data do vencimento do título                                    | 121        | 126     | 006      | Sim                                | 9(6)           |          | DDMMAA                                                                                                                                             |
| 29      | <p>Valor do título (face) </p><p>(Valor nominal) </p>           | 127        | 139     | 013      | Sim                                | 9(13)          | 2        | <p>Valor do título Valor nominal do </p><p>título </p>                                                                                             |
| 30      | Banco encarregado da cobrança                                   | 140        | 142     | 003      | Não                                | 9(3)           |          | Nº do banco na câmara de compensação                                                                                                               |
| 31      | Agência depositária                                             | 143        | 147     | 005      | Não                                | 9(5)           |          | Código da agência depositária                                                                                                                      |
| 32      | Espécie de título                                               | 148        | 149     | 002      | Sim                                | 9(2)           |          | <p>01 - Duplicata; </p><p>02 - Nota promissória; </p><p>51 - Cheque; 60 - Contrato; ... </p><p>Vide tópico 3.1 - seção E </p>                      |
| 33      | Identificação                                                   | 150        | 150     | 001      | Não                                | X(1)           |          | Branco                                                                                                                                             |
| 34      | Data da emissão do título                                       | 151        | 156     | 006      | Sim                                | 9(6)           |          | DDMMAA                                                                                                                                             |
| 35      | 1ª instrução                                                    | 157        | 158     | 002      | Não                                | 9(2)           |          | 00                                                                                                                                                 |
| 36      | 2ª instrução                                                    | 159        | 159     | 001      | Não                                | 9(1)           |          | 0                                                                                                                                                  |
| 37      | Tipo de pessoa do cedente                                       | 160        | 161     | 02       | Sim                                | X(2)           |          | 01 - pessoa física; 02 - pessoa jurídica;                                                                                                          |
| 38      | Juros/Mora                                                      | 162        | 173     | 012      | Não                                | X(12)          | 7        | Juros a cobrar por dia de atraso                                                                                                                   |
| 39      | Número do termo de cessão                                       | 174        | 192     | 019      | Sim                                | X(19)          |          | Conforme número enviado pela consultoria                                                                                                           |
| 40      | <p>Valor presente da parcela </p><p>(Valor de aquisição) </p>   | 193        | 205     | 013      | Sim                                | 9(13)          | 2        | <p>Valor da parcela na data que foi cedida. </p><p>Valor de aquisição do título. </p>                                                              |
| 41      | Valor do abatimento                                             | 206        | 218     | 013      | Não                                | 9(13)          | 2        | Valor do abatimento a ser concedido na instrução                                                                                                   |
| 42      | Identificação do tipo de inscrição do sacado                    | 219        | 220     | 002      | Sim                                | 9(2)           |          | <p>01 - pessoa física; 02 - pessoa </p><p>jurídica; </p>                                                                                           |
| 43      | Nº inscrição do sacado                                          | 221        | 234     | 014      | Sim                                | 9(14)          |          | CNPJ/CPF                                                                                                                                           |
| 44      | Nome do sacado                                                  | 235        | 274     | 040      | Sim                                | X(40)          |          | Nome do sacado                                                                                                                                     |
| 45      | Endereço completo                                               | 275        | 314     | 040      | Sim                                | X(40)          |          | Endereço do sacado                                                                                                                                 |
| 46      | Número da nota fiscal da duplicata                              | 315        | 323     | 009      | Sim para duplicata                 | X(9)           |          | Número da nota fiscal da duplicata                                                                                                                 |
| 47      | Número da série da nota fiscal da duplicata                     | 324        | 326     | 003      | Não                                | X(3)           |          | Número da série da nota fiscal da duplicata                                                                                                        |
| 48      | CEP                                                             | 327        | 334     | 008      | Sim                                | 9(8)           |          | CEP do sacado                                                                                                                                      |
| 49      | Cedente                                                         | 335        | 394     | 060      | Sim                                | X(60)          |          | Decomposição Vide tópico 3.1 - seção D                                                                                                             |
| 50      | Chave da nota                                                   | 395        | 438     | 044      | Sim para duplicata                 | X(44)          |          | Chave da nota fiscal eletrônica                                                                                                                    |
| 51      | Nº sequencial do registro                                       | 439        | 444     | 006      | Sim                                | 9(6)           |          | Nº sequencial do registro                                                                                                                          |

##

**3.1. Descrição dos Campos**

**A Nº do campo 23 - Identificação de Ocorrência:**

-   01 - Remessa - aquisição de títulos;
-   04 - Abatimento (mediante justificativa);
-   **(Abatimento)**: o campo a ser preenchido com o valor do abatimento é a posição 206 a 218;
-   06 - Alteração de vencimento:
-   Para efeito de conciliação. Não altera o vencimento original;
-   14 - Pagamento parcial;
-   **(Pagamento Parcial, Recompra Parcial e Baixas):** o campo a ser preenchido com o valor pago é a posição 83 a 92;
-   71 - Baixa por recompra, baixa mediante entrada de novo título - com liquidação para a consultoria:
    -   Obrigatória contrapartida 81 no mesmo arquivo;
-   72 - Recompra parcial sem adiantamento;
-   73 - Recompra parcial com adiantamento;
-   74 - Baixa por recompra, baixa mediante entrada de novo título, com liquidação para o cedente:
    -   Obrigatória contrapartida 84 no mesmo arquivo;
-   75 - Baixa por depósito cedente;
-   77 - Baixa por depósito sacado;
-   76 - Baixa por depósito consultoria;
-   80 - Remessa - aquisição de títulos; (com liquidação para a consultoria)
-   81 - Entrada por recompra troca de títulos, com objetivo de recompra, com liquidação para a consultoria:
    -   Obrigatória contrapartida 71 no mesmo arquivo;
-   84 - Entrada por recompra troca de títulos, com liquidação para o cedente:
    -   Obrigatória contrapartida 74 no mesmo arquivo;
    -   Se tiver recompra dentro da operação enviar as entradas com o código 84;
-   87 - Reativação;
-   11 - Aquisição de contratos futuros;
-   12 - Aquisição de conciliação de contratos futuros;

**B Nº do campo 10 - Nº do Controle do Participante:** Este campo será considerado
como o Número de identificação do título no Banco. Deverá ser preenchido (esquerda para direita).

**C Nº do campo 39 - Número da Inscrição do Sacado:** Quando se tratar de CNPJ,
adotar o critério de preenchimento da direita para a esquerda.

**D Nº do campo 45 - Cedente - Decomposição do Campo:** Este campo deverá ser
preenchido (esquerda para direita) da seguinte maneira:

-   335 a 380: Nome do Cedente;
-   381 a 394: CNPJ do Cedente;

**E Nº do campo 29 - Espécie título:**

-   01 - Duplicata;
-   02 - Nota Promissória;
-   03 - Nota de Seguro;
-   04 - Cobrança Seriada;
-   05 - Recibo;
-   10 - Letras de Câmbio;
-   11 - Nota de Débito;
-   51 - Cheque;
-   87 - Cheque;
-   52 - CHEQUE - MANUAL;
-   60 - Contrato;
-   41 - CCB Digital;
-   13 - Precatórios;
-   14 - Duplicata de Serviço Físico;
-   06 - Nota Promissória Física;
-   65 - FATURA DE CARTAO DE CREDITO;
-   21 - RENEGOCIACAO DA DIVIDA;
-   61 - Contrato Físico;
-   62 - Confissão de Dívida;
-   64 - ASSUNCAO DE DIVIDA;
-   70 - CCB PRE DIGITAL;
-   71 - CCB PRE BALCAO;
-   72 - CCB PRE CETIP;
-   73 - Outros;
-   74 - CCB - FORMALIZACAO FONADA;

##

4.  **REGISTRO TRAILLER**

| **Num** | **Nome do campo**             | **Início** | **Fim** | **Tam.** | **Obrig.** | **Tip.(dig.)** | **Dec.** | **Conteúdo**                     |
| ------- | ----------------------------- | ---------- | ------- | -------- | ---------- | -------------- | -------- | -------------------------------- |
| 1       | Identificação registro        | 1          | 1       | 001      | Sim        | 9(1)           |          | 9                                |
| 2       | Branco                        | 2          | 438     | 437      | Sim        | X(437)         |          | Branco                           |
| 3       | Número sequencial de registro | 439        | 444     | 006      | Sim        | 9(6)           |          | Nº sequencial do último registro |
