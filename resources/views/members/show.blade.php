@extends('layouts.app')

@section('content')
    <h1>Member: {{ $member->first_name }} {{ $member->last_name }}</h1>
    <h3>City: {{ $member->city }}</h3>
    <h3>State: {{ $member->state }}</h3>
    <h3>Country: {{ $member->country }}</h3>
    <h3>Team: {{ $member->team->name }}</h3>
@endsection
