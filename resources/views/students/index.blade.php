@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Resources</h1>
    <a href="{{ route('resources.create') }}" class="btn btn-primary">Add Resource</a>

    @if(session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif

    <ul class="list-group mt-3">
        @foreach($resources as $resource)
            <li class="list-group-item">
                <h4>{{ $resource->title }}</h4>
                <p>{{ $resource->description }}</p>
                <a href="{{ route('resources.edit', $resource->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('resources.destroy', $resource->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
@endsection
