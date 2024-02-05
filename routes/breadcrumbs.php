<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use App\Models\User; 

// Página de inicio
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Inicio', route('home'));
});

/**Sección Usuarios */
// Genera el breadcrumb de la página de usuarios
Breadcrumbs::for('usuarios', function ($trail)  {
    $trail->parent('home');
    $trail->push('Usuarios', route('usuarios.index')); // 'usuarios.index' es el nombre de la ruta para el método index
});

Breadcrumbs::for('crearUsuario', function ($trail) {
    $trail->parent('usuarios');
    $trail->push('Alta de usuarios', route('usuarios.create'));
});


Breadcrumbs::for('cambiarContrasena', function ($trail) {
    $trail->parent('home'); 
    $trail->push('Cambiar contraseña', route('cambiarContrasena'));
});


Breadcrumbs::for('graficaCumplimiento', function ($trail) {
    $trail->parent('home'); 
    $trail->push('Gráficas'); 
    $trail->push('Gráfica General MGSI', route('UsuarioController.graficaCumplimientoTodosProcesos')); 
    $trail->push('Gráfica General de Cumplimiento de Procesos', route('UsuarioController.mostrarGraficaDonas')); 

});


Breadcrumbs::for('roles', function ($trail)  {
    $trail->parent('home');
    $trail->push('Roles', route('roles.index'));
});

Breadcrumbs::for('crearRol', function ($trail)  {
    $trail->parent('roles');
    $trail->push('Alta de roles', route('roles.create')); 
});

/**Proceso A */
Breadcrumbs::for('procesoA', function ($trail)  {
    $trail->parent('home');
    $trail->push('Procesos'); 
    $trail->push('A. Objetivos, requerimientos y estrategias', route('procesoA.index')); 
});

Breadcrumbs::for('crearprocesoA', function ($trail)  {
    $trail->parent('procesoA');
    $trail->push('Crear publicación', route('procesoA.create')); 
});

Breadcrumbs::for('graficaDocumentacionCompletaA', function ($trail) {
    $trail->parent('home'); 
    $trail->push('Gráficas'); 
    $trail->push('Gráficas de los procesos MGSI'); 
    $trail->push('A. Objetivos, requerimientos y estrategias', route('procesoA.graficaDocumentacionCompletaPorAnio')); 
});

/**Proceso B */
Breadcrumbs::for('procesoB', function ($trail)  {
    $trail->parent('home');
    $trail->push('Procesos'); 
    $trail->push('B. Identificación de los procesos y activos esenciales', route('procesoB.index')); 
});

Breadcrumbs::for('crearprocesoB', function ($trail)  {
    $trail->parent('procesoB');
    $trail->push('Crear publicación', route('procesoB.create')); 
});

Breadcrumbs::for('graficaDocumentacionCompletaB', function ($trail) {
    $trail->parent('home'); 
    $trail->push('Gráficas'); 
    $trail->push('Gráficas de los procesos MGSI'); 
    $trail->push('B. Identificación de los procesos y activos esenciales ', route('procesoB.graficaDocumentacionCompletaPorAnio')); 
});

/**Proceso C */
Breadcrumbs::for('procesoC', function ($trail)  {
    $trail->parent('home');
    $trail->push('Procesos'); 
    $trail->push('C. Análisis de Riesgos', route('procesoC.index')); 
});

Breadcrumbs::for('crearprocesoC', function ($trail)  {
    $trail->parent('procesoC');
    $trail->push('Crear publicación', route('procesoC.create')); 
});

Breadcrumbs::for('graficaDocumentacionCompletaC', function ($trail) {
    $trail->parent('home'); 
    $trail->push('Gráficas'); 
    $trail->push('Gráficas de los procesos MGSI'); 
    $trail->push('C. Análisis de Riesgos', route('procesoC.graficaDocumentacionCompletaPorAnio')); 
});

/**Proceso D */
Breadcrumbs::for('procesoD', function ($trail)  {
    $trail->parent('home');
    $trail->push('Procesos'); 
    $trail->push('D. Implementación de los controles mínimos de Seguridad de la Información', route('procesoD.index')); 
});

Breadcrumbs::for('crearprocesoD', function ($trail)  {
    $trail->parent('procesoD');
    $trail->push('Crear publicación', route('procesoD.create')); 
});

Breadcrumbs::for('graficaDocumentacionCompletaD', function ($trail) {
    $trail->parent('home'); 
    $trail->push('Gráficas'); 
    $trail->push('Gráficas de los procesos MGSI'); 
    $trail->push('D. Implementación de los controles mínimos de Seguridad de la Información', route('procesoD.graficaDocumentacionCompletaPorAnio')); 
});

