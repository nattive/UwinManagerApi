<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FuelConsumptionReport extends Model
{
    protected $fillable = [
        'date_finished',
        'date_supplied',
        'usage_duration',
        'volume',
        'petrol_station',
        'hasReceive',
        'pricePerLitre',
        'report_date',
        'orderInterval',
        'user_id',
        'approvedBy'
    ];

    public function setDateFinishedAttribute($value)
    {
        $this->attributes['date_finished'] = (new Carbon($value))->format('d/m/y');
    }

    public function setDateSuppliedAttribute($value)
    {
        $this->attributes['date_supplied'] = (new Carbon($value))->format('d/m/y');
    }

    public function setDateDurationAttribute($value)
    {
        $this->attributes['usage_duration'] = (new Carbon($value))->format('d/m/y');
    }

    public function getCreatedAtAttribute($item)
    {
        $item = Carbon::parse($item);
        return $item->diffForHumans([
            'parts' => 2,
        ]);
    }
    public function getUpdatedAtAttribute($item)
    {
        $item = Carbon::parse($item);
        return $item->diffForHumans([
            'parts' => 2,
        ]);
    }

    public function getReportDateAttribute($item)
    {
       return Carbon::parse($item)->toFormattedDateString();

    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
