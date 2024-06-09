@extends('adminlte::page')

@section('title', 'User Details')

@section('content_header')
    <h1>User Details</h1>
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

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
            });
        </script>
    @endif

    <h3>Details</h3>
    <table class="table table-bordered">
        <tr>
            <th>Telegram ID</th>
            <td>{{ $user->id_telegram }}</td>
        </tr>
        <tr>
            <th>First Name</th>
            <td>{{ $user->first_name }}</td>
        </tr>
        <tr>
            <th>Last Name</th>
            <td>{{ $user->last_name }}</td>
        </tr>
        <tr>
            <th>Username</th>
            <td>{{ $user->username }}</td>
        </tr>
        <tr>
            <th>Balance</th>
            <td>{{ $user->balance }}</td>
        </tr>
    </table>

    <h3>Dogs</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Name</th>
            <th>Health Level</th>
            <th>Hunger Level</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($dogs as $dog)
            <tr>
                <td>{{ $dog->name }}</td>
                <td>{{ $dog->health_level }}</td>
                <td>{{ $dog->hunger_level }}</td>
                <td>
                    <a href="{{ route('admin.editDog', [$user->id, $dog->id]) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('admin.users.deleteDog', [$user->id, $dog->id]) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h3>Food Purchases</h3>
    <a href="{{ route('admin.users.createFood', $user->id) }}" class="btn btn-success mb-3">Add Food Purchase</a>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Name</th>
            <th>Purchased At</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($foodPurchases as $purchase)
            <tr>
                <td>{{ $purchase->food->name ?? '' }}</td>
                <td>{{ $purchase->purchased_at ?? '' }}</td>
                <td>
                    <form action="{{ route('admin.users.deleteFood', [$user->id, $purchase->id]) }}" method="POST" style="display:inline-block;">
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
