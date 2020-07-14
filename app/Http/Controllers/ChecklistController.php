<?php

namespace App\Http\Controllers;

use App\Checklist;
use Illuminate\Http\Request;
use Carbon\Carbon;
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
        $id =  auth()->user()->id;
        $now = Carbon::now('WAT');
        $LastChecklist = Checklist::where('user_id', $id)->orderBy('created_at', 'desc')->first();
        // return  $now;

        /**
         * If there are no entries in the checklist table
         */
        if (!$LastChecklist) {
            $checklist = Checklist::create([
                'user_id' => $id,
                'isLate' =>  false,
                'isOkay' => 'true',
                'nextChecklist' => $this->nextChecklistTime(),
                'lastChecked' => Carbon::now('WAT'), // Added 5:30mins
                'timeOfTheDay' =>  $this->getTimeOfTheDay(Carbon::now('WAT'))
            ]);
        } else {
            /**
             * Check if previous entry is the same day with now 
             **/
            $lastCreatedAt = Carbon::createFromTimeString($LastChecklist->created_at);
            if ($now->isSameDay(Carbon::createFromTimeString($LastChecklist->created_at))) {
                // ($first->lessThan($second)
                if ($lastCreatedAt->diffInHours() < 5) {
                    return response('too soon to create checklist', 403);
                } else {
                    $nextChecklist = Carbon::create($LastChecklist->nextChecklist);
                    $HourNow = Carbon::parse($now->format('Y-m-d H:i:s.u'));
                    $checklist = Checklist::create([
                        'user_id' => $id,
                        'isLate' =>  $HourNow->greaterThan($nextChecklist),
                        'isOkay' => 'true', //Used to send feedback
                        'nextChecklist' => $this->nextChecklistTime(),
                        'timeOfTheDay' =>  $this->getTimeOfTheDay(Carbon::now('WAT'))
                    ]);
                }
            } else {
                /**
                 * The last entry is not the same day with now
                 */
                $LastChecklist =  Carbon::createFromTimeString(Carbon::parse($LastChecklist->created_at));
                $LastChecklist = $LastChecklist->addDay();
                $LastChecklist = Carbon::createMidnightDate((Carbon::parse($LastChecklist)));
                $nextHour =   $LastChecklist->addMinutes(510);
                $checklist = Checklist::create([
                    'user_id' => $id,
                    'isLate' =>  $now->lessThan($nextHour),
                    'isOkay' => 'true', //Used to send feedback
                    'nextChecklist' => $this->nextChecklistTime(),
                    'timeOfTheDay' =>  $this->getTimeOfTheDay(Carbon::now('WAT'))
                ]);
            }

            return response()->json([
                'checklist' => $checklist,
            ]);
        }
    }

    public function getTimeOfTheDay()
    {
        /**
         *  Check for morning 
         * Morning is between > 8 pm < 8:30am 
         * Afternoon > 8:30 < 2:30
         * Evening < 8:00pm
         */

        $time = Carbon::now('WAT');
        $morningStart = '20:00:00';
        $morningEnd = '08:30:00';

        $AfternoonStart = '08:31:00';
        $AfternoonEnd = '14:30:00';

        $EveningStart = '14:30:00';
        $EveningEnd = '20:00:00';

        $now = Carbon::createFromTimeString($time);
        $time = $now->format('H:i:s');

        if ($time >= $morningStart && $time <= $morningEnd) {
            return 'morning';
        } elseif ($time >= $AfternoonStart && $time <= $AfternoonEnd) {
            return 'afternoon';
        } else {
            return 'night';
        }
    }

    public function test()
    {
        // $AfternoonStart = Carbon::create('08:31:00');
        // $AfternoonEnd = Carbon::create('10:30:00');

        $A = Carbon::createFromTimeString('2020-07-01 01:36:02')->format('h:i:s A');
        return $A;
    }

    public function shouldOpenDialog()
    {
        $id =  auth()->user()->id;
        $LastChecklist = Checklist::where('user_id', $id)->orderBy('created_at', 'desc')->first();
        if ($LastChecklist) {
            $diff = Carbon::createFromTimeString($LastChecklist->nextChecklist)->subMinutes(60)->isPast();
            // return   $diff;
           return $diff === true ? true : 'false';
        }
        return true;
    }
    /**
     * Returns the 12hour format tine of next checklist
     * @return Carbon 
     */
    public function nextChecklistTime()
    {
        $now = Carbon::now('WAT');

        // return $time;
        // Reset time to midnight
        //$dt->format('l jS \\of F Y h:i:s A')
        $presentHour = Carbon::parse($now);
        $presentHour = $presentHour->format('Y-m-d H:i:s.u');
        /**
         * Set default time to calculate on
         */
        $midnight = Carbon::create('00:00:00')->format('Y-m-d H:i:s.u');
        // return $midnight;

        // return Carbon::create($presentHour)->addMinutes(510)->format('Y-m-d H:i:s.u');

        /**
         * Return hours and minute of next checklist
         */
        // return $this->getTimeOfTheDay();
        switch ($this->getTimeOfTheDay()) {
            case 'morning':
                return Carbon::create($midnight)->addMinutes(510)->format('Y-m-d H:i:s.u');
                break;
            case 'afternoon':
                return Carbon::create($midnight)->addMinutes(870)->format('Y-m-d H:i:s.u');
                break;
            case 'night':
                # code...->addDay()
                // $dt1 =   $midnight->addDay();
                return Carbon::create($midnight)->addDay()->addHours(8)->addMinutes(30)->format('Y-m-d H:i:s.u');

                break;

            default:
                # code...
                break;
        }
    }
}
