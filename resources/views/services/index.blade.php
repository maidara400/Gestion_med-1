@extends('layouts.admin')


@section('content')
    <h1 class="text-center m-3">Tout les services</h1>
        <table class="table">
            <thead>
                <tr class="mb-3">
                <th scope="col ">#</th>
                <th scope="col">Titre</th>
                <th scope="col">Description</th>
                <th scope="col">Prix</th>
                <th scope="col">Duree</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach($services as $service)
                        <th scope="row">{{$service->id}}</th>
                        <td>{{$service->titre}}</td>
                        <td>{{$service->description}}</td>
                        <td>{{$service->prix}} F</td>
                        <td>{{$service->duree}} </td>
                        <td>{{$service->medecin->nom}}</td>
                    @endforeach
                </tr>
            </tbody>
        </table>
        <div class="mt-4">
            {{ $services->links() }}
        </div>
@endsection