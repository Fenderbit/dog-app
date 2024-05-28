@extends('adminlte::page')

@section('title', 'Add Dog')

@section('content_header')
    <h1>Add Dog</h1>
@stop

@section('content')
    <form action="{{ route('admin.dog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="image_url">Image</label>
            <input type="file" name="image_url" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" class="form-control" required step="0.01" min="0">
        </div>
        <button type="submit" class="btn btn-primary">Add Dog</button>
    </form>
@stop
