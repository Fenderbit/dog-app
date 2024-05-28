@extends('adminlte::page')

@section('title', 'Add Food')

@section('content_header')
    <h1>Add Food</h1>
@stop

@section('content')
    <form action="{{ route('admin.food.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="duration_hours">Duration (Hours)</label>
            <input type="number" name="duration_hours" class="form-control" required min="0">
        </div>
        <div class="form-group">
            <label for="image_url">Image</label>
            <input type="file" name="image_url" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" class="form-control" required step="0.01" min="0">
        </div>
        <div class="form-group">
            <label for="income_price">Income Price (%)</label>
            <input type="number" name="income_price" class="form-control" required step="0.01" min="0">
        </div>
        <button type="submit" class="btn btn-primary">Add Food</button>
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
