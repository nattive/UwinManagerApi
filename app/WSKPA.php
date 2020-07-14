<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class WSKPA extends Model
{
    protected $fillable = [
        'full_name',
        'work_attendance',
        'punctuality',
        'accountability',
        'workPercentage',
        'cr_rs',
        'revenue_per_day',
        'user_id',
        'appearance',
        'general_equipment_maintenance',
    ];
    public function getCreatedAtAttribute($value)
    {
        $carbon = Carbon::parse($value);
        return $carbon->diffForHumans([
            'parts' => 2,
        ]);
    }
    public function getUpdatedAtAttribute($value)
    {
        $carbon = Carbon::parse($value);
        return $carbon->toDateTimeString();
    }
}
