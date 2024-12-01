@extends('layouts.layout') 
@section('title', 'users List') 
@section('content') 
<h1>Users List</h1>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Create New User</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $user) 
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="{{ route('users.show', $project) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('users.edit', $project) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route(
                    'users.destroy',
                    $user
                ) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger 
            btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">No projects
                    found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection