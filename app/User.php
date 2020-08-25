<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'isActive',
        'email',
        'head_of_manager_id',
        'location',
        'phoneNumber',
        'guarantorPhone',
        'guarantorAddress',
        'thumbnail_url',
        'url',
        'isOnline',
        'email_verified_at',
        'password',
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
        return $this->belongsToMany('App\Chat');
    }
    public function groups()
    {
        return $this->belongsToMany('App\Group');
    }
    public function getIsActiveAttribute($type)
    {
        switch ($type) {
            case 'true':
                return 'true';
                break;
            case true:
                return 'true';
                break;
            case 1:
                return true;
                break;
            case '1':
                return 'true';
                break;
            case 'false':
                return 'false';
                break;
            case false:
                return false;
                break;
            case 0:
                return 'false';
                break;
 case '0':
                return 'false';
                break;

            default:
              return 'false';
;
                break;
        }

    }
}
