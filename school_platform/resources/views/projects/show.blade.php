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
@if($role == 'admin' || $role == 'teacher')
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th><!-- del student -->
                    <th>Fecha de entrega</th>
                    <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($relUserProjects as $relUserProject) 
                <tr>
                    <td>{{$relUserProject->user->name }}</td>
                    <td>{{ $relUserProject->updated_at }}</td>
                    <td>
                        <a href="{{ route('download.file', [$relUserProject->user_id, $relUserProject->project_id]) }}"
                            class="btn btn-info btn-sm">descargar</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No projects
                        entregados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endif
<a href="{{ route('projects.index') }}" class="btn btn-secondary">Back to List</a>
@endsection