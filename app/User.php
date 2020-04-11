<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable , SoftDeletes;
    const  VERIFIED_USER = '1';
    const  UNVERIFIED_USER = '0';

    const  ADMIN_USER = 'true';
    const  REGULAR_USER = 'false';

    protected $table = 'users';
    protected $dates = ['deleted_at'];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'verified', 'verification_token', 'admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'verification_token',
    ];
     // @@@@@@@@ am functionana bo awa bakaryat nawakani database hamwe bkat ba small 
     public function setNameAttribute($name){     
         $this->attributes['name'] = strtolower($name);
     }
     public function getNameAttribute($name){  // ama bo awaya ka pity yakamy bkat ba capital
         return ucwords($name);
     }
     public function setEmailAttribute($email){   // ama bo awaya ka emailakan hamwyan bkat ba small
         $this->attributes['email'] = strtolower($email);
     }
     // @@@@@@@@@

    public function isVerified()
    {
        return $this->verified == User::VERIFIED_USER;
    }
    public function isAdmin()
    {
        return $this->admin == User::ADMIN_USER;
    }
    public static function  generateVerificationCode()
    {
        return str_random(40);
    }
}
