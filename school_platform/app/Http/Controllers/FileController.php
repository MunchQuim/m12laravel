<?php

namespace App\Http\Controllers;
use App\Models\RelUserProject;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
class FileController extends Controller
{
    public function store($userId, $projectId, $fileUrl)
    {
        RelUserProject::create([
            'user_id' => $userId,
            'project_id' => $projectId,
            'updated_at' => now(),
            'file_url' => $fileUrl,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }
    public function upload(Request $request)
    {
        $file = $request->file('file');

        // Validar el archivo
        $request->validate([ /* controla que puedan ser esos archivos */
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,pdf|max:102400',
        ]);

        // Verificar si se ha subido un archivo
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            // Obtener el archivo
            $file = $request->file('file');

            // Generar un nombre único para el archivo
            $fileName = time() . '.' . $file->getClientOriginalExtension();

            // obtener la id del usuario
            $userId = auth()->user()->id;

            //obtener la id del proyecto
            $projectId = $request->input('project_id');

            //mirar si ya se encuentra en la base de datos a traves de userId y projectId
            $relUserProject = RelUserProject::where('user_id', $userId)
                ->where('project_id', $projectId)
                ->first();

            if ($relUserProject) {
                // Si el registro ya existe, borra el archivo
                $fileUrl = $relUserProject->file_url;
                if ($fileUrl && Storage::disk('public')->exists($fileUrl)) {
                    // Eliminar el archivo de almacenamiento
                    Storage::disk('public')->delete($fileUrl);
                }
                // Guardar el archivo en el directorio 'uploads'
                $filePath = $file->storeAs('uploads', $fileName, 'public');

                // y actualiza el modelo.
                $updated = DB::table('rel_users_projects')/* se utiliza si las claves son compuestas */
                    ->where('user_id', $userId)
                    ->where('project_id', $projectId)
                    ->update([
                        'updated_at' => now(),
                        'file_url' => $filePath,
                ]);
                return back()->with('success', 'Archivo actualizado con éxito.')->with('file', $filePath);
            } else {
                // Guardar el archivo en el directorio 'uploads'
                $filePath = $file->storeAs('uploads', $fileName, 'public');
                //store en el modelo
                $this->store($userId, $projectId, $filePath);
            }



            return back()->with('success', 'Archivo subido con éxito.')->with('file', $filePath);
        }

        return back()->with('error', 'Hubo un problema al subir el archivo.');
    }
    public function downloadFile($userId, $projectId)
{
    // Verificar si el archivo existe para el usuario y el proyecto
    $relUserProject = RelUserProject::where('user_id', $userId)
                                     ->where('project_id', $projectId)
                                     ->first();

    if ($relUserProject && file_exists(storage_path('app/public/' . $relUserProject->file_url))) {
        return response()->download(storage_path('app/public/' . $relUserProject->file_url));
    }

    return redirect()->back()->with('error', 'File not found.');
}
}
