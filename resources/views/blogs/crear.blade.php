@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Crear</h1>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>

    <div class="card-body">     

        @if ($errors->any())                                                
            <div class="alert alert-dark alert-dismissible fade show" role="alert">
            <strong>¡Revise los campos!</strong>                        
                @foreach ($errors->all() as $error)                                    
                    <span class="badge badge-danger">{{ $error }}</span>
                @endforeach                        
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
        @endif

        <form action="{{ route('blogs.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" name="titulo" class="form-control">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                                        
                    <div class="form-floating">
                    <textarea class="form-control" name="contenido" style="height: 100px"></textarea>
                    <label for="contenido">Contenido</label>
                    </div>
                
                <button type="submit" class="btn btn-primary">Guardar</button>                            
            </div>
        </form>
                    
 </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop