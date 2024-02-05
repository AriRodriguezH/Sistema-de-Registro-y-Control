<!DOCTYPE html>
<html>

<head>
    <title>Reporte PDF</title>
    <link rel="stylesheet" type="text/css" href="{{ public_path('assests/css/style-reporte-grafica.css') }}">
</head>

<body>
    <table style="border-collapse: collapse; margin-bottom: 20px; width: 100%;">
        <tr>
            <th style=" border: 2px solid #ccc;">
                <img src="{{ public_path('assests/img/logoreportesdos.jpg') }}" width="190" height="60">
            </th>
            <th style="padding: 5px; border: 2px solid #ccc;">
                <h4>Reporte del Proceso {{ $proceso->identificador }}.{{ $proceso->nombreProceso }} (MGSI)</h4>
            </th>
        </tr>

    </table>
    <h3 style="margin-top: 40px;">Documentaciones Completas e Incompletas por Año</h3>
    <table id="primeraTabla">
        <thead>
            <tr>
                <th>Año</th>
                <th>Documentaciones Entregadas</th>
                <th>Documentaciones Completas</th>
                <th>Documentaciones Incompletas</th>
                <th>Cumplimiento de documentaciones completas</th>
        </thead>
        <tbody>
            @foreach ($anioCompletas as $anio => $completas)
            <tr>
                <td>{{ $anio }}</td>
                <td>{{ $completas + $anioIncompletas[$anio] }}</td>
                <td>{{ $completas }}</td>
                <td>{{ $anioIncompletas[$anio] }}</td>
                <td>
                    @if (is_numeric($porcentajeCompletas[$anio]))
                    {{ strpos($porcentajeCompletas[$anio], '.') !== false ? number_format($porcentajeCompletas[$anio], 2) : $porcentajeCompletas[$anio] }}%
                    @else
                    {{ $porcentajeCompletas[$anio] }}%
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="text-align: center;">
    <img src="{{ public_path('capturas_temporales/' . basename($rutaImagen1)) }}" alt="" style="display: block; margin: 0 auto;">
    </div>

    <br>

    <h3 style="margin-top: 20px;">Cumplimiento por semestre acorde al año</h3>
    <table id="primeraTabla">
        <thead>
            <tr>
                <th>Año</th>
                <th>Semestre 1</th>
                <th>Semestre 2</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($anioCompletas as $anio => $completas)
            <tr>
                <td>{{ $anio }}</td>
                <td>{{ $promedioCumplimientoPrimerSemestre[$anio] ?? 'N/A' }}</td>
                <td>{{ $promedioCumplimientoSegundoSemestre[$anio] ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>

    </table>
    <img src="{{ public_path('capturas_temporales/' . basename($rutaImagen2)) }}" alt="">
</body>

</html>