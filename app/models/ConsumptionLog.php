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
}
