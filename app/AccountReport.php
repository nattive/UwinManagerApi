<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AccountReport extends Model
{
    protected $fillable = [
        'cashFunded',
            'eCreditFunded',
            'expectedCashAtHand',
            'expenseTotal',
            'fuel',
            'misc',
            'onlineBalance',
            'pos',
            'totalPayout',
            'report_date',
            'totalRunCred',
            'unsettledWinnings',
    ];

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
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getReportDateAttribute($item)
    {
       return Carbon::parse($item)->toFormattedDateString();

    }
}
