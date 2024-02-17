@extends('layouts.app')
@section('content')
    <table class="table has-text-centered is-fullwidth is-bordered">
        <thead>
        <tr>
            <td></td><td><strong>Usuario</strong></td><td class="has-text-centere"><strong> Postulantes registrados</strong></td>
        </tr>
        </thead>
        <tbody>
        @foreach($users_asistencias as $index => $r)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $r->username }}</td>
                <td>{{ $r->registrados }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
