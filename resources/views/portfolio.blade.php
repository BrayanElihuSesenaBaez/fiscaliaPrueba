@extends('layout')

@section('title', 'Portfolio')

@section('content')
    <h1>Portafolio</h1>

    <ul>

        @forelse($projects as $project)
            <li><a href=" {{ route('portfolio.show', $project) }}"> {{ $project->title}}  </a></li>
        @empty
            <li>No hay proyectos para mostrar</li>
        @endforelse
    </ul>

@endsection
