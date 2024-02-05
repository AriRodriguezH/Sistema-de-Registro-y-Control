<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CambiarPasswordController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\DataTableController;
use App\Http\Controllers\ProcesoA;
use App\Http\Controllers\ProcesoB;
use App\Http\Controllers\ProcesoC;
use App\Http\Controllers\ProcesoD;
use App\Http\Controllers\ProcesoE;
use App\Http\Controllers\ProcesoF;
use App\Http\Controllers\ProcesoG;
use App\Http\Controllers\ProcesoH;
use App\Http\Controllers\ProcesoI;
use App\Http\Controllers\ProcesoJ;
use Dompdf\Dompdf;
use App\Http\Controllers\PdfController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('/auth/login');
});
/* Ruta que contiene el registro del usuario principal
Route::get('/', function () {
    return view('/home');
});*/

Auth::routes();

Route::get('/mgsi', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('admin', PerfilController::class);
    Route::resource('roles', RolController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('blogs', BlogController::class);
    Route::get('/grafica-cumplimiento', [UsuarioController::class, 'mostrarGraficaCumplimiento'])->name('UsuarioController.graficaCumplimientoTodosProcesos');
    Route::get('/grafica-cumplimiento-Donas', [UsuarioController::class, 'mostrarGraficaDonas'])->name('UsuarioController.mostrarGraficaDonas');

    Route::resource('procesoA', ProcesoA::class);
    Route::get('procesoA/{id}/editar', [ProcesoA::class, 'edit'])->name('procesoA.editar');
    Route::get('procesoA/{id}/responder/{documentacionId}',[ProcesoA::class, 'responder'] )->name('procesoA.responder');
    Route::get('procesoA/{documentacionId}/ver-respuesta', [ProcesoA::class, 'verRespuesta'])->name('procesoA.verRespuesta');
    Route::post('procesoA/{documentacionId}/guardar-respuesta', [ProcesoA::class, 'guardarRespuesta'])->name('procesoA.guardarRespuesta');
    Route::put('procesoA/actualizar-respuesta/{id}', [ProcesoA::class, 'actualizarRespuesta'])->name('procesoA.actualizarRespuesta');
    Route::get('procesoA/descargar-archivos/{id}', [ProcesoA::class, 'descargarArchivos'])->name('procesoA.descargarArchivos');
    Route::get('procesoA/calificar/{id}', [ProcesoA::class, 'calificar'])->name('procesoA.calificar');
    Route::post('procesoA/calificar-respuesta', [ProcesoA::class, 'calificarRespuesta'])->name('procesoA.calificarRespuesta');
    Route::post('procesoA/actualizar-calificacion/{calificacionId}', [ProcesoA::class, 'actualizarCalificacion'])->name('procesoA.actualizarCalificacion');
    Route::get('/graficasA', [ProcesoA::class, 'graficaDocumentacionCompletaPorAnio'])->name('procesoA.graficaDocumentacionCompletaPorAnio');    

    Route::resource('procesoB', ProcesoB::class);
    Route::get('procesoB/{id}/editar', [ProcesoB::class, 'edit'])->name('procesoB.editar');
    Route::get('procesoB/{id}/responder/{documentacionId}',[ProcesoB::class, 'responder'] )->name('procesoB.responder');
    Route::get('procesoB/{documentacionId}/ver-respuesta', [ProcesoB::class, 'verRespuesta'])->name('procesoB.verRespuesta');
    Route::post('procesoB/{documentacionId}/guardar-respuesta', [ProcesoB::class, 'guardarRespuesta'])->name('procesoB.guardarRespuesta');
    Route::put('procesoB/actualizar-respuesta/{id}', [ProcesoB::class, 'actualizarRespuesta'])->name('procesoB.actualizarRespuesta');
    Route::get('procesoB/descargar-archivos/{id}', [ProcesoB::class, 'descargarArchivos'])->name('procesoB.descargarArchivos');
    Route::get('procesoB/calificar/{id}', [ProcesoB::class, 'calificar'])->name('procesoB.calificar');
    Route::post('procesoB/calificar-respuesta', [ProcesoB::class, 'calificarRespuesta'])->name('procesoB.calificarRespuesta');
    Route::post('procesoB/actualizar-calificacion/{calificacionId}', [ProcesoB::class, 'actualizarCalificacion'])->name('procesoB.actualizarCalificacion');
    Route::get('/graficasB', [ProcesoB::class, 'graficaDocumentacionCompletaPorAnio'])->name('procesoB.graficaDocumentacionCompletaPorAnio');    

    Route::resource('procesoC', ProcesoC::class);
    Route::get('procesoC/{id}/editar', [ProcesoC::class, 'edit'])->name('procesoC.editar');
    Route::get('procesoC/{id}/responder/{documentacionId}',[ProcesoC::class, 'responder'] )->name('procesoC.responder');
    Route::get('procesoC/{documentacionId}/ver-respuesta', [ProcesoC::class, 'verRespuesta'])->name('procesoC.verRespuesta');
    Route::post('procesoC/{documentacionId}/guardar-respuesta', [ProcesoC::class, 'guardarRespuesta'])->name('procesoC.guardarRespuesta');
    Route::put('procesoC/actualizar-respuesta/{id}', [ProcesoC::class, 'actualizarRespuesta'])->name('procesoC.actualizarRespuesta');
    Route::get('procesoC/descargar-archivos/{id}', [ProcesoC::class, 'descargarArchivos'])->name('procesoC.descargarArchivos');
    Route::get('procesoC/calificar/{id}', [ProcesoC::class, 'calificar'])->name('procesoC.calificar');
    Route::post('procesoC/calificar-respuesta', [ProcesoC::class, 'calificarRespuesta'])->name('procesoC.calificarRespuesta');
    Route::post('procesoC/actualizar-calificacion/{calificacionId}', [ProcesoC::class, 'actualizarCalificacion'])->name('procesoC.actualizarCalificacion');
    Route::get('/graficasC', [ProcesoC::class, 'graficaDocumentacionCompletaPorAnio'])->name('procesoC.graficaDocumentacionCompletaPorAnio');    

    Route::resource('procesoD', ProcesoD::class);
    Route::get('procesoD/{id}/editar', [ProcesoD::class, 'edit'])->name('procesoD.editar');
    Route::get('procesoD/{id}/responder/{documentacionId}',[ProcesoD::class, 'responder'] )->name('procesoD.responder');
    Route::get('procesoD/{documentacionId}/ver-respuesta', [ProcesoD::class, 'verRespuesta'])->name('procesoD.verRespuesta');
    Route::post('procesoD/{documentacionId}/guardar-respuesta', [ProcesoD::class, 'guardarRespuesta'])->name('procesoD.guardarRespuesta');
    Route::put('procesoD/actualizar-respuesta/{id}', [ProcesoD::class, 'actualizarRespuesta'])->name('procesoD.actualizarRespuesta');
    Route::get('procesoD/descargar-archivos/{id}', [ProcesoD::class, 'descargarArchivos'])->name('procesoD.descargarArchivos');
    Route::get('procesoD/calificar/{id}', [ProcesoD::class, 'calificar'])->name('procesoD.calificar');
    Route::post('procesoD/calificar-respuesta', [ProcesoD::class, 'calificarRespuesta'])->name('procesoD.calificarRespuesta');
    Route::post('procesoD/actualizar-calificacion/{calificacionId}', [ProcesoD::class, 'actualizarCalificacion'])->name('procesoD.actualizarCalificacion');
    Route::get('/graficasD', [ProcesoD::class, 'graficaDocumentacionCompletaPorAnio'])->name('procesoD.graficaDocumentacionCompletaPorAnio');    

    Route::resource('procesoE', ProcesoE::class);
    Route::get('procesoE/{id}/editar', [ProcesoE::class, 'edit'])->name('procesoE.editar');
    Route::get('procesoE/{id}/responder/{documentacionId}',[ProcesoE::class, 'responder'] )->name('procesoE.responder');
    Route::get('procesoE/{documentacionId}/ver-respuesta', [ProcesoE::class, 'verRespuesta'])->name('procesoE.verRespuesta');
    Route::post('procesoE/{documentacionId}/guardar-respuesta', [ProcesoE::class, 'guardarRespuesta'])->name('procesoE.guardarRespuesta');
    Route::put('procesoE/actualizar-respuesta/{id}', [ProcesoE::class, 'actualizarRespuesta'])->name('procesoE.actualizarRespuesta');
    Route::get('procesoE/descargar-archivos/{id}', [ProcesoE::class, 'descargarArchivos'])->name('procesoE.descargarArchivos');
    Route::get('procesoE/calificar/{id}', [ProcesoE::class, 'calificar'])->name('procesoE.calificar');
    Route::post('procesoE/calificar-respuesta', [ProcesoE::class, 'calificarRespuesta'])->name('procesoE.calificarRespuesta');
    Route::post('procesoE/actualizar-calificacion/{calificacionId}', [ProcesoE::class, 'actualizarCalificacion'])->name('procesoE.actualizarCalificacion');
    Route::get('/graficasE', [ProcesoE::class, 'graficaDocumentacionCompletaPorAnio'])->name('procesoE.graficaDocumentacionCompletaPorAnio');    

    Route::resource('procesoF', ProcesoF::class);
    Route::get('procesoF/{id}/editar', [ProcesoF::class, 'edit'])->name('procesoF.editar');
    Route::get('procesoF/{id}/responder/{documentacionId}',[ProcesoF::class, 'responder'] )->name('procesoF.responder');
    Route::get('procesoF/{documentacionId}/ver-respuesta', [ProcesoF::class, 'verRespuesta'])->name('procesoF.verRespuesta');
    Route::post('procesoF/{documentacionId}/guardar-respuesta', [ProcesoF::class, 'guardarRespuesta'])->name('procesoF.guardarRespuesta');
    Route::put('procesoF/actualizar-respuesta/{id}', [ProcesoF::class, 'actualizarRespuesta'])->name('procesoF.actualizarRespuesta');
    Route::get('procesoF/descargar-archivos/{id}', [ProcesoF::class, 'descargarArchivos'])->name('procesoF.descargarArchivos');
    Route::get('procesoF/calificar/{id}', [ProcesoF::class, 'calificar'])->name('procesoF.calificar');
    Route::post('procesoF/calificar-respuesta', [ProcesoF::class, 'calificarRespuesta'])->name('procesoF.calificarRespuesta');
    Route::post('procesoF/actualizar-calificacion/{calificacionId}', [ProcesoF::class, 'actualizarCalificacion'])->name('procesoF.actualizarCalificacion');
    Route::get('/graficasF', [ProcesoF::class, 'graficaDocumentacionCompletaPorAnio'])->name('procesoF.graficaDocumentacionCompletaPorAnio');    

    Route::resource('procesoG', ProcesoG::class);
    Route::get('procesoG/{id}/editar', [ProcesoG::class, 'edit'])->name('procesoG.editar');
    Route::get('procesoG/{id}/responder/{documentacionId}',[ProcesoG::class, 'responder'] )->name('procesoG.responder');
    Route::get('procesoG/{documentacionId}/ver-respuesta', [ProcesoG::class, 'verRespuesta'])->name('procesoG.verRespuesta');
    Route::post('procesoG/{documentacionId}/guardar-respuesta', [ProcesoG::class, 'guardarRespuesta'])->name('procesoG.guardarRespuesta');
    Route::put('procesoG/actualizar-respuesta/{id}', [ProcesoG::class, 'actualizarRespuesta'])->name('procesoG.actualizarRespuesta');
    Route::get('procesoG/descargar-archivos/{id}', [ProcesoG::class, 'descargarArchivos'])->name('procesoG.descargarArchivos');
    Route::get('procesoG/calificar/{id}', [ProcesoG::class, 'calificar'])->name('procesoG.calificar');
    Route::post('procesoG/calificar-respuesta', [ProcesoG::class, 'calificarRespuesta'])->name('procesoG.calificarRespuesta');
    Route::post('procesoG/actualizar-calificacion/{calificacionId}', [ProcesoG::class, 'actualizarCalificacion'])->name('procesoG.actualizarCalificacion');
    Route::get('/graficasG', [ProcesoG::class, 'graficaDocumentacionCompletaPorAnio'])->name('procesoG.graficaDocumentacionCompletaPorAnio');    

    Route::resource('procesoH', ProcesoH::class);
    Route::get('procesoH/{id}/editar', [ProcesoH::class, 'edit'])->name('procesoH.editar');
    Route::get('procesoH/{id}/responder/{documentacionId}',[ProcesoH::class, 'responder'] )->name('procesoH.responder');
    Route::get('procesoH/{documentacionId}/ver-respuesta', [ProcesoH::class, 'verRespuesta'])->name('procesoH.verRespuesta');
    Route::post('procesoH/{documentacionId}/guardar-respuesta', [ProcesoH::class, 'guardarRespuesta'])->name('procesoH.guardarRespuesta');
    Route::put('procesoH/actualizar-respuesta/{id}', [ProcesoH::class, 'actualizarRespuesta'])->name('procesoH.actualizarRespuesta');
    Route::get('procesoH/descargar-archivos/{id}', [ProcesoH::class, 'descargarArchivos'])->name('procesoH.descargarArchivos');
    Route::get('procesoH/calificar/{id}', [ProcesoH::class, 'calificar'])->name('procesoH.calificar');
    Route::post('procesoH/calificar-respuesta', [ProcesoH::class, 'calificarRespuesta'])->name('procesoH.calificarRespuesta');
    Route::post('procesoH/actualizar-calificacion/{calificacionId}', [ProcesoH::class, 'actualizarCalificacion'])->name('procesoH.actualizarCalificacion');
    Route::get('/graficasH', [ProcesoH::class, 'graficaDocumentacionCompletaPorAnio'])->name('procesoH.graficaDocumentacionCompletaPorAnio');    

    Route::resource('procesoI', ProcesoI::class);
    Route::get('procesoI/{id}/editar', [ProcesoI::class, 'edit'])->name('procesoI.editar');
    Route::get('procesoI/{id}/responder/{documentacionId}',[ProcesoI::class, 'responder'] )->name('procesoI.responder');
    Route::get('procesoI/{documentacionId}/ver-respuesta', [ProcesoI::class, 'verRespuesta'])->name('procesoI.verRespuesta');
    Route::post('procesoI/{documentacionId}/guardar-respuesta', [ProcesoI::class, 'guardarRespuesta'])->name('procesoI.guardarRespuesta');
    Route::put('procesoI/actualizar-respuesta/{id}', [ProcesoI::class, 'actualizarRespuesta'])->name('procesoI.actualizarRespuesta');
    Route::get('procesoI/descargar-archivos/{id}', [ProcesoI::class, 'descargarArchivos'])->name('procesoI.descargarArchivos');
    Route::get('procesoI/calificar/{id}', [ProcesoI::class, 'calificar'])->name('procesoI.calificar');
    Route::post('procesoI/calificar-respuesta', [ProcesoI::class, 'calificarRespuesta'])->name('procesoI.calificarRespuesta');
    Route::post('procesoI/actualizar-calificacion/{calificacionId}', [ProcesoI::class, 'actualizarCalificacion'])->name('procesoI.actualizarCalificacion');
    Route::get('/graficasI', [ProcesoI::class, 'graficaDocumentacionCompletaPorAnio'])->name('procesoI.graficaDocumentacionCompletaPorAnio');    

    Route::resource('procesoJ', procesoJ::class);
    Route::get('procesoJ/{id}/editar', [procesoJ::class, 'edit'])->name('procesoJ.editar');
    Route::get('procesoJ/{id}/responder/{documentacionId}',[procesoJ::class, 'responder'] )->name('procesoJ.responder');
    Route::get('procesoJ/{documentacionId}/ver-respuesta', [procesoJ::class, 'verRespuesta'])->name('procesoJ.verRespuesta');
    Route::post('procesoJ/{documentacionId}/guardar-respuesta', [procesoJ::class, 'guardarRespuesta'])->name('procesoJ.guardarRespuesta');
    Route::put('procesoJ/actualizar-respuesta/{id}', [procesoJ::class, 'actualizarRespuesta'])->name('procesoJ.actualizarRespuesta');
    Route::get('procesoJ/descargar-archivos/{id}', [procesoJ::class, 'descargarArchivos'])->name('procesoJ.descargarArchivos');
    Route::get('procesoJ/calificar/{id}', [procesoJ::class, 'calificar'])->name('procesoJ.calificar');
    Route::post('procesoJ/calificar-respuesta', [procesoJ::class, 'calificarRespuesta'])->name('procesoJ.calificarRespuesta');
    Route::post('procesoJ/actualizar-calificacion/{calificacionId}', [procesoJ::class, 'actualizarCalificacion'])->name('procesoJ.actualizarCalificacion');
    Route::get('/graficasJ', [ProcesoJ::class, 'graficaDocumentacionCompletaPorAnio'])->name('procesoJ.graficaDocumentacionCompletaPorAnio');    

    Route::get('datatables/users', [DataTableController::class, 'getUsuarios'])->name('datatable.user');
    Route::get('datatables/rol', [DataTableController::class, 'getRoles'])->name('datatable.rol');
    Route::get('/verPerfil', [UsuarioController::class, 'verPerfil'])->name('UsuarioController.verPerfil');
    Route::get('/usuarioBloqueado', [UsuarioController::class, 'usuarioBloqueado'])->name('usuarioBloqueado');
    Route::get('/cambiarContrasena', [CambiarPasswordController::class, 'showChangePasswordForm'])->name('cambiarContrasena');
    Route::post('/cambiarContrasena', [CambiarPasswordController::class, 'cambiarPassword'])->name('cambiarContrasena.post');

    Route::get('/generar-pdfA/{nombreImagen1}/{nombreImagen2}', [ProcesoA::class, 'generaPDF'])->name('generaPDF');
    Route::post('/guardar-imagenes', [ProcesoA::class, 'guardarImagenes'])->name('guardarImagenes');
    Route::post('/eliminar-imagenes', [ProcesoA::class, 'eliminarImagenes'])->name('eliminarImagenes');

    Route::get('/generar-pdfB/{nombreImagen1}/{nombreImagen2}', [ProcesoB::class, 'generaPDF'])->name('generaPDF');
    Route::post('/guardar-imagenes', [ProcesoB::class, 'guardarImagenes'])->name('guardarImagenes');
    Route::post('/eliminar-imagenes', [ProcesoB::class, 'eliminarImagenes'])->name('eliminarImagenes');

    Route::get('/generar-pdfC/{nombreImagen1}/{nombreImagen2}', [ProcesoC::class, 'generaPDF'])->name('generaPDF');
    Route::post('/guardar-imagenes', [ProcesoC::class, 'guardarImagenes'])->name('guardarImagenes');
    Route::post('/eliminar-imagenes', [ProcesoC::class, 'eliminarImagenes'])->name('eliminarImagenes');

    Route::get('/generar-pdfD/{nombreImagen1}/{nombreImagen2}', [ProcesoD::class, 'generaPDF'])->name('generaPDF');
    Route::post('/guardar-imagenes', [ProcesoD::class, 'guardarImagenes'])->name('guardarImagenes');
    Route::post('/eliminar-imagenes', [ProcesoD::class, 'eliminarImagenes'])->name('eliminarImagenes');

    Route::get('/generar-pdfE/{nombreImagen1}/{nombreImagen2}', [ProcesoE::class, 'generaPDF'])->name('generaPDF');
    Route::post('/guardar-imagenes', [ProcesoE::class, 'guardarImagenes'])->name('guardarImagenes');
    Route::post('/eliminar-imagenes', [ProcesoE::class, 'eliminarImagenes'])->name('eliminarImagenes');

    Route::get('/generar-pdfF/{nombreImagen1}/{nombreImagen2}', [ProcesoF::class, 'generaPDF'])->name('generaPDF');
    Route::post('/guardar-imagenes', [ProcesoF::class, 'guardarImagenes'])->name('guardarImagenes');
    Route::post('/eliminar-imagenes', [ProcesoF::class, 'eliminarImagenes'])->name('eliminarImagenes');

    Route::get('/generar-pdfG/{nombreImagen1}/{nombreImagen2}', [ProcesoG::class, 'generaPDF'])->name('generaPDF');
    Route::post('/guardar-imagenes', [ProcesoG::class, 'guardarImagenes'])->name('guardarImagenes');
    Route::post('/eliminar-imagenes', [ProcesoG::class, 'eliminarImagenes'])->name('eliminarImagenes');

    Route::get('/generar-pdfH/{nombreImagen1}/{nombreImagen2}', [ProcesoH::class, 'generaPDF'])->name('generaPDF');
    Route::post('/guardar-imagenes', [ProcesoH::class, 'guardarImagenes'])->name('guardarImagenes');
    Route::post('/eliminar-imagenes', [ProcesoH::class, 'eliminarImagenes'])->name('eliminarImagenes');

    Route::get('/generar-pdfI/{nombreImagen1}/{nombreImagen2}', [ProcesoI::class, 'generaPDF'])->name('generaPDF');
    Route::post('/guardar-imagenes', [ProcesoI::class, 'guardarImagenes'])->name('guardarImagenes');
    Route::post('/eliminar-imagenes', [ProcesoI::class, 'eliminarImagenes'])->name('eliminarImagenes');

    Route::get('/generar-pdfJ/{nombreImagen1}/{nombreImagen2}', [ProcesoJ::class, 'generaPDF'])->name('generaPDF');
    Route::post('/guardar-imagenes', [ProcesoJ::class, 'guardarImagenes'])->name('guardarImagenes');
    Route::post('/eliminar-imagenes', [ProcesoJ::class, 'eliminarImagenes'])->name('eliminarImagenes');

    Route::get('/generar-pdfCompleto2/{nombreImagen?}', [UsuarioController::class, 'generateCumplimientoPDFLinea'])->name('generateCumplimientoPDFLinea');
    Route::post('/guardar-imagen-linea', [UsuarioController::class, 'guardarImagenLinea'])->name('guardarImagenLinea');
    Route::post('/eliminar-imagen-linea', [UsuarioController::class, 'eliminarImagenLinea'])->name('eliminarImagenLinea');
    
    /**Gráfico general Donas */
    Route::get('/generar-pdfCompleto/{nombresImagenes?}', [UsuarioController::class, 'generateCumplimientoPDF'])->name('generateCumplimientoPDF');
    Route::post('/guardar-imagenes2', [UsuarioController::class, 'guardarImagenes2'])->name('guardarImagenes2');
    Route::post('/eliminar-imagenes2', [UsuarioController::class, 'eliminarImagenes2'])->name('eliminarImagenes2');

    
});