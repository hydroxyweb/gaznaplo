<?php

namespace App\Models;

use Carbon\Carbon;

class ConsumptionLog extends Model
{

    protected $table = 'consumption_log';
    
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'amount'
    ];

    /**
     * Indicates if the model should be timestamped.
     * @var bool
     */
    public $timestamps = true;

    /**
     * Retrieves the last reported record from the log by the given date
     */
    public function lastReportedRecord($date)
    {
        $givenDate = new Carbon($date);
        $firstDayOfMonth = $givenDate->copy()->startOfMonth()->toDateString();
        $lastDayOfMonth = $givenDate->copy()->endOfMonth()->toDateString();
        return self::where('reported', '1')
                ->where('created_at', '>=', $firstDayOfMonth)
                ->where('created_at', '<=', $lastDayOfMonth)
                ->first();
    }

    /**
     * Retrives the sum of consumptions
     */
    public function consumptionSummary($date)
    {
        return self::where('created_at', '>', $date)
                ->where('reported', 0)
                ->sum('diff_by_amount');
    }
}
