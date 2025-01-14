
@extends('layouts.layout') 
@section('title', 'Edit User') 
@section('content') 
<h1>Edit User</h1>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error) 
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('users.update', $user) }}" method="POST">
    @csrf
    @method('PUT') 
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $user['name'] }}" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">email</label>
        <input class="form-control" id="email" name="email" value="{{ $user['email'] }}" required></input>
    </div>
    @if ($role == 'admin')
        <div class="mb-3">
        <label for="role" class="form-label">Role</label>
            <select class="form-control" id="role" name="role" required>
                <option value="admin">Admin</option>
                <option value="teacher">Teacher</option>
                <option value="student">Student</option>
            </select>
        </div>
    @endif
    <!-- <div class="mb-3">
        <label for="password" class="form-label">password</label>
        <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" required>
    </div> -->
    
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection