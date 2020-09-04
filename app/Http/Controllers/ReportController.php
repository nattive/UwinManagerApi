<?php

namespace App\Http\Controllers;

use App\AccountReport;
use App\FuelConsumptionReport;
use App\Report;
use App\WSKPA;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     $user = auth()->user();
        $Checklists = $user -> Checklists;
        $WSKPAs = $user -> WSKPAs;
        $FuelConsumptionReports = $user -> FuelConsumptionReports;
        $AccountReports = $user -> AccountReports;
        return response()->json(compact('Checklists','WSKPAs','FuelConsumptionReports', 'AccountReports'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
