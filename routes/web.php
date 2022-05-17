<?php

use App\Http\Controllers\AssetsController;
use App\Http\Controllers\BuildingsController;
use App\Http\Controllers\UserIndexController;
use App\Models\Building;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    //Si no tiene building crear un por defecto
    //Este se debe poder editar para cambiar el nombre

    return redirect()->route('buildings.assets.index', Building::firstOrCreate(['name' =>'Building', 'team_id' => 1])->id); //TODO:Si no tiene buildings deberia redireccionar a uno por defecto o crear uno
});
/*
Route::get('/buildings', [BuildingsController::class, 'Index'])
    ->name('buildings.index');*/

Route::resource('buildings', BuildingsController::class);

//Redirige el menu Assets TODO:aca mismo tiene que redireccionar al primer building
Route::get('/assets', [AssetsController::class, 'redirect'])
    ->name('assets.redirect');

Route::resource('buildings.assets', AssetsController::class)->scoped([
    /*
    Comento porque si cambia el name cabia el slug y da error con return back()
    Para usarlo habria que validar que el name sea unico y no usar back()
    'building' => 'slug',
    'asset' => 'slug',*/
]);

// Dejo esto solo para pruebas, deberia ser solo de acceso privado.
Route::get('/inertia-tables-test', UserIndexController::class)
    ->name('UsersIndex');

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});
