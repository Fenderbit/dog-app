@extends('adminlte::page')

@section('title', 'Edit Dog')

@section('content_header')
    <h1>Edit Dog</h1>
@stop

@section('content')
    <form action="{{ route('admin.dogs.update', $dog->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $dog->name }}" required>
        </div>
        <div class="form-group">
            <label for="health_level">Health Level</label>
            <input type="number" name="health_level" class="form-control" value="{{ $dog->health_level }}" required step="0.01" min="0" max="4">
        </div>
        <div class="form-group">
            <label for="hunger_level">Hunger Level</label>
            <input type="number" name="hunger_level" class="form-control" value="{{ $dog->hunger_level }}" required step="0.01" min="0" max="4">
        </div>
        <div class="form-group">
            <label for="image_url">Image</label>
            <input type="file" name="image_url" class="form-control">
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" class="form-control" value="{{ $dog->price }}" required step="0.01" min="0">
        </div>
        <button type="submit" class="btn btn-primary">Update Dog</button>
    </form>
@stop

@push('scripts')
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
            });
        </script>
    @endif
@endpush
