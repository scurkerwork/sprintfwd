@extends('layouts.app')

@section('content')
    <h1>Projects</h1>
    <a href="{{ route('projects.create') }}">Create Project</a>

    <ul>
        @foreach($projects as $project)
            <li>
                <a href="{{ route('projects.show', $project->id) }}">{{ $project->name }}</a>
                <a href="{{ route('projects.edit', $project->id) }}"><button>Edit</button></a>
                <form action="{{ route('projects.destroy', $project->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
