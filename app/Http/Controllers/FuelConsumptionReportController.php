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
        // $id = auth()->user()->id;
        $reports = \auth()->user()-> FuelConsumptionReports;
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
        $data = $request->validate([
            'date_finished' => '',
            'date_supplied' => '',
            'usage_duration' => 'required',
            'volume' => 'required',
            'petrol_station' => '',
            // 'hasReceive' => '',
            'pricePerLitre' => '',
            'report_date' => 'required',
        ]);
        // return $data;
        $prevReport = FuelConsumptionReport::orderBy('created_at', 'desc')->first();
        if ($prevReport) {
            $date = Carbon::parse($prevReport->created_at);
            $ExtraData = [
                'orderInterval' => $date->diffForHumans(),
            ];
        } else {
            $ExtraData = [
                'orderInterval' => null,
            ];
        }
        \auth()->user()->FuelConsumptionReports()->create(array_merge($data, $ExtraData));
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
