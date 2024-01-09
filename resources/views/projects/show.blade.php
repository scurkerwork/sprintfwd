@extends('layouts.app')

@section('content')
    <h1>Project: {{ $project->name }}</h1>
    <h3>Members:</h3>
    <ul>
        @foreach($members as $member)
            <li>{{ $member->first_name }} {{ $member->last_name }}</li>
        @endforeach
    </ul>
@endsection
