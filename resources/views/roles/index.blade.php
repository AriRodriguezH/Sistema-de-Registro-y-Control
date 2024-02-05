@extends('adminlte::page')

@section('title', 'SRCCMGSI')

@section('content_header')
<h4 class="font-weight-bold text-center">Roles</h4>
<br>
{{ Breadcrumbs::render('roles') }}

@stop


@section('content')
<div class="card">
    <div class="card-body">
        @can('crear-rol')
        <a class="btn btn-primary" style="margin-bottom: 25px;"  href="{{ route('roles.create') }}"><i class="fas fa-plus-square"></i> <i style="padding-left: 5px;"></i>Nuevo</a>
        @endcan
        <table class="table table-striped table-responsive-sm table-bordered mt-4" width="100%" id="rolesT">
            <thead style="background-color: #2e7555!important">
                <th style="color:#fff;">Rol</th>
                <th style="color:#fff;">Acciones</th>
            </thead>
        </table>
    </div>
</div>

@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="{{ asset('assests/css/dataTables.bootstrap5.min.css')}}">
<link rel="stylesheet" href="{{ asset('assests/css/sweetalert2.min.css')}}">
@stop

@section('js')
<script src="{{ asset('assests/js/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('assests/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assests/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assests/js/sweetalert2.all.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#rolesT').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('datatable.rol') }}",
            columns: [
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        var editIcon = '<a href="{{ route("roles.edit", ":id") }}'.replace(':id', full.id) + '"><i class="fa fa-edit"></i></a>';
                        var deleteButton = '<button class="btn btn-link text-danger delete-btn" data-role-id="' + full.id + '"><i class="fa fa-trash"></i></button>';

                        return editIcon + ' ' + deleteButton;
                    }
                }
            ],
            "language": {
                "url": "{{ asset('assests/js/es_es.json') }}"
            },
        });

        $(document).on('click', '.delete-btn', function() {
            var roleId = $(this).data('role-id');
            Swal.fire({
                title: '¿Estás seguro de eliminar este rol?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('roles.destroy', ':id') }}".replace(':id', roleId),
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            $('#rolesT').DataTable().ajax.reload();
                            if (data.success) {
                                Swal.fire('Eliminado', 'El rol ha sido eliminado correctamente', 'success');
                            } else {
                                Swal.fire('Error', 'Ocurrió un error al eliminar el rol: ' + data.message, 'error');
                            }
                        },
                        error: function(data) {
                            Swal.fire('Error', 'Ocurrió un error al eliminar el rol', 'error');
                        }
                    });
                }
            });
        });
    });
</script>

@stop