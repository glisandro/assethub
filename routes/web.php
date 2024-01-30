<?php

use Inertia\Inertia;
use App\Models\Building;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\AssetsController;
use App\Http\Controllers\BuildingsController;
use App\Http\Controllers\UserIndexController;

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
    return redirect()->route('register');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        //Si no tiene building crear un por defecto
        //Este se debe poder editar para cambiar el nombre

        return redirect()
            ->route(
                'buildings.assets.index', 
                Building::firstOrCreate([
                    'name' =>'Building', 'user_id' => Auth::id()
                ])->id
            ); //TODO:Si no tiene buildings deberia redireccionar a uno por defecto o crear uno
    })->name('dashboard');
    /*
    Route::get('/buildings', [BuildingsController::class, 'Index'])
        ->name('buildings.index');*/

    //Route::resource('buildings', BuildingsController::class);

    Route::get('/buildings/index', [BuildingsController::class, 'index'])->name('buildings.index');
    Route::get('/buildings/create', [BuildingsController::class, 'create'])->name('buildings.create');
    Route::post('/buildings/store', [BuildingsController::class, 'store'])->name('buildings.store');
    Route::get('/buildings/{building}/assets', [AssetsController::class, 'index'])->name('buildings.assets.index');
    Route::get('/buildings/{building}/assets/create', [AssetsController::class, 'create'])->name('buildings.assets.create');
    Route::post('/buildings/{building}/assets/store', [AssetsController::class, 'store'])->name('buildings.assets.store');
    Route::get('/buildings/{building}/assets/edit/{asset}', [AssetsController::class, 'edit'])->name('buildings.assets.edit');
    Route::put('/buildings/{building}/assets/update/{asset}', [AssetsController::class, 'update'])->name('buildings.assets.update');
    //Redirige el menu Assets TODO:aca mismo tiene que redireccionar al primer building
    Route::get('/assets', [AssetsController::class, 'redirect'])
        ->name('assets.redirect');
});

//Route::resource('buildings.assets', AssetsController::class)->scoped([
    /*
    Comento porque si cambia el name cabia el slug y da error con return back()
    Para usarlo habria que validar que el name sea unico y no usar back()
    'building' => 'slug',
    'asset' => 'slug',*/
//]);

// Dejo esto solo para pruebas, deberia ser solo de acceso privado.
Route::get('/inertia-tables-test', UserIndexController::class)
    ->name('UsersIndex');

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});

require __DIR__.'/auth.php';