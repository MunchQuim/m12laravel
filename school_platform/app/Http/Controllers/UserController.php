<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
class UserController extends Controller
{
    // Mostrar la lista de proyectos
    public function index()
    {
       // Obtener todos los proyectos con el usuario relacionado
       $users = User::all();       
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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string|in:admin,teacher,student',
        ]);
        
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
            'email' => 'email|unique:users,email|max:255',
            'password' => 'string|min:6|confirmed',
            'role' => 'string|in:admin,teacher,student',
        ]);
        $data = $request->only(['name', 'email', 'role']);
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
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
