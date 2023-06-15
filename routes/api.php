<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('boletos/print/{uuid}', 'BoletosController@print');

Route::get('admin/test_nfse', 'ContratoController@emitirNFSe');

Route::get('admin/migrate', function () {
    return Artisan::call('migrate');
});

Route::get('admin/seed', function () {
    return Artisan::call('db:seed');
});


//login
Route::post('auth/login', 'AuthController@login');

//qz tray
Route::get('qz_assign/sign-message', function () {
    $KEY = 'private-key.pem';

    $req = $_GET['request']; //GET method
    //$req = $_POST['request']; //POST method

    $content = Storage::disk('public')->get("qz_sign/{$KEY}");

    $privateKey = openssl_get_privatekey($content);

    $signature = null;
    openssl_sign($req, $signature, $privateKey, "sha512"); // Use "sha1" for QZ Tray 2.0 and older

    if ($signature) {
        header("Content-type: text/plain");
        return response(base64_encode($signature));
    }

    return response('<h1>Error signing message</h1>');
});

Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => 'business'], function () {
        Route::get('', 'AdminController@listing');
        Route::post('', 'AdminController@create');
        Route::get('{id}', 'AdminController@getById');
        Route::put('{id}', 'AdminController@update');
    });
    Route::group(['prefix' => 'user'], function () {
        Route::get('', 'AdminController@getUsers');
        Route::post('', 'AdminController@createUser');
        Route::get('{id}', 'AdminController@getByIdUser');
        Route::put('{id}', 'AdminController@updateUser');
        Route::delete('{id}', 'AdminController@deleteUser');
    });
});


