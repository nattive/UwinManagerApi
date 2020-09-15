<?php

namespace App\Http\Controllers;

use App\Checklist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChecklistController extends Controller
{
    /**check if posted checklist is > 2hrs
     * Check if checklist exist in table
     *
     * @return Boolean
     */
    private function checkIfChecklistExist()
    {
        $checklist = Checklist::where('id', auth()->user()->id)->orderBy('created_at', 'desc')->first();
        if (!$checklist) {
            return false;
        }
        return true;
    }

    public function latest()
    {
        $checklist = Checklist::where('id', auth()->user()->id)->orderBy('created_at', 'desc')->first();
        return response($checklist);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $user = auth()->user();
        $checklist = $user->Checklists()->create([
            'user_id' => $user->id,
            'isLate' => false,
            'isOkay' => 'true',
            'nextChecklist' => $this->nextChecklistTime(),
            'lastChecked' => Carbon::now('WAT'), // Added 5:30mins
            'timeOfTheDay' => $this->getTimeOfTheDay(Carbon::now('WAT')),
        ]);
        return $this->shouldOpenDialog();
    }

    public function getTimeOfTheDay()
    {

        $time = Carbon::now('WAT');

        $morningStart = Carbon::createFromTimeString('00:00:00');
        $morningEnd = Carbon::createFromTimeString('08:30:00');

        $AfternoonStart = Carbon::createFromTimeString('08:31:00');
        $AfternoonEnd = Carbon::createFromTimeString('14:30:00');

        $EveningStart = Carbon::createFromTimeString('14:30:00');
        $EveningEnd = Carbon::createFromTimeString('20:00:00');

        $now = Carbon::createFromTimeString($time);
        $time = $now->format('H:i:s');

        if (Carbon::parse($time)->greaterThanOrEqualTo($morningStart) && Carbon::parse($time)->lessThanOrEqualTo($morningEnd)) {
            return 'morning';
        } elseif (Carbon::parse($time)->greaterThanOrEqualTo($AfternoonStart) && Carbon::parse($time)->lessThanOrEqualTo($AfternoonEnd)) {
            return 'afternoon';
        } elseif (Carbon::parse($time)->greaterThanOrEqualTo($EveningStart) && Carbon::parse($time)->lessThanOrEqualTo($EveningEnd)) {
            return 'night';
        } else {
            return 'midnight';
        }
    }

    public function test()
    {
        // $AfternoonStart = Carbon::create('08:31:00'); new Carbon('tomorrow');
        // $AfternoonEnd = Carbon::create('10:30:00');

        $A = Carbon::createFromTimeString('2020-07-01 01:36:02')->format('h:i:s A');
        return $A;
    }

    public function shouldOpenDialog()
    {
        $id = auth()->user()->id;
        $LastChecklist = Checklist::where('user_id', $id)->orderBy('created_at', 'desc')->first();
        if ($LastChecklist) {
            // $diff = thi;
            $diff = Carbon::createFromTimeString($LastChecklist->nextChecklist)->subMinutes(60)->isPast();
            // return   $LastChecklist->nextChecklist;
            return [
                'open' => false,
                'type' => $this->getTimeOfTheDay(),
                'next' => $this->nextChecklistTime(),
            ];
        }
        return [
            'open' => false,
            'type' => $this->getTimeOfTheDay(),
            'next' => $this->nextChecklistTime(),
        ];
    }
    /**
     * Returns the 12hour format tine of next checklist
     * @return Carbon
     */
    public function nextChecklistTime()
    {
        $midnight = Carbon::create('00:00:00')->format('Y-m-d H:i:s.u');
        switch ($this->getTimeOfTheDay()) {
            case 'morning':
                return Carbon::create($midnight)->addMinutes(510)->toDateTimeLocalString();
                break;
            case 'afternoon':
                return Carbon::create($midnight)->addMinutes(870)->toDateTimeLocalString();
                break;
            case 'night':
                return Carbon::create($midnight)->addHours(20)->addMinutes(30)->toDateTimeLocalString();
                break;
            case 'midnight':
                return Carbon::now('WAT')->tomorrow()->addHours(8)->addMinutes(30)->toDateTimeLocalString();
                break;

            default:
                # code...
                break;
        }
    }
}
