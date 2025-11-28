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
        $hasAnyReportedRecord = $this->consumptionLog->currentMonthHasReportedRecord();
        $now = $hasAnyReportedRecord ? Carbon::now() : Carbon::now()->copy()->subMonth();
        $currentDate = $now->year. '-'. $now->month;
        $lastReportedRecord = $this->consumptionLog->lastReportedRecord(request()->get('date') ?? $currentDate);
        if (empty($lastReportedRecord)) {
            return response()->json([
                'message' => __('cant-load-statistic')
            ], 404);
        }

        $lastReportedAmount = $lastReportedRecord->amount;
        $lastReportedDate = new Carbon($lastReportedRecord->created_at);
        $lastReportedDate = $lastReportedDate->locale($_SERVER['HTTP_ACCEPT_LANGUAGE'] === 'hu' ? 'hu_HU': 'en_BG');
        $daysInMonth = $lastReportedDate->daysInMonth;

        $currentMaxLimit = CharacteristicCurve::where('month', $lastReportedDate->month)->value('max_limit');
        $lastReading = $this->consumptionLog->latest()->first();
        $consumptionSummary = $this->consumptionLog->consumptionSummary($lastReportedRecord->created_at);
        $overConsumption = round($consumptionSummary - $currentMaxLimit, 2);
        $remainingAmount = round($currentMaxLimit - $consumptionSummary, 2);

        return response()->json([
            'year' => $lastReportedDate->year,
            'month' => $lastReportedDate->monthName,
            'lastReportedAmount' => $lastReportedAmount,
            'lastReading' => $lastReading->amount,
            'maxLimit' => $currentMaxLimit,
            'consumption' => $consumptionSummary,
            'overConsumption' => $overConsumption > 0 ? $overConsumption : 0,
            'remaining' => $remainingAmount > 0 ? $remainingAmount : 0,
            'clockSetting' => floor($currentMaxLimit / $daysInMonth / 2 * 4),
            'monthNumber' => $lastReportedDate->month,
        ]);
    }
    
    public function curentMonthHasReportedRecord()
    {
        return response()->json([
            'hasAny' => $this->consumptionLog->currentMonthHasReportedRecord()
        ]);
    }
}