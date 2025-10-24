<?php
namespace App\Controllers;

use App\Models\ConsumptionLog;

class ConsumptionLogController extends Controller
{
    public function log() 
    {
        $log = new ConsumptionLog;
        
        $log->amount = request()->get('amount') ?? 0;

        $log->save();
    }
}