<?php

namespace App\Models;

class CharacteristicCurve extends Model
{

    protected $table = 'characteristic_curve';
    
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'month', 'max_limit'
    ];

    /**
     * Indicates if the model should be timestamped.
     * @var bool
     */
    public $timestamps = true;
}
