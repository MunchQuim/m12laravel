<?php

namespace App\Http\Controllers;
use App\Models\RelUserProject;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload(Request $request)
    {
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

            // Guardar el archivo en el directorio 'uploads'
            $filePath = $file->storeAs('uploads', $fileName, 'public');

            return back()->with('success', 'Archivo subido con éxito.')->with('file', $filePath);
        }

        return back()->with('error', 'Hubo un problema al subir el archivo.');
    }
}
