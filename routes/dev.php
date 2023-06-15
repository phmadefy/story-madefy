<?php

use App\Models\Contrato;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use NFePHP\Common\Certificate;
use NFePHP\NFSeAmtec\Common\Soap\SoapCurl;

Route::get('teste', function(\Illuminate\Http\Request $request){
 //  return (new \App\Repositories\CategoriasRepository())->index($request);
 // return  openssl_get_cert_locations();

  //  $cfg = \App\Models\CfgBoletos::find(2);
    return (new \App\Services\BoletoBBService())->emitirBoleto('bd7cd61b-3e05-424e-9f71-27de12f5cbc8');
});

Route::get('teste', function(\Illuminate\Http\Request $request){
    //  return (new \App\Repositories\CategoriasRepository())->index($request);
    // return  openssl_get_cert_locations();

    //  $cfg = \App\Models\CfgBoletos::find(2);
    return (new \App\Services\BoletoBBService())->emitirBoleto('bd7cd61b-3e05-424e-9f71-27de12f5cbc8');
});

Route::get('print', function(\Illuminate\Http\Request $request){

    $emitente = \App\Models\Emitente::where('uuid', '=', '817c8291-b6b4-473d-8d88-4811284c8f8a')->first();

    $nfe = (new \App\Services\NFSeGoService($emitente));

   return $nfe->make([]);
});
