<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'sid';

    protected $hidden = [
        'sid'
    ];

    protected $guarded = [
        'sid',
        'id'
    ];

    //비밀번호 암호화
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setByPost($data)
    {
        if( !$data['sid'] ){
            $this->id = $data['id'];
        }
        if( $data['password'] ){
            $this->password = $data['password'];    
        }
        $this->name = $data['name'];
        $this->email = $data['email'];
    }
}
