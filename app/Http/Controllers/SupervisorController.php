<?php

namespace App\Http\Controllers;

use App\AccountReport;
use App\FuelConsumptionReport;
use App\WSKPA;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    public function wskpa()
    {
        $wskpa = WSKPA::with('user')->get();
        return response()->json($wskpa, 200);
    }
    public function sfcr()
    {
        $wskpa = FuelConsumptionReport::with('user')->get();
        return response()->json($wskpa, 200);
    }
    public function sales()
    {
        $wskpa = AccountReport::with('user')->get();
        return response()->json($wskpa, 200);
    }

    /**
     * Get report by user 
     */

    public function wskpaByUser($id)
    {
        $wskpa = WSKPA::where('user_id', $id)->with('user')->get();
        return response()->json($wskpa, 200);
    }
    public function sfcrByUser($id)
    {
        $wskpa = FuelConsumptionReport::where('user_id', $id)->with('user')->get();
        return response()->json($wskpa, 200);
    }
    public function salesByUser($id)
    {
        $wskpa = AccountReport::where('user_id', $id)->with('user')->get();
        return response()->json($wskpa, 200);
    }

    public function approveReport(Request $request)
    {
        $data = $request->validate([
            'report' => 'required|string',
            'report_id' => 'required|int'
        ]);
        switch ($request->report) {
            case 'wskpa':
                $report = WSKPA::where('id', $request->report_id)->first();
                $manager = auth()->user();
                $report->isApprovedBy = $manager->name;
                $report->save();
                break;
            case 'sales':
                $report = AccountReport::where('id', $request->report_id)->first();
                $manager = auth()->user();
                $report->isApprovedBy = $manager->name;
                $report->save();
                break;
            case 'sfcr':
                $report = FuelConsumptionReport::where('id', $request->report_id)->first();
                $manager = auth()->user();
                $report->isApprovedBy = $manager->name;
                $report->save();
                break;

            default:
                return response()->json('return a valid report', 422);
                break;
        }
        return response()->json('report has been approved', 200);
    }
}
