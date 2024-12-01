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
<form action="{{ route('users.store') }}" method="POST">
    @csrf
    <!--         'name',
        'email',
        'password',
        -->
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">email</label>
        <input class="form-control" id="email" name="email" value="{{ old('email') }}" required></input>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">password</label>
        <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
</form>
@endsection
