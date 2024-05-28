@extends('adminlte::page')

@section('title', 'Edit Food Purchase')

@section('content_header')
    <h1>Edit Food Purchase</h1>
@stop

@section('content')
    <form action="{{ route('admin.users.updateFood', [$user->id, $food->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="food_id">Food ID</label>
            <input type="text" name="food_id" class="form-control" value="{{ $food->food_id }}" required>
        </div>
        <div class="form-group">
            <label for="purchased_at">Purchased At</label>
            <input type="datetime-local" name="purchased_at" class="form-control" value="{{ $food->purchased_at->format('Y-m-d\TH:i') }}" required>
        </div>
        <div class="form-group">
            <label for="is_consumed">Is Consumed</label>
            <input type="checkbox" name="is_consumed" {{ $food->is_consumed ? 'checked' : '' }}>
        </div>
        <button type="submit" class="btn btn-primary">Update Food Purchase</button>
    </form>
@stop