/**Proceso E */
Breadcrumbs::for('procesoE', function ($trail)  {
    $trail->parent('home');
    $trail->push('Procesos'); 
    $trail->push('E. Programa de gestión de vulnerabilidades', route('procesoE.index')); 
});

Breadcrumbs::for('crearprocesoE', function ($trail)  {
    $trail->parent('procesoE');
    $trail->push('Crear publicación', route('procesoE.create')); 
});

Breadcrumbs::for('graficaDocumentacionCompletaE', function ($trail) {
    $trail->parent('home'); 
    $trail->push('Gráficas'); 
    $trail->push('Gráficas de los procesos MGSI'); 
    $trail->push('E. Programa de gestión de vulnerabilidades', route('procesoE.graficaDocumentacionCompletaPorAnio')); 
});

/**Proceso F */
Breadcrumbs::for('procesoF', function ($trail)  {
    $trail->parent('home');
    $trail->push('Procesos'); 
    $trail->push('F. Protocolo de respuesta ante incidentes de Seguridad de la Información', route('procesoF.index')); 
});

Breadcrumbs::for('crearprocesoF', function ($trail)  {
    $trail->parent('procesoF');
    $trail->push('Crear publicación', route('procesoF.create')); 
});

Breadcrumbs::for('graficaDocumentacionCompletaF', function ($trail) {
    $trail->parent('home'); 
    $trail->push('Gráficas'); 
    $trail->push('Gráficas de los procesos MGSI'); 
    $trail->push('F. Protocolo de respuesta ante incidentes de Seguridad de la Información', route('procesoF.graficaDocumentacionCompletaPorAnio')); 
});

/**Proceso G */
Breadcrumbs::for('procesoG', function ($trail)  {
    $trail->parent('home');
    $trail->push('Procesos'); 
    $trail->push('G. Plan de Continuidad de Operaciones y Plan de Recuperación ante Desastres', route('procesoG.index')); 
});

Breadcrumbs::for('crearprocesoG', function ($trail)  {
    $trail->parent('procesoG');
    $trail->push('Crear publicación', route('procesoG.create')); 
});

Breadcrumbs::for('graficaDocumentacionCompletaG', function ($trail) {
    $trail->parent('home'); 
    $trail->push('Gráficas'); 
    $trail->push('Gráficas de los procesos MGSI'); 
    $trail->push('G. Plan de Continuidad de Operaciones y Plan de Recuperación ante Desastres', route('procesoG.graficaDocumentacionCompletaPorAnio')); 
});

/**Proceso H */
Breadcrumbs::for('procesoH', function ($trail)  {
    $trail->parent('home');
    $trail->push('Procesos'); 
    $trail->push('H. Supervisión y evaluación', route('procesoH.index')); 
});

Breadcrumbs::for('crearprocesoH', function ($trail)  {
    $trail->parent('procesoH');
    $trail->push('Crear publicación', route('procesoH.create')); 
});

Breadcrumbs::for('graficaDocumentacionCompletaH', function ($trail) {
    $trail->parent('home'); 
    $trail->push('Gráficas'); 
    $trail->push('Gráficas de los procesos MGSI'); 
    $trail->push('H. Supervisión y evaluación', route('procesoH.graficaDocumentacionCompletaPorAnio')); 
});

/**Proceso I */
Breadcrumbs::for('procesoI', function ($trail)  {
    $trail->parent('home');
    $trail->push('Procesos'); 
    $trail->push('I. Programa de Formación, Concientización y Capacitación en materia de Seguridad de la Información', route('procesoI.index')); 
});

Breadcrumbs::for('crearprocesoI', function ($trail)  {
    $trail->parent('procesoI');
    $trail->push('Crear publicación', route('procesoI.create')); 
});

Breadcrumbs::for('graficaDocumentacionCompletaI', function ($trail) {
    $trail->parent('home'); 
    $trail->push('Gráficas'); 
    $trail->push('Gráficas de los procesos MGSI'); 
    $trail->push('I. Programa de Formación, Concientización y Capacitación en materia de Seguridad de la Información', route('procesoI.graficaDocumentacionCompletaPorAnio')); 
});

/**Proceso J */
Breadcrumbs::for('procesoJ', function ($trail)  {
    $trail->parent('home');
    $trail->push('Procesos'); 
    $trail->push('J. Programa de implementación del MGSI', route('procesoJ.index')); 
});

Breadcrumbs::for('crearprocesoJ', function ($trail)  {
    $trail->parent('procesoJ');
    $trail->push('Crear publicación', route('procesoJ.create')); 
});

Breadcrumbs::for('graficaDocumentacionCompletaJ', function ($trail) {
    $trail->parent('home'); 
    $trail->push('Gráficas'); 
    $trail->push('Gráficas de los procesos MGSI'); 
    $trail->push('J. Programa de implementación del MGSI', route('procesoJ.graficaDocumentacionCompletaPorAnio')); 
});