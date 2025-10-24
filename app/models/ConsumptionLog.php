<?php

namespace App\Models;

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
     * Retrieves the last reported record from the log
     */
    public function lastReportedRecord()
    {
        return self::where('reported', '1')
                ->latest()
                ->first();
    }

    public function consumptionSummary($lastReportedDate)
    {
        return self::where('created_at', '>', $lastReportedDate)
                ->where('reported', 0)
                ->sum('diff_by_amount');
    }
}
