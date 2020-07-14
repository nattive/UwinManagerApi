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
        'user_id',
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
}
