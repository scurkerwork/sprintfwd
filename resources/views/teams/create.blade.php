@extends('layouts.app')

@section('content')
    <h1>Create Team</h1>
    <form action="{{ route('teams.store') }}" method="POST">
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <button type="submit">Create Team</button>
    </form>
@endsection
