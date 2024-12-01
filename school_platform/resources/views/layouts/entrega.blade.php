<?php 
use App\Models\RelUserProject;
$relUserProject = RelUserProject::where('user_id', auth()->user()->id)
->where('project_id', $project->id)
->first();
?>
@if($relUserProject)
        <div class="mt-4">
            <p><strong>Uploaded File:</strong> {{ basename($relUserProject->file_url) }}</p>
            <a href="{{ route('download.file', ['userId' => auth()->user()->id, 'projectId' => $project->id]) }}" class="btn btn-primary">
        Download File
    </a>
        </div>
@endif
<form class="m-3" action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="project_id" value="{{ $project->id }}"><!-- show ya da project -->
    <input type="file" name="file" accept="application/pdf"> <!-- cambiar a pdf -->
    <button type="submit">Subir archivo</button>
</form>