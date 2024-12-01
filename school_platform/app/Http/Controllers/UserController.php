<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
class UserController extends Controller
{
    // Mostrar la lista de proyectos
    public function index()
    {
        $role = auth()->user()->role; //si funciona en el middleware por que no aqui?
        switch ($role) {
            case 'admin':
                $users = User::all();
                break;
            case 'teacher':
                $users = User::where('role', 'student')->get();
                break;            
            default:
                $users = collect(); //coleccion vacia para poder devolver algo
                break;
        }
       // Obtener todos los proyectos con el usuario relacionado
             
       return view('users.index', compact('users'));// Pasar a la vista
    }
    // Mostrar el formulario de creación VV
    public function create()
    {
        // Mostrar el formulario de creación
        return view('users.create');
    }
    // Guardar un nuevo Usuario VV
    public function store(Request $request)
    {
        $role = auth()->user()->role; //si funciona en el middleware por que no aqui?
        switch ($role) {
            case 'admin':
                $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:users,email|max:255',
                    'password' => 'required|string|min:6|confirmed',
                    'role' => 'required|string|in:admin,teacher,student',
                ]);
                break;
            case 'teacher':
                $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:users,email|max:255',
                    'password' => 'required|string|min:6|confirmed',
                    'role' => 'required|string|in:student',
                ]);//podria no hacerlo pero me curo en salud para que solo puedan crear estos usuarios
                break; 
            default:
            $request->validate(['name' => 'required|string|max:-1',]);    //con esto deberia impedir que se creen
                break;
        }        
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request-> password), // encriptamos la contraseña
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }
    // Mostrar un usuario específico VV
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
    // Mostrar el formulario de edición VV
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }
    // Actualizar un Usuario VV
    public function update(Request $request, User $user)
    {
        
        // Validar los datos del formulario
        $request->validate([
            'name' => 'string|max:255',
            'password' => 'string|min:6|confirmed',
            'role' => 'string|in:admin,teacher,student',
        ]);
        // si se ha llegado a enviar contraseña, la puede enviar encriptada
        $data = $request->only(['name', 'email', 'role']);
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
       
            if($request->filled('email') && $user['email']!=$request['email']){//si ha cambiado el mail validalo
                $request->validate([
                    'email' => 'email|unique:users,email|max:255',
                ]);
            }
        
        // si no ha venido un rol (porque lo ha hecho un profesor)
        if (!$request->filled('role')) {
            $data['role'] = 'student';
        }
        $user->update($data);
        return redirect()->route('users.index')->with(
            'success',
            'User updated successfully!'
        );
    }
    // Eliminar un proyecto
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with(
            'success',
            'User deleted successfully!'
        );
    }
    
}
