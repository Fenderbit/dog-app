@extends('adminlte::page')

@section('title', 'Edit Food')

@section('content_header')
    <h1>Edit Food</h1>
@stop

@section('content')
    <form action="{{ route('admin.foods.update', $food->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $food->name }}" required>
        </div>
        <div class="form-group">
            <label for="duration_hours">Duration (Hours)</label>
            <input type="number" name="duration_hours" class="form-control" value="{{ $food->duration_hours }}" required min="0">
        </div>
        <div class="form-group">
            <label for="image_url">Image</label>
            <input type="file" name="image_url" class="form-control">
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" class="form-control" value="{{ $food->price }}" required step="0.01" min="0">
        </div>
        <div class="form-group">
            <label for="income_price">Income Price</label>
            <input type="number" name="income_price" class="form-control" value="{{ $food->income_price }}" required step="0.01" min="0">
        </div>
        <button type="submit" class="btn btn-primary">Update Food</button>
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
