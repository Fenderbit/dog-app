@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    <h1>Edit User</h1>
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

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="id_telegram">Telegram ID</label>
            <input type="text" name="id_telegram" class="form-control" value="{{ $user->id_telegram }}" readonly>
        </div>
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}">
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}">
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" value="{{ $user->username }}">
        </div>
        <div class="form-group">
            <label for="balance">Balance</label>
            <input type="number" name="balance" class="form-control" value="{{ $user->balance }}" step="0.01" min="0">
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
@stop
