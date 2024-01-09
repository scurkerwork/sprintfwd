@extends('layouts.app')

@section('content')
    <h1>Create Member</h1>
    <form action="{{ route('members.store') }}" method="POST">
        @csrf
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" required>
        <br />
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" required>
        <br />
        <label for="city">City:</label>
        <input type="text" name="city" required>
        <br />
        <label for="state">State:</label>
        <input type="text" name="state" required>
        <br />
        <label for="country">Country:</label>
        <input type="text" name="country" required>
        <br />
        <label for="team">Team:</label>
        <select name="team_id" id="team">
            @foreach($teams as $team)
                <option value="{{ $team->id }}">{{ $team->name }}</option>
            @endforeach
        </select>
        <br />
        <button type="submit">Create Member</button>
    </form>
@endsection
