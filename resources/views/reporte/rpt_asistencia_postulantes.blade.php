@extends('layouts.app')
@section('content')
    <p class="has-text-right content">Total {{ sizeof($asistencias)  }} registros</p>
    <table class="table is-fullwidth is-bordered is-striped is-hovered">
        <thead>
        <tr>
            <td></td>
            <td><strong>DNI</strong></td>
            <td><strong>NOMBRES Y APELLIDOS</strong></td>
            <td class="has-text-centered"><strong>AULA</strong></td>
            <td class="has-text-centere"><strong>FECHA DE ASISTENCIA</strong></td>
        </tr>
        </thead>
        <tbody>
        @foreach($asistencias as $index => $asistencia)
            <tr>
                <td class="has-text-centered"> {{ ++$index }}</td>
                <td>{{ $asistencia->postulante->dni }}</td>
                <td>{{ $asistencia->postulante->nombres }}, {{ $asistencia->postulante->apellidos }}</td>
                <td class="has-text-centered">Aula {{ $asistencia->postulante->aula }}</td>
                <td>{{ $asistencia->fecha_asistencia }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
