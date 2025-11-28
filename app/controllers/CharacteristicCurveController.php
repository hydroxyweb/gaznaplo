<?php
namespace App\Controllers;

use App\Models\CharacteristicCurve;
use Carbon\Carbon;

class CharacteristicCurveController extends Controller
{
    public function index() 
    {
       $values = CharacteristicCurve::get();
       foreach($values as $index => $value) {
            $values[$index]['month_name'] = __('months')[$value['month']-1];
            $currentMonth = new Carbon(date('Y').'-'.$value['month']);
            $currentMonth = $currentMonth->locale($_SERVER['HTTP_ACCEPT_LANGUAGE'] === 'hu' ? 'hu_HU': 'en_BG');
            $daysInMonth = $currentMonth->daysInMonth;
            $values[$index]['clock'] = floor($value['max_limit'] / $daysInMonth / 2 * 4);
       }
       return response()->json([
        'data' => $values
       ]);
    }
}