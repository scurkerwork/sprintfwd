@extends('layouts.app')

@section('content')
    <h1>Members</h1>
    <a href="{{ route('members.create') }}">Create Member</a>

    <ul>
        @foreach($members as $member)
            <li>
                <a href="{{ route('members.show', $member->id) }}">{{ $member->first_name }} {{ $member->last_name }}</a>
                <a href="{{ route('members.edit', $member->id) }}"><button>Edit</button></a>
                <form action="{{ route('members.destroy', $member->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
