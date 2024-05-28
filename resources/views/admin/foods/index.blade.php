@extends('adminlte::page')

@section('title', 'Foods')

@section('content_header')
    <h1>Foods</h1>
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
            <th>Duration (Hours)</th>
            <th>Image</th>
            <th>Price</th>
            <th>Income Price</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($foods as $food)
            <tr>
                <td>{{ $food->name }}</td>
                <td>{{ $food->duration_hours }}</td>
                <td><img src="{{ asset('storage/' . $food->image_url) }}" alt="{{ $food->name }}" width="50"></td>
                <td>{{ $food->price }}</td>
                <td>{{ $food->income_price }}</td>
                <td>
                    <a href="{{ route('admin.foods.edit', $food->id) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('admin.foods.destroy', $food->id) }}" method="POST" style="display:inline-block;">
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
