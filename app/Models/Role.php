<?php
// app/Models/Role.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'icon',
        'permissions',
        'is_active'
    ];

    protected $casts = [
        'permissions' => 'array',
        'is_active' => 'boolean',
    ];

    // Constantes de roles
    const STUDENT = 'student';
    const ADMIN = 'admin';
    const KITCHEN = 'kitchen';

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles')
                   ->withTimestamps()
                   ->withPivot(['assigned_at', 'assigned_by']);
    }

    public function userRoles()
    {
        return $this->hasMany(UserRole::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function hasPermission($permission)
    {
        return in_array($permission, $this->permissions ?? []);
    }
}
