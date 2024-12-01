<form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" accept="image/*"> <!-- cambiar a pdf -->
    <button type="submit">Subir archivo</button>
</form>