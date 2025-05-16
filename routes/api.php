<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DealerController;
use App\Http\Controllers\APIVahanController;
use App\Http\Controllers\VahanController;
use App\Http\Controllers\VinController;
use App\Http\Controllers\CDRecordController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/vscrap/{cd_number}', [CDRecordController::class, 'fetchCDInfo']);

Route::group(['prefix' => 'dealer'], function () {
    Route::post('/userverify', [DealerController::class, 'userverify']);
    Route::post('/operator_auth', [DealerController::class, 'operator_auth']);
});

Route::group(['prefix' => 'buyer'], function () {
    Route::post('/buyerverify', [DealerController::class, 'buyerverify']);
    Route::post('/buyer_auth', [DealerController::class, 'buyer_auth']);
});

//ADV API

Route::post('/store/aadhar', 'AdvConnectorController@storeAadharNumber');
Route::get('/fetch/aadhar', 'AdvConnectorController@fetchAadharNumber');

Route::get('/pmedriveSMS', [APIVahanController::class,'nicpmedrive']);
Route::get('/get-model-count', [VahanController::class,'getModelCount']);
Route::post('fetchVin', [VinController::class, 'fetchVin']);