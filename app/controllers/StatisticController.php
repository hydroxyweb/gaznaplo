<?php
namespace App\Controllers;

use App\Models\CharacteristicCurve;
use App\Models\ConsumptionLog;
use Carbon\Carbon;

class StatisticController extends Controller
{

    private $consumptionLog;

    public function __construct()
    {
        $this->consumptionLog = new ConsumptionLog();
    }

    public function index() 
    {
        $now = Carbon::now();
        $currentDate = $now->year. '-'. $now->month;
        $lastReportedRecord = $this->consumptionLog->lastReportedRecord(request()->get('date') ?? $currentDate);
        if (empty($lastReportedRecord)) {
            return response()->json([
                'message' => 'Nem sikerült betölteni ehhez a hónaphoz tartozó statisztikákat'
            ], 404);
        }

        $lastReportedAmount = $lastReportedRecord->amount;
        $lastReportedDate = new Carbon($lastReportedRecord->created_at);
        $lastReportedDate = $lastReportedDate->locale('hu_HU');
        $daysInMonth = $lastReportedDate->daysInMonth;

        $currentMaxLimit = CharacteristicCurve::where('month', $lastReportedDate->month)->value('max_limit');
        $lastReading = $this->consumptionLog->latest()->first();
        $consumptionSummary = $this->consumptionLog->consumptionSummary($lastReportedRecord->created_at);
        $overConsumption = $consumptionSummary - $currentMaxLimit;
        $remainingAmount = $currentMaxLimit - $consumptionSummary;

        return response()->json([
            'year' => $lastReportedDate->year,
            'month' => $lastReportedDate->monthName,
            'lastReportedAmount' => $lastReportedAmount,
            'lastReading' => $lastReading->amount,
            'maxLimit' => $currentMaxLimit,
            'consumption' => $consumptionSummary,
            'overConsumption' => $overConsumption > 0 ? $overConsumption : 0,
            'remaining' => $remainingAmount > 0 ? $remainingAmount : 0,
            'clockSetting' => ceil($currentMaxLimit / $daysInMonth/1.89*4)
        ]);
    }
}