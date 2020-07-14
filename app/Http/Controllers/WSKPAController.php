<?php

namespace App\Http\Controllers;

use App\WSKPA;
use Illuminate\Http\Request;

class WSKPAController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = WSKPA::orderBy('created_at', 'desc')->get();
        return response($data);
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
            'accountability' => 'required',
            'appearance' => 'required',
            'cr_rs' => 'required',
            'full_name' => 'required',
            'punctuality' => 'required',
            'revenue_per_day' => 'required',
            'workPercentage' => 'required',
            'work_attendance' => 'required',
        ]);
        // return   auth()->user()->id;

        WSKPA::create([
            'user_id' => auth()->user()->id,
            'accountability' => $request->accountability,
            'appearance' => $request->appearance,
            'cr_rs' => $request->cr_rs,
            'full_name' => $request->full_name,
            'punctuality' => $request->punctuality,
            'revenue_per_day' => $request->revenue_per_day,
            'workPercentage' => $request->workPercentage,
            'work_attendance' => $request->work_attendance,
            'general_equipment_maintenance' => $request->general_equipment_maintenance,
        ]);
        return response('Appraisal Report Uploaded successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WSKPA  $wSKPA
     * @return \Illuminate\Http\Response
     */
    public function show(WSKPA $wSKPA)
    {
        $report = WSKPA::find($wSKPA);
        return response(['data' => $report], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WSKPA  $wSKPA
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WSKPA $wSKPA)
    {
        $report = WSKPA::find($wSKPA);
        $report->update([
            'user_id' => auth()->user()->id,
            'accountability' => $request->accountability ?? $report->accountability,
            'appearance' => $request->appearance ?? $report->appearance,
            'cr_rs' => $request->cr_rs ?? $report->cr_rs,
            'full_name' => $request->full_name ?? $report->full_name,
            'punctuality' => $request->punctuality ?? $report->punctuality,
            'revenue_per_day' => $request->revenue_per_day ?? $report->revenue_per_day,
            'workPercentage' => $request->workPercentage ?? $report->workPercentage,
            'work_attendance' => $request->work_attendance ?? $report->work_attendance,
            'general_equipment_maintenance' => $request->general_equipment_maintenance ?? $report->general_equipment_maintenance,
        ]);
        return response('Appraisal Report Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WSKPA  $wSKPA
     * @return \Illuminate\Http\Response
     */
    public function destroy(WSKPA $wSKPA)
    {
        $report = WSKPA::find($wSKPA);
        $report->delete();
        return response('Appraisal Report Deleted successfully');
    }

    /**
     * Returns last entry 
     * @return Response
     */
    public function Latest()
    {
        $report = WSKPA::orderBy('created_at', 'desc')->first();
        return response($report);
    }
}
