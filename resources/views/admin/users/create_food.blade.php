@extends('adminlte::page')

@section('title', 'Add Food Purchase')

@section('content_header')
    <h1>Add Food Purchase</h1>
@stop

@section('content')
    <form action="{{ route('admin.users.addFood', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="food_id">Food ID</label>
            <input type="text" name="food_id" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Food Purchase</button>
    </form>
@stop
