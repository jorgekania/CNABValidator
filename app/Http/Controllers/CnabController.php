<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\CNABValidatorService;

class CnabController extends Controller
{
    protected int $layout;

    public function uploadForm()
    {
        return view('cnab.upload');
    }

    public function validateCnab(Request $req)
    {
        $validate =  app(CNABValidatorService::class)->validateCnab($req);

        if($validate->content() > 0){

            $returnJson = json_decode($validate->content());

            return view('cnab.upload')->with('validate', $returnJson);
        }else{
            return view('cnab.upload')->with('error', 'Não foi possível validar o arquivo!');
        }

    }
}
