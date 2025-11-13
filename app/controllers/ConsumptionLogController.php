<?php
namespace App\Controllers;

use App\Models\ConsumptionLog;
use Carbon\Carbon;

class ConsumptionLogController extends Controller
{
    public function log() 
    {
        $params = request()->get('params');
        $newAmount = $params['amount'] ?? 0;
        $log = new ConsumptionLog();
        $lastEntry = ConsumptionLog::latest()->first();

        $log->amount = $newAmount;
        $diffByAmount = abs($lastEntry->amount - $newAmount);
        $log->diff_by_amount = $diffByAmount;

        $date = Carbon::parse($lastEntry->created_at);
        $now = Carbon::parse($params['date']) ?? Carbon::now();
        $log->created_at = $now->toDateString();
        $log->updated_at = $now->toDateString();
        $diffInDays = ceil($date->diffInDays($now));
        $log->diff_by_date = $diffInDays;

        $log->average_consumption = $diffInDays > 0 ? $diffByAmount / $diffInDays : 0;
        $log->reported = (int) $params['reported'];
        
        $log->save();
    }

    public function allRecords()
    {
        $records = ConsumptionLog::orderBy('created_at', 'desc')->get();
        return response()->json($records);
    }
}