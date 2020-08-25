<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    const PERPAGE = 10;

    const SUCCESS = 'success';
    const UNSUCCESS = 'unsuccess';

    const MALE = 'Male';
    const FEMALE = 'Female';

    const MEMBER= 'Member';
    const MANAGER= 'Manager';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'birthday', 'gender', 'department', 'avatar', 'address'
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

    public function setBirthdayAttribute($date) 
    {
        $this->attributes['birthday'] = date('Y-m-d', strtotime($date));
    }

    public function genders() {
        $data = [
            ['value' => self::MALE, 'name' => self::MALE],
            ['value' => self::FEMALE, 'name' => self::FEMALE],
        ];
        
        return $data;
    }


    public function departments() {
        $data = [
            ['value' => self::MEMBER, 'name' => self::MEMBER],
            ['value' => self::MANAGER, 'name' => self::MANAGER],
        ];
        
        return $data;
    }
}
