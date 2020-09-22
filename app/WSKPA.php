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
        'report_date',
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

    public function getReportDateAttribute($item)
    {
       return Carbon::parse($item)->toFormattedDateString();

    }

    public function getUpdatedAtAttribute($value)
    {
        $carbon = Carbon::parse($value);
        return $carbon->toDateTimeString();
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
