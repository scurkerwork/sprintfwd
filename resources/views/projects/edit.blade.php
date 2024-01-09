@extends('layouts.app')

@section('content')
    <h1>Edit Project</h1>
    <form action="{{ route('projects.update', $project->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ $project->name }}" required>
        <label for="members">Member:</label>
        <select name="member_id" id="members">
            @foreach($members as $member)
                <option
                    value="{{ $member->id }}"
                >
                    {{ $member->first_name }} {{ $member->last_name }}
                </option>
            @endforeach
        </select>
        <button type="submit">Update Project</button>
    </form>
@endsection
