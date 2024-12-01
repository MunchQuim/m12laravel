@extends('layouts.layout') <!-- un layout para los usuarios -->
@section('title', 'Create User') 
@section('content') 
<h1>Create a New User</h1>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error) 
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('users.store') }}" method="POST" autocomplete="off">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="usuario" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input class="form-control" id="email" name="email" placeholder="mail" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="contraseña" required>
    </div>
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Repite la contraseña</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="contraseña" required>
    </div>
    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select class="form-control" id="role" name="role" required>
            <option value="">Selecciona un rol</option>
            <option value="admin">Admin</option>
            <option value="teacher">Teacher</option>
            <option value="student">Student</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
</form>
@endsection
