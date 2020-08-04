<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'password', 'name',
        'business_unit',
        'isHOM',
        'duty',
        'isActive',
        'email',
        'head_of_manager_id',
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

    public function Checklists()
    {
        return $this->hasMany('App\Checklist');
    }
    public function ChatMessages()
    {
        return $this->hasMany('App\ChatMessage');
    }
    public function WSKPAs()
    {
        return $this->hasMany('App\WSKPA');
    }
    public function FuelConsumptionReports()
    {
        return $this->hasMany('App\FuelConsumptionReport');
    } 
      public function AccountReports()
    {
        return $this->hasMany('App\AccountReport');
    } 
    
    public function chats()
    {
        return $this->hasMany('App\Chat');
    }
}
