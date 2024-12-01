<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelUserProject extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rel_users_projects';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false; // Deshabilitado porque no tiene `created_at`

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'project_id',
        'updated_at',
        'file_url',
    ];

    /**
     * Get the user that owns the relationship.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the project that owns the relationship.
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}