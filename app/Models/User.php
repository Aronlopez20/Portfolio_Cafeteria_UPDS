<?php
// Actualizar app/Models/User.php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'student_code',
        'employee_code',
        'department',
        'google_id',
        'avatar',
        'status',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    // Relaciones
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles')
                   ->withTimestamps()
                   ->withPivot(['assigned_at', 'assigned_by']);
    }

    public function userRoles()
    {
        return $this->hasMany(UserRole::class);
    }

    // Métodos de roles
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles()->where('name', $role)->exists();
        }
        
        if (is_array($role)) {
            return $this->roles()->whereIn('name', $role)->exists();
        }
        
        return false;
    }

    public function hasAnyRole($roles)
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    public function assignRole($role, $assignedBy = null)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
        }

        if (!$role) {
            return false;
        }

        // Verificar si ya tiene el rol
        if ($this->hasRole($role->name)) {
            return true;
        }

        $this->roles()->attach($role->id, [
            'assigned_at' => now(),
            'assigned_by' => $assignedBy,
        ]);

        return true;
    }

    public function removeRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
        }

        if (!$role) {
            return false;
        }

        $this->roles()->detach($role->id);
        return true;
    }

    public function hasPermission($permission)
    {
        foreach ($this->roles as $role) {
            if ($role->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    // Métodos de conveniencia
    public function isStudent()
    {
        return $this->hasRole(Role::STUDENT);
    }

    public function isAdmin()
    {
        return $this->hasRole(Role::ADMIN);
    }

    public function isKitchen()
    {
        return $this->hasRole(Role::KITCHEN);
    }

    public function isStaff()
    {
        return $this->hasAnyRole([Role::ADMIN, Role::KITCHEN]);
    }

    public function getMainRole()
    {
        // Prioridad: Admin > Kitchen > Student
        if ($this->isAdmin()) {
            return $this->roles()->where('name', Role::ADMIN)->first();
        }
        
        if ($this->isKitchen()) {
            return $this->roles()->where('name', Role::KITCHEN)->first();
        }
        
        return $this->roles()->where('name', Role::STUDENT)->first();
    }

    public function getDisplayName()
    {
        $mainRole = $this->getMainRole();
        return $mainRole ? "{$mainRole->icon} {$this->name}" : "👤 {$this->name}";
    }

    // Scopes
    public function scopeStudents($query)
    {
        return $query->whereHas('roles', function($q) {
            $q->where('name', Role::STUDENT);
        });
    }

    public function scopeStaff($query)
    {
        return $query->whereHas('roles', function($q) {
            $q->whereIn('name', [Role::ADMIN, Role::KITCHEN]);
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}