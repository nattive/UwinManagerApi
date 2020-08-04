<?php

namespace App\Http\Controllers;

use App\AccountReport;
use Illuminate\Http\Request;

class AccountReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
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
            'unsettledWinnings' => 'required|int',
            'totalPayout' => 'required|int',
            'actualCashAtHand' => 'required|int',
            'sub_total1' => 'required|int',
            'totalRunCred' => 'required|int',
            'eCreditFunded' => 'required|int',
            'cashFunded' => 'required|int',
            'creditUnpaidTotal' => 'required|int',
            'expenseTotal' => 'required|int',
            'onlineBalance' => 'required|int',
            'expectedCashAtHand' => 'required|int',
            'sub_total2' => 'required|int',
            'fuel' => 'required|int',
            'misc' => 'required|int',
        ]);
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
