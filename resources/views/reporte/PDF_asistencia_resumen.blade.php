<html>
<head>
    <style type="text/css">
        table td, th {
            padding: 5px;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <section class="content">
        <div style="text-align: center;line-height: 8px;">
            <h3>COAR AREQUIPA</h3>
            <p><strong>SEDE {{ $programacion->sede }}</strong></p>
            <p><small>RESUMEN GENERAL DE ASISTENCIA DE POSTULANTES - ADMISION {{ date('Y') }}</small></p>
        </div>
    </section>
    <table style="width: 100%;text-align: center;border: 1px solid #111;" cellpadding="0" cellspacing="0">
        <thead>
        <tr class="has-text-centered">
            <th></th>
            <th>PROGRAMADO</th>
            <th>ASISTENTES</th>
            <th>FALTANTES</th>
        </tr>
        </thead>
        <tbody>
        @php
            $totales = [
                 'total_habilitados' => 0,
                 'total_asistentes' => 0,
                 'total_faltantes' => 0
            ];
        @endphp
        @foreach ($asistencias as $item)
            <tr>
                <td style="border-top: 1px solid #111111;">AULA {{ $item->aula }}</td>
                <td style="border-top: 1px solid #111111;">{{ $item->total_postulantes_habilitados }}</td>
                <td style="border-top: 1px solid #111111;">{{ $item->total_postulantes_con_asistencia }}</td>
                <td style="border-top: 1px solid #111111;">{{ $item->total_postulantes_faltantes }}</td>
            </tr>
            @php
                $totales['total_habilitados'] += $item->total_postulantes_habilitados;
                $totales['total_asistentes'] += $item->total_postulantes_con_asistencia;
                $totales['total_faltantes'] += $item->total_postulantes_faltantes;
            @endphp
        @endforeach
        <tr style="background: #e5e5e5;">
            <td><strong>TOTALES</strong></td>
            <td>{{ $totales['total_habilitados'] }}</td>
            <td>{{ $totales['total_asistentes'] }}</td>
            <td>{{ $totales['total_faltantes'] }}</td>
        </tr>
        </tbody>
    </table>
</body>
</html>
