<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Project extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'deadline', 'user_id'];
    // Campos rellenables
    // Relación con el modelo User
    public function user()
    {
        // Un proyecto pertenece a un usuario
        return $this->belongsTo(User::class); // Relación de uno a muchos
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'rel_users_projects', 'project_id', 'user_id')
            ->withPivot('updated_at', 'file_url');
    }
}
