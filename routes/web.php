<?php

use App\Http\Controllers\Admin\ApartmentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*ROTTE PER GUEST
---------------------------------------------------------------
---------------------------------------------------------------*/
// ----home
Route::get('/', function () {
    return view('/guest/home');
})->name('guest-home');


//---single apartment
Route::get('/single/{id}', 'HomeController@show')->name('guest_show_apartment');
// mandare un messaggio da pagina single apartment
Route::post('/single', 'Admin\MessageController@store')->name('saveMessage');


// -----ricerca avanzata
Route::get('/search', function () {
    return view('/guest/search');
})->name('search');


/*ROTTA PER AUTENTICAZIONE
-----------------------------------------------------------
----------------------------------------------------------*/


Auth::routes();

/*ROTTE SEZIONE ADMIN
-------------------------------------------------------------
------------------------------------------------------------*/

Route::prefix('admin')
    ->namespace('Admin')
    ->middleware('auth')
    ->group(function () {
        Route::get('/', 'HomeController@index')->name('admin_homepage');
        Route::resource('/messages', 'MessageController');
        Route::get('/messages/list/{id_apt}', 'MessageController@index')->name('messages.index');
        Route::resource('/apartments','ApartmentController');
        Route::get('/statistics/{id_apt}','HomeController@statistics')->name('admin.statistics.index');
        Route::get('/sponsorships','HomeController@sponsorship')->name('admin.sponsorships.index');

        // pagamenti
        Route::get('/payment/make','PaymentController@make')->name('admin.payments.make');
        Route::get('/payment','PaymentController@index')->name('admin.payments.index');

        Route::get('/create-sponsorship/{apt_id}/{spons_id}/{status}','SponsorshipController@store')->name('admin.sponsorships.store');

    });
