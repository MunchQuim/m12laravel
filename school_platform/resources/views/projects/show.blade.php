@extends('layouts.layout') 
@section('title', 'Project Details') 
@section('content') 
 <h1>{{ $project->name }}</h1>
 <p><strong>Description:</strong> {{ $project->description }}</p>
 <p><strong>Deadline:</strong> {{ $project->deadline }}</p>
 <p><strong>User:</strong> {{ $project->user->name }}</p>
 @if($role == 'student')
    @include('layouts.entrega')
 @endif
 <a href="{{ route('projects.index') }}" class="btn btn-secondary">Back to List</a>
@endsection