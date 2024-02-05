    @extends('adminlte::page')

    @section('title', 'MGSI')

    @section('content_header')
    <h4 class="font-weight-bold text-center">Gestión de Usuarios</h4>
    <br>
    {{ Breadcrumbs::render('usuarios') }}
    @stop

    @section('content')
    
    <div class="card">
            <div class="card-body">
            @can('crear-usuarios')
            <a class="btn btn-primary" style="margin-bottom: 25px;" href="{{route('usuarios.create')}}"><i class="fas fa-plus-square"></i> <i style="padding-left: 5px;"></i>Nuevo</a>
            @endcan
                <!--Creación de la tabla para consultar los usuarios-->
                <table class="table table-striped table-responsive-sm table-bordered mt-4" width="100%" id="usuarios-table">
                    <thead style="background-color: #2e7555!important;" class="text-white">
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Nombre de Usuario</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </thead>
                </table>
            </div>
        
    </div>
    @stop

    @section('css')
    <link rel="stylesheet"  href="{{ asset('assests/css/dataTables.bootstrap5.min.css')}}">
    <link rel="stylesheet"  href="{{ asset('assests/css/sweetalert2.min.css')}}">

    @stop

    @section('js')
    <script>
        console.log('Hi!');
    </script>
    <script src="{{ asset('assests/js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('assests/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assests/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assests/js/sweetalert2.all.min.js') }}"></script>

    <script>
    $(function() {
    $('#usuarios-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: ' datatables/users',
            data: function(data) {
                data.search.value = data.search.value || $('input[type="search"]').val();
            }
        },
        columns: [
            {
                data: 'nombre',
                name: 'nombre',
                searchable: true, // Habilitar búsqueda en esta columna
            },
            {
                        data: 'apellidoP',
                        name: 'apellidoP',
                        searchable: true, // Habilitar búsqueda en esta columna
                    },
                    {
                        data: 'apellidoM',
                        name: 'apellidoM',
                        searchable: true, // Habilitar búsqueda en esta columna
                    },
                    {
                        data: 'nombreUsuario',
                        name: 'nombreUsuario',
                        searchable: true, // Habilitar búsqueda en esta columna

                    },
                    {
                        data: 'email',
                        name: 'email',
                        searchable: true, // Habilitar búsqueda en esta columna
                    },
                    {
            data: 'roles',
            name: 'roles',
            searchable: true, // Habilitar búsqueda en esta columna
        },
        {
            data: 'estado',
            name: 'estado',
            searchable: true, // Habilitar búsqueda en esta columna
        },
           
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function(data, type, full, meta) {
                    var editIcon = '<a href="{{ route("usuarios.edit", ":id") }}'.replace(':id', full.id) + '"><i class="fa fa-edit"></i></a>';
                    
                    // SweetAlert
                    var deleteForm = `
                        <button class="btn btn-link text-danger delete-user" data-user-id="${full.id}">
                            <i class="fa fa-trash"></i>
                        </button>`;
                    
                    return editIcon + ' ' + deleteForm;
                }
            }
        ],
        "language": {
                "url": "{{ asset('assests/js/es_es.json') }}"
        },
        
    });

    // Evento click para el botón de eliminar
    $('#usuarios-table').on('click', '.delete-user', function() {
        var userId = $(this).data('user-id');

        // Mostrar el cuadro de diálogo SweetAlert
        Swal.fire({
            title: '¿Estás seguro de eliminar este usuario?',
            text: 'Esta acción no se puede deshacer',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Realizar la solicitud de eliminación
                var deleteForm = $('<form>', {
                    'action': `{{ route("usuarios.destroy", ":id") }}`.replace(':id', userId),
                    'method': 'POST',
                    'class': 'd-inline',
                    'html': `
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-link text-danger">
                            <i class="fa fa-trash"></i>
                        </button>`
                });
                
                deleteForm.appendTo('body').submit();
            }
        });
    });
});

    </script>
    @stop