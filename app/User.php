<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'provider', 'provider_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        foreach (auth()->user()->roles as $role) {
            if (($role->role === 'superadmin') || ($role->role === 'admin')){
                return true;
            }
        }
        return false;
    }

    public function hasRole($role)
    {
        foreach (auth()->user()->roles as $userRole) {
            if ($userRole->role === $role){
                return true;
            }
        }
        return false;
    }

    /**
     * Get all of the roles for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roles()
    {
        return $this->hasMany(UserRole::class, 'user_id', 'id');
    }
}
