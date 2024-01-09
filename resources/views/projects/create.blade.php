@extends('layouts.app')

@section('content')
    <h1>Create Project</h1>
    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <button type="submit">Create Project</button>
    </form>
@endsection
