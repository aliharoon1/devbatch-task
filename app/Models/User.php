<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function hasPermission($permission)
    {
        $role = $this->role;
        if (!$role) {
            return false;
        }
        $permissions = json_decode($role->permissions, true);

        return isset($permissions[$permission]) && $permissions[$permission];
    }

    public function isAdmin()
    {
        return $this->role_id === Role::where('slug', 'admin')->first()->id;
    }

    public function isManager()
    {
        return $this->role_id === Role::where('slug', 'manager')->first()->id;
    }

    public function isRegularUser()
    {
        return $this->role_id === Role::where('slug', 'regular_user')->first()->id;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}
