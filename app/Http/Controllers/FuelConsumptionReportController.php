<?php

namespace App\Http\Controllers;

use App\FuelConsumptionReport;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FuelConsumptionReportController extends Controller
{
    public $orderInterval;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id =  auth()->user()->id;
        $reports = FuelConsumptionReport::where('id', $id)->orderBy('created_at', 'desc')->get();
        return response($reports);
    }

    /**
     * Fetch report from same week
     */
    public function getThisWeekReport()
    {
        $start = new Carbon('first day of this month');
        $start = $start->startOfMonth()->format('Y-m-d H:i:s');
        $reports = FuelConsumptionReport::where('created_at', '>', $start)->get();
        return response($reports);
        // $report = FuelConsumptionReport::whereDate('date', '=', Carbon::today())->get();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $data = $request->validate([
            'date_finished' => '',
            'date_supplied' => '',
            'usage_duration' => '',
            'volume' => '',
            'petrol_station' => '',
            'hasReceive' => '',
            'pricePerLitre' => '',
        ]);
        $prevReport = FuelConsumptionReport::orderBy('created_at', 'desc')->first();
        if ($prevReport) {
            $date = Carbon::parse($prevReport->created_at);
            $orderInterval = $date->diffForHumans();
            FuelConsumptionReport::create([
                'date_finished' => $request->date_finished,
                'date_supplied' => $request->date_supplied,
                'usage_duration' => $request->usage_duration,
                'volume' => $request->volume,
                'petrol_station' => $request->petrol_station,
                'hasReceived' => $request->hasReceive,
                'pricePerLitre' => $request->pricePerLitre,
                'orderInterval' => $date->diffForHumans(),
                'user_id' =>  auth()->user()->id,
            ]);
        } else {
            FuelConsumptionReport::create([
                'date_finished' => $request->date_finished,
                'date_supplied' => $request->date_supplied,
                'usage_duration' => $request->usage_duration,
                'volume' => $request->volume,
                'petrol_station' => $request->petrol_station,
                'hasReceived' => $request->hasReceive,
                'pricePerLitre' => $request->pricePerLitre,
                'orderInterval' => null,
                'user_id' =>  auth()->user()->id,
            ]);
        }
        return response('Fuel Report Updated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FuelConsumptionReport  $fuelConsumptionReport
     * @return \Illuminate\Http\Response
     */
    public function show(FuelConsumptionReport $fuelConsumptionReport)
    {
        $report = FuelConsumptionReport::find($fuelConsumptionReport);
        return response($report);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FuelConsumptionReport  $fuelConsumptionReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FuelConsumptionReport $fuelConsumptionReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FuelConsumptionReport  $fuelConsumptionReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(FuelConsumptionReport $fuelConsumptionReport)
    {
        $report = FuelConsumptionReport::find($fuelConsumptionReport);
        $report->delete();
        return response('Fuel Report Deleted successfully');
    }
}
