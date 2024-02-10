@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="has-text-centered">
            <h3>COAR AREQUIPA</h3>
            <p><strong>SEDE {{ $programacion->sede }}</strong></p>
            <p><strong>RESUMEN GENERAL DE ASISTENCIA DE POSTULANTES - ADMISION {{ date('Y') }}</strong></p>
        </div>
        <table class="table mt-5">
            <thead>
            <tr class="has-text-centered">
                <th></th>
                <th>Programado</th>
                <th>Asistentes</th>
                <th>Faltantes</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($asistencias as $item)
                <tr class="has-text-centered">
                    <td> <strong>AULA {{ $item->aula }}</strong></td>
                    <td>{{ $item->total_postulantes_habilitados }}</td>
                    <td>{{ $item->total_postulantes_con_asistencia }}</td>
                    <td>{{ $item->total_postulantes_faltantes }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endsection
