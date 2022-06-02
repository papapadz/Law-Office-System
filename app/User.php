<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements MustVerifyEmail, Auditable
{
    use \OwenIt\Auditing\Auditable;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'contact_number',
        'email',
        'password',
        'is_verified',
        'verification_code',
        'role_id',
        'specialization',
        'availability',
        'location',
        'roll_number',
        'proof_photo_path',
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

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function lawyer()
    {
        return $this->hasMany(User::class, 'lawyer_id');
    }

    public function client()
    {
        return $this->hasMany(User::class, 'client_ud');
    }

    public function queries()
    {
        return $this->hasMany(Query::class, 'lawyer_id');
    }
}
