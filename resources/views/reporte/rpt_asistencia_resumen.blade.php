@extends('layouts.app')
@section('content')
    <div id="app_general"></div>
    <section class="content">
        <div class="has-text-centered">
            <h3>COAR AREQUIPA</h3>
            <p><strong>SEDE {{ $programacion->sede }}</strong></p>
            <p><strong>RESUMEN GENERAL DE ASISTENCIA DE POSTULANTES - ADMISION {{ date('Y') }}</strong></p>
        </div>
        <p class="has-text-right"><u><a href="{{ url('/pdf/asistencia-resumen') }}"><strong>Descargar</strong></a></u></p>
        <table class="table mt-5">
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
                <tr class="has-text-centered">
                    <td>AULA {{ $item->aula }}</td>
                    <td>{{ $item->total_postulantes_habilitados }}</td>
                    <td class="has-background-success-light">{{ $item->total_postulantes_con_asistencia }}</td>
                    <td class="has-background-danger-light">{{ $item->total_postulantes_faltantes }}</td>
                </tr>
                @php
                    $totales['total_habilitados'] += $item->total_postulantes_habilitados;
                    $totales['total_asistentes'] += $item->total_postulantes_con_asistencia;
                    $totales['total_faltantes'] += $item->total_postulantes_faltantes;
                @endphp
            @endforeach
            <tr class="has-text-centered has-background-grey-lighter has-text-weight-bold">
                <td><strong>TOTALES</strong></td>
                <td>{{ $totales['total_habilitados'] }}</td>
                <td>{{ $totales['total_asistentes'] }}</td>
                <td>{{ $totales['total_faltantes'] }}</td>
            </tr>
            </tbody>
        </table>
    </section>
@endsection
