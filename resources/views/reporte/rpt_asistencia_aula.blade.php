@extends('layouts.app')
@section('content')
    <table class="table has-text-centered is-fullwidth is-bordered">
        <thead>
        <tr>
            <td><strong>Aula</strong></td><td class="has-text-centere"><strong>Cantidad de Postulantes</strong></td>
        </tr>
        </thead>
        <tbody>
            @foreach($postulantes_aula as $resultado)
                <tr>
                    <td>Aula {{ $resultado->aula }}</td>
                    <td>{{ $resultado->total_postulantes }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
