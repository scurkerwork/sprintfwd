@extends('layouts.app')

@section('content')
    <h1>Team: {{ $team->name }}</h1>
    <h3>Members:</h3>
    <ul>
        @foreach($teamMembers as $member)
            <li>{{ $member->first_name }} {{ $member->last_name }}</li>
        @endforeach
    </ul>
@endsection
