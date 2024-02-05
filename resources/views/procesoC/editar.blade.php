@extends('adminlte::page')

@section('title', 'SRCCMGSI')

@section('content_header')
<h4 class="font-weight-bold text-center">Editar proceso</h4>
<br>
{{ Breadcrumbs::render('editarPublicacionC') }}
@stop

@section('content')

    @if ($errors->has('anioRegistro'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $errors->first('anioRegistro') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

<div class="card">
    <div class="card-body">

        {!! Form::model($publicacion, ['route' => ['procesoC.update', $publicacion->id], 'method' => 'PUT','enctype' => 'multipart/form-data']) !!}
        @csrf

        <div class="mb-3">
            {!! Form::hidden('tipoProcesoId', $tipoProcesoId) !!}

            <!-- <div class="card-header">Editar Publicación - ID: {{ $publicacion->id }}</div>-->

            <!-- Campos de la publicación -->
            <div class="form-group">
                <label style="font-size: 13px;" for="datepicker">Selecciona el año:</label>
                {!! Form::text('anioRegistro', null, ['id' => 'datepicker', 'class' => 'form-control','style' => 'font-size: 13px;', 'placeholder' => 'Seleccionar año', 'readonly' => 'readonly']) !!}
            </div>

            @foreach ($documentacion as $i => $documento)
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        {{ Form::label('semestre_'.$documento->id, 'Semestre',['style' => 'font-size: 13px;']) }}
                        {{ Form::text('semestre_'.$documento->id, $documento->semestre, ['class' => 'form-control','style' => 'font-size: 13px;','readonly','contenteditable' => 'false']) }}
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        {{ Form::label('descripcion_'.$documento->id, 'Descripcion',['style' => 'font-size: 13px;']) }}
                        {{ Form::text('descripcion_'.$documento->id, $documento->descripcion, ['class' => 'form-control','style' => 'font-size: 13px;','readonly','contenteditable' => 'false']) }}
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        {{ Form::label('descripcion_'.$documento->id, 'Descripcion',['style' => 'font-size: 13px;']) }}
                        {{ Form::text('descripcion_'.$documento->id, $documento->descripcion, ['class' => 'form-control','style' => 'font-size: 13px;','readonly','contenteditable' => 'false']) }}
                    </div>
                </div>
                <div class="col">
                        <div class="form-group">
                            {{ Form::label('archivos_'.$documento->id, 'Archivos Adjuntos:', ['style' => 'font-size: 13px;']) }}
                            <a href="#" data-toggle="tooltip" title="Los documentos no deben de rebasar el tamaño de 10 MB, de lo contrario no se permitirá su subida" class="ml-2">
                                            <i class="fas fa-question-circle"></i>
                                        </a>
                            <div class="custom-file">
                                {{ Form::file('archivos_'.$documento->id.'[]', ['class' => 'custom-file-input', 'style' => 'font-size: 13px;', 'multiple', 'accept' => '.pdf,.doc,.docx,.xls,.xlsx', 'id' => 'archivos_'.$documento->id, 'data-browse' => 'Seleccionar']) }}
                                <label style="font-size: 13px;" class="custom-file-label" data-browse="Buscar" for="archivos_{{ $documento->id }}">Seleccionar archivos</label>
                            </div>
                            <div id="archivos_{{ $documento->id }}_error" class="text-danger" style="display: none; font-size: 13px;">Archivos no válidos. Solo se permiten archivos PDF, DOC, DOCX, XLS, XLSX.</div>

                            @if (!empty($documento->archivo_path))
                                <div class="mt-2">
                                    <p>Archivos adjuntos actuales:</p>
                                    @foreach (explode('|', $documento->archivo_path) as $archivo)
                                        <a href="{{ asset('storage/' . $archivo) }}" target="_blank">{{ basename($archivo) }}</a>
                                    @endforeach
                                </div>
                            @else
                                <p>No hay archivos adjuntos.</p>
                            @endif
                        </div>        
                </div>  
            </div>
            @endforeach
            
            <a href="{{ url()->previous() }}" style="font-size: 13px;" class="btn btn-danger" tabindex="6">Cancelar</a>
            {!! Form::submit('Actualizar', ['class' => 'btn btn-primary', 'style' => 'font-size: 13px;', 'id' => 'enviar-btn']) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>

@stop

@section('css')
<link rel="stylesheet" href="{{  asset('assests/css/jquery-ui.css') }}">
<link rel="stylesheet" href="{{  asset('assests/css/bootstrap-datepicker.min.css') }}">
@stop

@section('js')
<script src="{{ asset('assests/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assests/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assests/js/jquery.ui.datepicker-es.js') }}"></script>
<script src="{{ asset('assests/js/procesos/actu_subida_archivo.js') }}"></script>
<script src="{{ asset('assests/js/procesos/seleccion-anio.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Habilita el botón de envío al cargar la página
        const enviarBtn = document.getElementById('enviar-btn');
        enviarBtn.disabled = false;

        // Escucha el evento 'change' en los campos de archivo dinámicamente generados
        @foreach ($documentacion as $i => $documento)
        document.getElementById('archivos_{{ $documento->id }}').addEventListener('change', function () {
            validarArchivos();
        });
        @endforeach

        function validarArchivos() {
            const inputs = [
                @foreach ($documentacion as $i => $documento)
                document.getElementById('archivos_{{ $documento->id }}'),
                @endforeach
            ];
            const errorAlerts = [
                @foreach ($documentacion as $i => $documento)
                document.getElementById('archivos_{{ $documento->id }}_error'),
                @endforeach
            ];
            const validExtensions = ['.pdf', '.doc', '.docx', '.xls', '.xlsx'];
            let isValid = true;

            // Verifica archivos en todos los campos
            for (let i = 0; i < inputs.length; i++) {
                const inputField = inputs[i];
                const errorAlert = errorAlerts[i];
                const files = inputField.files;
                let isFieldValid = true;

                // Verifica archivos en el campo
                for (const file of files) {
                    if (file) { // Verifica si se seleccionó algún archivo
                        const extension = '.' + file.name.split('.').pop().toLowerCase();
                        if (!validExtensions.includes(extension)) {
                            isFieldValid = false;
                            break; // Sale del bucle si encuentra un archivo no válido
                        }
                    }
                }

                // Muestra u oculta la alerta de error según la validación
                errorAlert.style.display = isFieldValid ? 'none' : 'block';

                // Si al menos un campo tiene archivos no válidos, invalida el estado general
                if (!isFieldValid) {
                    isValid = false;
                }
            }

            // Deshabilita el botón de envío si ambos campos tienen archivos no permitidos
            enviarBtn.disabled = !isValid;
        }
    });
</script>

@stop