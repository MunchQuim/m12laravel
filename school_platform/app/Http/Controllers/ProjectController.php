<?php
namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\User;
use App\Models\RelUserProject;
use Illuminate\Http\Request;
use App\Http\Controllers\FileController;
class ProjectController extends Controller
{
    // Mostrar la lista de proyectos
    public function index()
    {
        // Obtener todos los proyectos con el usuario relacionado
        $projects = Project::all(); 
        $relUserProjects = RelUserProject::all();
        return view('projects.index', compact('projects','relUserProjects'));// Pasar a la vista
    }
    // Mostrar el formulario de creación
    public function create()
    {
        $users = User::where('role','student')->get();
        // Mostrar el formulario de creación
        return view('projects.create',compact('users'));
    }
    // Guardar un nuevo proyecto
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
        ]);
        if( auth()->check()){
            $defaultUser = auth() ->user();
        } else{
        // Verificamos si existe al menos un usuario en la base de datos
        $defaultUser = User::first();
        }

        if (!$defaultUser) {
            return redirect()->route('projects.index')->with('error', 'No default user found. Please create a user first.');
        }
        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'user_id' => $defaultUser->id, // Usuario predeterminado
        ]);

        //añadimos a relUserProjects
        //obtenemos la id del project
        $project_id = $project-> id;
        $ids = $request->userId;
        foreach ($ids as $id) {
            //por cada usuario dado creamos una reluserproject
            RelUserProject::create([
                'user_id' => $id,
                'project_id' => $project_id,
            ]);
        }
        return redirect()->route('projects.index')->with('success', 'Project created successfully!');
    }
    // Mostrar un proyecto específico
    public function show(Project $project)
    {
        $relUserProjects = RelUserProject::where('project_id', $project->id)->get();
        return view('projects.show', compact('project','relUserProjects'));
    }
    // Mostrar el formulario de edición
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }
    // Actualizar un proyecto
    public function update(Request $request, Project $project)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
        ]);
        $project->update($request->only([
            'name',
            'description',
            'deadline'
        ]));
        return redirect()->route('projects.index')->with(
            'success',
            'Project updated successfully!'
        );
    }
    // Eliminar un proyecto
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with(
            'success',
            'Project deleted successfully!'
        );
    }
    
}
