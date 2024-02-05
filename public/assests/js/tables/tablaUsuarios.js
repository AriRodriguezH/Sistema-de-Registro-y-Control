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
                        name: 'nombre'
                    },
                    {
                        data: 'apellidoP',
                        name: 'apellidoP'
                    },
                    {
                        data: 'apellidoM',
                        name: 'apellidoM'
                    },
                    {
                        data: 'nombreUsuario',
                        name: 'nombreUsuario'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'roles',
                        name: 'roles',
                        render: function(data) {
                            var roles = data.map(function(role) {
                                return role.name;
                            });
                            return roles.join(', ');
                        }
                    },
                    {
                        data: 'estado',
                        render: function(data, type, full, meta) {
                            var estadoText = (data == 0) ? 'Activo' : 'Bloqueado';
                            return estadoText;
                        }
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            var editIcon = '<a href="{{ route("usuarios.edit", ":id") }}'.replace(':id', full.id) + '"><i class="fa fa-edit"></i></a>';
                            var deleteForm = '<form action="{{ route("usuarios.destroy", ":id") }}'.replace(':id', full.id) + '" method="POST" class="d-inline">' +
                                '@csrf' +
                                '@method("DELETE")' +
                                '<button type="submit" class="btn btn-link text-danger" onclick="return confirm(\'¿Estás seguro de eliminar este usuario?\')"><i class="fa fa-trash"></i></button>' +
                                '</form>';

                            return editIcon + ' ' + deleteForm;
                        }
                    }
                ],
                "language": {
                    "url": "{{ asset('assets/js/es_es.json') }}"
                },

            });
        });