@extends('adminlte::page')

@section('title', 'Dogs')

@section('content_header')
    <h1>Dogs</h1>
@stop

@section('content')
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
            });
        </script>
    @endif

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Name</th>
            <th>Health Level</th>
            <th>Hunger Level</th>
            <th>Image</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($dogs as $dog)
            <tr>
                <td>{{ $dog->name }}</td>
                <td>{{ $dog->health_level }}</td>
                <td>{{ $dog->hunger_level }}</td>
                <td><img src="{{ asset('storage/' . $dog->image_url) }}" alt="{{ $dog->name }}" width="50"></td>
                <td>{{ $dog->price }}</td>
                <td>
                    <a href="{{ route('admin.dogs.edit', $dog->id) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('admin.dogs.destroy', $dog->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
