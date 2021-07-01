<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Tentativi di chiamate API a DB

Route::get('/apartments','Api\ApartmentController@index');
Route::post('/apartments/search','Api\ApartmentController@search');

// - Tutti gli apt disponibili per una data località ed un dato raggio
Route::get('/location','Api\ApartmentController@location');

// - Lista di tutti i servizi esistenti
Route::get('/services','Api\ApartmentController@services');

// - Tutti gli apt sponsorizzati
Route::get('/getSponsoredApt','Api\ApartmentController@getSponsoredApt');

// - lista apt filtrati per user
Route::get('/getAptUserList','Api\ApartmentController@getAptUserList');

// - appartamenti utente filtrati per sponsorizzazione
Route::get('/getUserSponsoredAptList','Api\ApartmentController@getUserSponsoredAptList');