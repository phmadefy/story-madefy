<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = "users";

    protected $fillable = [
        'company_id',
        'nome',
        'email',
        'password',
        'uuid',
        'status',
        'permission_id',
        'master',
        'layout'
    ];

    protected $hidden = ['id', 'password'];

    // public function company()
    // {
    //     return $this->hasOne('App\Models\Company', 'uuid', 'company_id');
    // }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function permissions()
    {
        return $this->hasOne('App\Models\UserPermission', 'uuid', 'permission_id');
    }
}
