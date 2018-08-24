<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function rules()
    {
        return [
          'name' => 'required',
          'email' => 'required',
          'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nome Obrigatório',
            'password' => 'Senha Obrigatória',
            'password.required'=> 'Senha Obrigatória!'
        ];
    }
}
