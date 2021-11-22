<?php

use App\Http\Controllers\Admin\AsignacionController;
use App\Http\Controllers\Admin\CuadranteController;
use App\Http\Controllers\Admin\PoliciaController;
use App\Http\Controllers\Admin\RangoController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PoliciaController as FrontPoliciaController;
use App\Http\Controllers\Admin\InvitacionController;
use App\Http\Controllers\InvitacionController as FrontInvitacionController;
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
    return redirect('/login');
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
});

Route::middleware('guest')
    ->get('admin/login', [\App\Http\Controllers\Admin\LoginController::class, 'index'])
    ->name('admin.login.index');

Route::middleware(['auth'])->group(function () {

    Route::middleware('is_admin')->group(function () {
        Route::get('admin/policia', [PoliciaController::class, 'index'])->name('policia.index');
        Route::get('admin/policia/all', [PoliciaController::class, 'all'])->name('policia.all');
        Route::post('admin/policia', [PoliciaController::class, 'save'])->name('policia.save');
        Route::patch('admin/policia/{policia}', [PoliciaController::class, 'update'])->name('policia.update');
        Route::patch('admin/policia/{policia}/restablecer/clave', [PoliciaController::class, 'restablecerClave'])->name('policia.restablecer.clave');
        Route::get('admin/rango/{rango}/policia/', [PoliciaController::class, 'policiaPorRango'])->name('rango.policia');
        Route::get('admin/policia/exportar', [PoliciaController::class, 'exportar'])->name('policia.exportar');
        Route::get('admin/policia/pdf/exportar', [PoliciaController::class, 'exportarPDF'])->name('policia.pdf.exportar');
        Route::get('admin/policia/pdf/exportar/individual/{policia}', [PoliciaController::class, 'exportarIndividualPDF'])->name('policia.pdf.exportar.individual');

        Route::get('admin/rango/all', [RangoController::class, 'getAllRangos'])->name('rango.all');
        Route::get('admin/rango', [RangoController::class, 'index'])->name('rango.index');
        Route::post('admin/rango', [RangoController::class, 'save'])->name('rango.save');
        Route::patch('admin/rango/{rango}', [RangoController::class, 'update'])->name('rango.update');

        Route::get('admin/cuadrante', [CuadranteController::class, 'index'])->name('cuadrante.index');
        Route::get('admin/cuadrante/distribucion', [CuadranteController::class, 'distribucionMesasYSillas'])->name('cuadrante.distribucion');
        Route::get('admin/cuadrante/create', [CuadranteController::class, 'createAll'])->name('cuadrante.create');
        Route::patch('admin/cuadrante/{cuadrante}', [CuadranteController::class, 'update'])->name('cuadrante.update');

        Route::get('admin/mesa/sillas/asignadas', [CuadranteController::class, 'asignacionSillasAMesas'])->name('mesa.sillas.asinadas');
        Route::post('admin/asignacion', [AsignacionController::class, 'save'])->name('asignacion.save');
        Route::delete('asignacion/{silla}/{policia}', [AsignacionController::class, 'delete'])->name('asignacion.delete');

        Route::get('/admin/invitacion/', [InvitacionController::class, 'index'])->name('invitacion.index');
        Route::post('/admin/invitacion/', [InvitacionController::class, 'save'])->name('invitacion.save');
        Route::post('/admin/invitacion/enviar/todas', [InvitacionController::class, 'enviarTodas'])->name('invitacion.enviar.todas');
        Route::post('/admin/invitacion/reenviar', [InvitacionController::class, 'reenviar'])->name('invitacion.reenviar');
        Route::get('/admin/invitacion/pdf/exportar', [InvitacionController::class, 'exportarPDF'])->name('invitacion.pdf.exportar');
        Route::get('/admin/invitacion/exportar', [InvitacionController::class, 'exportar'])->name('invitacion.exportar');

        Route::get('admin/user', [UserController::class, 'index'])->name('user.index');
        Route::get('admin/user/all', [UserController::class, 'all'])->name('user.all');
        Route::post('admin/user', [UserController::class, 'save'])->name('user.save');
        Route::patch('admin/user/{user}', [UserController::class, 'update'])->name('user.update');

        Route::get('admin/delegados/listado', [InvitacionController::class, 'reporteListado'])->name('policia.reporte.listado');

    });

    Route::get('/escanear-invitacion', [InvitacionController::class, 'escanearCodigoQR'])->name('invitacion.escanear');
    Route::get('/invitacion/comprobar/{codigoInvitacion}',
        [InvitacionController::class, 'obtenerDatosInvitacion'])
        ->name('invitacion.comprobar')
        ->whereUuid('codigoInvitacion');

    Route::post('/invitacion/confirmar/asistencia', [InvitacionController::class, 'confirmarAsistencia'])->name('invitacion.asistencia.confirmar');

});


Route::middleware('auth')->name('front.')->group(function () {

    Route::get('front/policia', [FrontPoliciaController::class, 'index'])->name('policia.index');
    Route::get('front/policia/logged', [FrontPoliciaController::class, 'get'])->name('policia.logged.get');
    Route::patch('front/policia/{policia}', [FrontPoliciaController::class, 'update'])->name('policia.update');
    Route::get('front/policia/photo', [FrontPoliciaController::class, 'testPhoto'])->name('policia.test.photo');
    Route::post('front/policia/photo', [FrontPoliciaController::class, 'updatePhoto'])->name('policia.update.photo');

    Route::get('front/invitacion/confirmar/{codigoInvitacion}', [FrontInvitacionController::class, 'confirm'])
        ->name('invitacion.confirm')
        ->whereUuid('codigoInvitacion');

    Route::post('front/invitacion', [FrontInvitacionController::class, 'save'])->name('invitacion.save');
    Route::get('front/codigo-invitacion/{codigoInvitacion}', [FrontInvitacionController::class, 'codigoInvitacion'])
        ->name('invitacion.codigo')
        ->whereUuid('codigoInvitacion');

});


Route::middleware(['auth:sanctum', 'verified'])->get('/home', [HomeController::class, 'redirect'])->name('home');
