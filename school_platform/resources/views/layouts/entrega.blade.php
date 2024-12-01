<form class="m-3" action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="project_id" value="{{ $project->id }}"><!-- show ya da project -->
    <input type="file" name="file" accept="application/pdf"> <!-- cambiar a pdf -->
    <button type="submit">Subir archivo</button>
</form>