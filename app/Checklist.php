<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    // protected $dates = [
    //     'timeOfTheDay',
    // ];
    protected $fillable = [
        'user_id',
        'isLate',
        'isOkay',
        'nextChecklist',
        'lastChecked',
        'timeOfTheDay',
    ];

    public function user(){
        return $this-> belongsTo('App\User');
    }
}
