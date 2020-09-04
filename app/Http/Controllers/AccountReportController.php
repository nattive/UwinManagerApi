<?php

namespace App\Http\Controllers;

use App\AccountReport;
use Illuminate\Http\Request;

class AccountReportController extends Controller
{
    /**: 0
    cashFunded: "200"
    eCreditFunded: "250"
    expectedCashAtHand: -1106
    expenseTotal: 312553
    fuel: "333"
    misc: "310000"
    onlineBalance: 0
    pos: 0
    totalPayout: "2220"
    totalRunCred: 1450
    unsettledWinnings: "1000"
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        // return $user;
        if ($user) {
            return response()->json($user->AccountReports, 200);
        }
        return response()->json('Please sign in', 401);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validate = $request->validate([
            'cashFunded' => 'required|integer',
            'eCreditFunded' => 'required|integer',
            'expectedCashAtHand' => 'required|integer',
            'expenseTotal' => 'required|integer',
            'fuel' => 'required|integer',
            'misc' => 'required|integer',
            'onlineBalance' => 'required|integer',
            'pos' => 'required|integer',
            'totalPayout' => 'required|integer',
            'totalRunCred' => 'required|integer',
            'unsettledWinnings' => 'required|integer',
        ]);
        // return $validate;
        auth()->user()->accountReports()->create($validate);
        return response()->json('Account Created', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AccountReport  $accountReport
     * @return \Illuminate\Http\Response
     */
    public function show(AccountReport $accountReport)
    {
        $accountReport = AccountReport::where('id', $accountReport->id)->first();
        return response()->json($accountReport, 200);
    }

    public function Latest()
    {
        $user = auth()->user();
        $report = $user->AccountReports->first();
        // $report = WSKPA::orderBy('created_at', 'desc')->first();
        return response($report);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AccountReport  $accountReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccountReport $accountReport)
    {
        $accountReport = AccountReport::where('id', $accountReport->id)->first();
        $accountReport->update($request->only([
            'unsettledWinnings',
            'totalPayout',
            'expenseTotal',
            'totalPayout',
            'actualCashAtHand',
            'sub_total1',
            'totalRunCred',
            'eCreditFunded',
            'cashFunded',
            'creditUnpaidTotal',
            'expenseTotal',
            'onlineBalance',
            'expectedCashAtHand',
            'sub_total2',
            'fuel',
            'misc',
        ]));
        return response()->json('Account Updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AccountReport  $accountReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountReport $accountReport)
    {
        $accountReport = AccountReport::where('id', $accountReport->id)->first();
        $accountReport->delete();
        return response()->json('Account Deleted', 200);
    }
}
