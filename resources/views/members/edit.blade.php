@extends('layouts.app')

@section('content')
    <h1>Edit Member</h1>
    <form action="{{ route('members.update', $member->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" value="{{ $member->first_name }}" required>
        <br />
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="{{ $member->last_name }}" required>
        <br />
        <label for="city">City:</label>
        <input type="text" name="city" value="{{ $member->city }}" required>
        <br />
        <label for="state">State:</label>
        <input type="text" name="state" value="{{ $member->state }}" required>
        <br />
        <label for="country">Country:</label>
        <input type="text" name="country" value="{{ $member->country }}" required>
        <br />
        <label for="team">Team:</label>
        <select name="team_id" id="team">
            @foreach($teams as $team)
                <option
                    {{ $team->id === $member->team->id ? 'selected' : '' }}
                    value="{{ $team->id }}"
                >
                    {{ $team->name }}
                </option>
            @endforeach
        </select>
        <br />
        <button type="submit">Update Member</button>
    </form>
@endsection
