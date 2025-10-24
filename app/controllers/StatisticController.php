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
        $lastReportedRecord = $this->consumptionLog->lastReportedRecord();
        if (empty($lastReportedRecord)) {
            return;
        }

        $lastReportedAmount = $lastReportedRecord->amount;
        $lastReportedDate = new Carbon($lastReportedRecord->created_at);
        $lastReportedDate = $lastReportedDate->locale('hu_HU');

        $currentMaxLimit = CharacteristicCurve::where('month', $lastReportedDate->month)->value('max_limit');
        $lastReading = $this->consumptionLog->latest()->first();

        return response()->json([
            'year' => $lastReportedDate->year,
            'month' => $lastReportedDate->monthName,
            'lastReportedAmount' => $lastReportedAmount,
            'lastReading' => $lastReading->amount,
            'maxLimit' => $currentMaxLimit,
            'consumption' => $this->consumptionLog->consumptionSummary($lastReportedRecord->created_at),
        ]);
    }
}