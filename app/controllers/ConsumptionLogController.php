<?php
namespace App\Controllers;

use App\Models\ConsumptionLog;
use Carbon\Carbon;

class ConsumptionLogController extends Controller
{
    public function log() 
    {
        $newAmount = request()->get('amount') ?? 0;
        $log = new ConsumptionLog;
        $lastEntry = ConsumptionLog::latest()->first();

        $log->amount = $newAmount;
        $diffByAmount = abs($lastEntry->amount - $newAmount);
        $log->diff_by_amount = $diffByAmount;

        $date = Carbon::parse($lastEntry->created_at);
        $now = Carbon::now();
        $diffInDays = floor($date->diffInDays($now));
        $log->diff_by_date = $diffInDays;

        $log->average_consumption = $diffByAmount / $diffInDays;
        
        $log->save();
    }
}