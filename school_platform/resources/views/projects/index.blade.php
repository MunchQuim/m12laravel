@extends('layouts.layout') 
@section('title', 'Projects List') 
@section('content') 
<h1>Projects List</h1>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if ($role == 'admin' || $role == 'teacher')
<a href="{{ route('projects.create') }}" class="btn btn-primary mb-3">Create New Project</a>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Deadline</th>
            <th>User</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @forelse ($projects as $project)
    @if ($role == 'admin' || ($role == 'teacher' && $project->user_id == auth()->user()->id) || $relUserProjects->where('user_id', auth()->user()->id)->where('project_id', $project->id)->isNotEmpty())
        <tr>
            <td>{{ $project->name }}</td>
            <td>{{ $project->description }}</td>
            <td>{{ $project->deadline }}</td>
            <td>{{ $project->user->name }}</td>
            <td>
                @if ($role == 'student')
                    <a href="{{ route('projects.show', $project) }}" class="btn btn-info btn-sm">View</a>
                @endif
                
                @if ($role == 'admin' || $role == 'teacher')
                    <a href="{{ route('projects.show', $project) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('projects.destroy', $project) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                @endif
            </td>
        </tr>
    @endif
@empty
    <tr>
        <td colspan="5" class="text-center">No projects found.</td>
    </tr>
@endforelse
    </tbody>
</table>
@endsection