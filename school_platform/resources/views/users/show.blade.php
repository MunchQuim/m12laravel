@extends('layouts.layout') 
@section('title', 'User Details') 
@section('content') 
 <h1>{{ $user->name }}</h1>
 <p><strong>name:</strong> {{ $user->name }}</p>
 <p><strong>email:</strong> {{ $user->email }}</p>
 <p><strong>password:</strong> {{ $user->password }}</p>
 <p><strong>role:</strong> {{ $user->role }}</p>
 <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
@endsection