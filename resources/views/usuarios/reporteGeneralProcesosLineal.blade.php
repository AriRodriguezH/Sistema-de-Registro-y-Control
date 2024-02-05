<!DOCTYPE html>
<html>

<head>
    <title>Reporte General MGSI PDF</title>
    <link rel="stylesheet" type="text/css" href="{{ public_path('assests/css/style-reporte-general-grafica.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ public_path('assests/css/style-reporte-grafica.css') }}">
    
</head>

<body>

    <table style="border-collapse: collapse; margin-bottom: 40px; width: 100%; padding-bottom: 25px;">
        <tr>
            <th style="border: 2px solid #ccc;">
                <img src="{{ public_path('assests/img/logoreportesdos.jpg') }}" width="190" height="60">
            </th>
            <th style=" padding: 5px; border: 2px solid #ccc;">
                <h4>Reporte General de los procesos (MGSI)</h4>
            </th>
        </tr>
    </table>

    @foreach ($datosGrafica as $data)
    <h3 style="margin-top: 25px;">Proceso {{$data['identificador']}}</h3>
    <table id="primeraTabla">
        <thead>
            <tr>
                <th>Proceso</th>
                <th>Año</th>
                <th>Cumplimiento total</th>
                <th>Cumplimiento 1er Semestre</th>
                <th>Cumplimiento 2do Semestre</th>
            </tr>
        </thead>
        <tbody>

            <!-- Ordenar los años de forma descendente -->
            @php
            $yearsDesc = array_keys($data['porcentajes']);
            rsort($yearsDesc);
            @endphp

            <!-- Bucle para generar filas de datos -->
            @foreach ($yearsDesc as $anio)
            @php
            $porcentajes = $data['porcentajes'][$anio];
            @endphp
            <tr>
                <td>{{ $data['identificador'] }}</td>
                <td>{{ $anio }}</td>
                <td>{{ ($porcentajes['porcentajeTotal'] == intval($porcentajes['porcentajeTotal'])) ? number_format($porcentajes['porcentajeTotal'], 0) : number_format($porcentajes['porcentajeTotal'], 2) }}</td>
                <td>{{ is_int($porcentajes['semestre1']) ? number_format($porcentajes['semestre1'], 0) : number_format($porcentajes['semestre1'], 2) }}</td>
                <td>{{ is_int($porcentajes['semestre2']) ? number_format($porcentajes['semestre2'], 0) : number_format($porcentajes['semestre2'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    @endforeach

    <img src="{{ $rutaImagen }}" alt="Gráfica cumplimiento general" style="max-width: 100%; height: auto;">
 
</body>

</html>