<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AccountReport extends Model
{
    protected $fillable = [
        'unsettledWinnings',
        'totalPayout',
        'expenseTotal',
        'totalPayout',
        'actualCashAtHand',
        'sub_total1',
        'totalRunCred',
        'eCreditFunded',
        'cashFunded',
        'creditUnpaidTotal',
        'expenseTotal',
        'onlineBalance',
        'expectedCashAtHand',
        'sub_total2',
        'fuel',
        'misc',
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
}
