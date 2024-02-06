@extends('layouts.app')
@section('content')
    <form action="{{ route('actualizar_estado') }}" method="POST">
        @csrf
    <table class="table is-fullwidth is-hoverable">
        <thead>
        <tr>
            <th>ESTADO</th>
            <th>NRO</th>
            <th>SEDE</th>
            <th>FECHA</th>
            <th>HORA</th>
            <th>TURNO</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($programaciones as $index => $programacion)
            <label for="programacion">
                <tr class="{{ $programacion->estado === 1 ? 'has-background-success-light':'' }}">
                    <th><input type="radio" name="programacion" class="is-clickable" {{ $programacion->estado === 1 ? 'checked="checked"' : '' }} value="{{ $programacion->id  }}" /></th>
                    <td>{{ ++$index }}</td>
                    <td>{{ $programacion->sede }}</td>
                    <td>{{ \Carbon\Carbon::parse($programacion->fecha)->format('m/d/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($programacion->fecha)->format('H:i') }}</td>
                    <td>{{ $programacion->turno }}</td>
                </tr>
            </label>
        @endforeach
        </tbody>
    </table>
        <button type="submit" class="button is-danger has-text-right">Cambiar programación</button>
    </form>
@endsection
