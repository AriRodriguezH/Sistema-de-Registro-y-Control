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
                <h4>Reporte General del cumplimiento de los procesos (MGSI)</h4>
            </th>
        </tr>
    </table>


    @php
    $identificadoresMostrados = []; // Variable para rastrear identificadores ya mostrados
    @endphp

    @foreach ($resultados as $dato)
    @if (!in_array($dato['identificador'], $identificadoresMostrados))
    <h3 style="margin-top: 25px;">Proceso {{ $dato['identificador'] }}</h3>
    <table id="primeraTabla" style="border-collapse: collapse; margin-bottom: 25px; width: 100%;">
        <thead>
            <tr>
                <th>Proceso</th>
                <th>Año</th>
                <th>Semestre</th>
                <th>Cumplimiento Semestre</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resultados as $fila)
            @if ($fila['identificador'] === $dato['identificador'])
            <tr>
                <td>{{ $fila['identificador'] }}</td>
                <td>{{ $fila['anio'] }}</td>
                <td>{{ $fila['semestre'] }}</td>
                <td>{{ $fila['porcentajeCumplimiento'] }}%</td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
    @php
    $identificadoresMostrados[] = $dato['identificador']; // Agregar el identificador a la lista de identificadores mostrados
    @endphp
    @endif
    @endforeach


    <div>

        <h3>Gráficas de Cumplimiento por Identificador, Año y Semestre</h3>
        @foreach ($rutasImagenes as $rutaImagen)
        <div style="display: inline-block; margin-right: 20px; vertical-align: top;">
            <img src="{{ $rutaImagen }}" alt="Gráfico de Cumplimiento" style="max-width: 900px; max-height: 245px; margin-bottom: 25px;">
        </div>
        @endforeach
    </div>




</body>

</html>