//rotas do frontend
Route::group(['middleware' => 'checkJWT'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('me', 'AuthController@me');
    });


    Route::group(['prefix' => 'user'], function () {

        Route::group(['prefix' => 'permission'], function () {
            Route::get('', 'UserController@listingPermissions');
            Route::post('', 'UserController@createPermission');
            Route::get('{id}', 'UserController@getPermissionById');
            Route::put('{id}', 'UserController@updatePermission');
            Route::delete('{id}', 'UserController@deletePermission');
        });

        Route::get('', 'UserController@listing');
        Route::post('', 'UserController@create');
        Route::get('{id}', 'UserController@getById');
        Route::put('{id}', 'UserController@update');
        Route::delete('{id}', 'UserController@delete');
    });


    Route::group(['prefix' => 'pessoal'], function () {

        Route::group(['prefix' => 'categoria'], function () {
            Route::get('', 'PessoalController@listingCategories');
            Route::post('', 'PessoalController@createCategory');
            Route::get('{id}', 'PessoalController@getCategoryById');
            Route::put('{id}', 'PessoalController@updateCategory');
            Route::delete('{id}', 'PessoalController@deleteCategory');
        });

        Route::get('', 'PessoalController@listing');
        Route::post('', 'PessoalController@create');
        Route::get('{id}', 'PessoalController@getById');
        Route::put('{id}', 'PessoalController@update');
        Route::delete('{id}', 'PessoalController@delete');
    });

    Route::group(['prefix' => 'cliente'], function () {

        Route::group(['prefix' => 'categoria'], function () {
            Route::get('', 'ClienteController@listingCategories');
            Route::post('', 'ClienteController@createCategory');
            Route::get('{id}', 'ClienteController@getCategoryById');
            Route::put('{id}', 'ClienteController@updateCategory');
            Route::delete('{id}', 'ClienteController@deleteCategory');
        });

        Route::group(['prefix' => 'contato'], function () {
            Route::get('', 'ClienteController@listingContato');
            Route::post('', 'ClienteController@createContato');
            Route::get('{id}', 'ClienteController@getContatoById');
            Route::put('{id}', 'ClienteController@updateContato');
            Route::delete('{id}', 'ClienteController@deleteContato');
        });

        Route::get('', 'ClienteController@listing');
        Route::post('', 'ClienteController@create');
        Route::get('{id}', 'ClienteController@getById');
        Route::put('{id}', 'ClienteController@update');
        Route::delete('{id}', 'ClienteController@delete');
    });

    Route::group(['prefix' => 'transportadora'], function () {

        Route::group(['prefix' => 'categoria'], function () {
            Route::get('', 'TransportadoraController@listingCategories');
            Route::post('', 'TransportadoraController@createCategory');
            Route::get('{id}', 'TransportadoraController@getCategoryById');
            Route::put('{id}', 'TransportadoraController@updateCategory');
            Route::delete('{id}', 'TransportadoraController@deleteCategory');
        });

        Route::group(['prefix' => 'contato'], function () {
            Route::get('', 'TransportadoraController@listingContato');
            Route::post('', 'TransportadoraController@createContato');
            Route::get('{id}', 'TransportadoraController@getContatoById');
            Route::put('{id}', 'TransportadoraController@updateContato');
            Route::delete('{id}', 'TransportadoraController@deleteContato');
        });

        Route::get('', 'TransportadoraController@listing');
        Route::post('', 'TransportadoraController@create');
        Route::get('{id}', 'TransportadoraController@getById');
        Route::put('{id}', 'TransportadoraController@update');
        Route::delete('{id}', 'TransportadoraController@delete');
    });

    Route::group(['prefix' => 'fornecedor'], function () {

        Route::group(['prefix' => 'categoria'], function () {
            Route::get('', 'FornecedorController@listingCategories');
            Route::post('', 'FornecedorController@createCategory');
            Route::get('{id}', 'FornecedorController@getCategoryById');
            Route::put('{id}', 'FornecedorController@updateCategory');
            Route::delete('{id}', 'FornecedorController@deleteCategory');
        });

        Route::group(['prefix' => 'contato'], function () {
            Route::get('', 'FornecedorController@listingContato');
            Route::post('', 'FornecedorController@createContato');
            Route::get('{id}', 'FornecedorController@getContatoById');
            Route::put('{id}', 'FornecedorController@updateContato');
            Route::delete('{id}', 'FornecedorController@deleteContato');
        });

        Route::get('', 'FornecedorController@listing');
        Route::post('', 'FornecedorController@create');
        Route::get('{id}', 'FornecedorController@getById');
        Route::put('{id}', 'FornecedorController@update');
        Route::delete('{id}', 'FornecedorController@delete');
    });

    Route::group(['prefix' => 'product'], function () {

        Route::group(['prefix' => 'categoria'], function () {
            Route::get('', 'ProductController@listingCategories');
            Route::post('', 'ProductController@createCategory');
            Route::get('{id}', 'ProductController@getCategoryById');
            Route::put('{id}', 'ProductController@updateCategory');
            Route::delete('{id}', 'ProductController@deleteCategory');
        });

        Route::group(['prefix' => 'galeria'], function () {
            Route::put('{id}', 'ProductController@checkFoto');
            Route::delete('{id}', 'ProductController@deleteFoto');
        });

        Route::get('', 'ProductController@listing');
        Route::post('', 'ProductController@create');
        Route::get('searchProduct', 'ProductController@searchProduct');

        Route::post('movimenta', 'ProductController@movimentaEstoque');
        Route::delete('movimenta/{id}', 'ProductController@movimentaEstoqueRemove');

        Route::get('{id}', 'ProductController@getById');
        Route::put('{id}', 'ProductController@update');
        Route::delete('{id}', 'ProductController@delete');
    });

    Route::group(['prefix' => 'sale'], function () {

        Route::group(['prefix' => 'item'], function () {
            // Route::get('', 'VendaController@listingItens');
            Route::post('', 'VendaController@createItem');
            Route::get('{id}', 'VendaController@getItemById');
            Route::put('{id}', 'VendaController@updateItem');
            Route::delete('{id}', 'VendaController@deleteItem');
        });

        Route::get('', 'VendaController@listing');
        Route::post('', 'VendaController@create');
        Route::post('finish', 'VendaController@finishSale');
        Route::post('emite_nfce/{id}', 'VendaController@EmiteNFCe');
        Route::get('{id}', 'VendaController@getById');
        Route::put('{id}', 'VendaController@update');
        Route::delete('{id}', 'VendaController@delete');
    });

    Route::group(['prefix' => 'contrato'], function () {

        Route::group(['prefix' => 'item'], function () {
            Route::get('', 'ContratoController@listingItens');
            Route::post('', 'ContratoController@createItem');
            Route::get('{id}', 'ContratoController@getItemById');
            Route::put('{id}', 'ContratoController@updateItem');
            Route::delete('{id}', 'ContratoController@deleteItem');
        });

        Route::get('', 'ContratoController@listing');
        Route::post('emite_nfse', 'ContratoController@emiteNFSe');
        Route::post('iniciar/{uuid}', 'ContratoController@iniciar');
        Route::post('', 'ContratoController@create');
        Route::get('{id}', 'ContratoController@getById');
        Route::put('{id}', 'ContratoController@update');
        Route::delete('{id}', 'ContratoController@delete');
    });

    Route::group(['prefix' => 'fiscal'], function () {

        Route::group(['prefix' => 'emitente'], function () {

            Route::group(['prefix' => 'config'], function () {
                Route::post('', 'EmitenteController@createEmitenteConfig');
                Route::get('', 'EmitenteController@getEmitenteConfig');
                Route::put('{id}', 'EmitenteController@updateEmitenteConfig');
                // Route::delete('{id}', 'EmitenteController@deleteEmitenteConfig');
            });

            Route::group(['prefix' => 'config-nfs'], function () {
                Route::post('', 'EmitenteController@createEmitenteConfigNfs');
                Route::get('', 'EmitenteController@getEmitenteConfigNfs');
                Route::put('{id}', 'EmitenteController@updateEmitenteConfigNfs');
                // Route::delete('{id}', 'EmitenteController@deleteEmitenteConfig');
            });

            Route::get('', 'EmitenteController@listingEmitente');
            Route::get('byConfig/{tipo}', 'EmitenteController@listingByConfig');
            Route::post('', 'EmitenteController@createEmitente');
            Route::get('{id}', 'EmitenteController@getEmitenteById');
            Route::put('{id}', 'EmitenteController@updateEmitente');
            Route::delete('{id}', 'EmitenteController@deleteEmitente');
        });

        Route::group(['prefix' => 'monitor-fiscal'], function () {
            Route::get('', 'FiscalController@listing');
            Route::get('search', 'FiscalController@searching');
            Route::post('manifestar', 'FiscalController@manifestaNFe');
            Route::post('getDadosXML', 'FiscalController@getDadosXML');
            Route::post('importXML', 'FiscalController@importDadosXML');
        });

        Route::group(['prefix' => 'nfe'], function () {

            Route::group(['prefix' => 'item'], function () {
                Route::post('', 'NFeController@createItemNota');
                Route::get('list/{id}', 'NFeController@getItensNota');
                Route::get('{id}', 'NFeController@getItemNota');
                Route::put('{id}', 'NFeController@updateItemNota');
                Route::delete('{id}', 'NFeController@deleteItemNota');
            });

            Route::group(['prefix' => 'payment'], function () {
                Route::post('', 'NFeController@createPaymentNota');
                Route::delete('{id}', 'NFeController@deletePaymentNota');
            });
            Route::group(['prefix' => 'reference'], function () {
                Route::post('', 'NFeController@createReferenceNota');
                Route::delete('{id}', 'NFeController@deleteReferenceNota');
            });

            Route::get('', 'NFeController@listing');
            Route::post('', 'NFeController@create');

            Route::post('emitir/{id}', 'NFeController@EmitirNFe');
            Route::post('cancelar/{id}', 'NFeController@cancelarNFe');

            Route::get('{id}', 'NFeController@getById');
            Route::put('{id}', 'NFeController@update');
        });

        Route::get('references', 'FiscalController@getListingReferences');
    });

    Route::group(['prefix' => 'finance'], function () {

        Route::group(['prefix' => 'payment-forms'], function () {
            Route::get('', 'FinanceController@listingForma');
            Route::post('', 'FinanceController@createForma');
            Route::get('{id}', 'FinanceController@getFormaById');
            Route::put('{id}', 'FinanceController@updateForma');
            Route::delete('{id}', 'FinanceController@deleteForma');
        });

        Route::group(['prefix' => 'caixa'], function () {
            Route::get('', 'FinanceController@listingCaixa');
            Route::post('', 'FinanceController@createCaixa');
            Route::get('{id}', 'FinanceController@getCaixaById');
            Route::put('{id}', 'FinanceController@updateCaixa');
            Route::delete('{id}', 'FinanceController@deleteCaixa');
        });

        Route::group(['prefix' => 'receita'], function () {

            Route::group(['prefix' => 'categoria'], function () {
                Route::get('', 'FinanceController@listingReceitaCategories');
                Route::post('', 'FinanceController@createReceitaCategory');
                Route::get('{id}', 'FinanceController@getReceitaCategoryById');
                Route::put('{id}', 'FinanceController@updateReceitaCategory');
                Route::delete('{id}', 'FinanceController@deleteReceitaCategory');
            });

            Route::get('', 'FinanceController@listingReceita');
            Route::post('', 'FinanceController@createReceita');
            Route::post('payment', 'FinanceController@paymentReceita');
            Route::get('{id}', 'FinanceController@getReceitaById');
            Route::put('{id}', 'FinanceController@updateReceita');
            Route::delete('{id}', 'FinanceController@deleteReceita');
        });

        Route::group(['prefix' => 'conta'], function () {

            Route::group(['prefix' => 'categoria'], function () {
                Route::get('', 'FinanceController@listingContaCategories');
                Route::post('', 'FinanceController@createContaCategory');
                Route::get('{id}', 'FinanceController@getContaCategoryById');
                Route::put('{id}', 'FinanceController@updateContaCategory');
                Route::delete('{id}', 'FinanceController@deleteContaCategory');
            });

            Route::get('', 'FinanceController@listingConta');
            Route::post('', 'FinanceController@createConta');
            Route::post('payment', 'FinanceController@paymentConta');
            Route::get('{id}', 'FinanceController@getContaById');
            Route::put('{id}', 'FinanceController@updateConta');
            Route::delete('{id}', 'FinanceController@deleteConta');
        });
    });

    Route::group(['prefix' => 'company'], function () {
        Route::get('', 'CompanyController@listing');
        Route::post('', 'CompanyController@create');
        Route::get('{id}', 'CompanyController@getById');
        Route::put('{id}', 'CompanyController@update');
        Route::delete('{id}', 'CompanyController@delete');
    });

    Route::resource('tipos-categoria', 'TiposCategoriaController');
    Route::resource('categorias', 'CategoriasController');


    Route::get('cfg-boletos/getByEmitente/{id}', 'CfgBoletosController@getByEmitente');
  //  Route::get('cfg-boletos', 'CfgBoletosController@index');
    Route::resource('cfg-boletos', 'CfgBoletosController');

    Route::resource('boletos', 'BoletosController');

    Route::post('financeiro/gerar/{uuid}', 'FinanceController@gerar');


    Route::get('aliquotas/getByEmitente/{id}', 'AliquotasController@getByEmitente');
    Route::resource('aliquotas', 'AliquotasController');


    Route::get('fiscal/NFSe', 'FiscalController@listingNFSe');

###insertNewRoute
});
