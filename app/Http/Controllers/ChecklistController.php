<?php

namespace App\Http\Controllers;

use App\Checklist;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ChecklistController extends Controller
{

    public function shouldOpenDialog()
    {
        $lastPostToday = auth()->user()->Checklists()->whereDate('created_at', Carbon::today())->latest()->first();
        $now = Carbon::now()->setTimezone('Africa/Lagos');
        if ($lastPostToday) {
            if ($lastPostToday->timeOfTheDay == $this->getTimeOfTheDay()) {
                return [
                    'open' => false,
                    'type' => $this->getTimeOfTheDay(),
                    'next' => $this->nextChecklistTime(),
                    'lastChecklist' => $lastPostToday->timeOfTheDay,
                    'diffentInTime' => Carbon::now()->diffInMinutes($this->nextChecklistTime()),
                ];
            } else {
                switch ($this->getTimeOfTheDay()) {
                    case 'morning':
                        $min = Carbon::create('08:00:00')->format('Y-m-d H:i:s.u');
                        $max = Carbon::create('08:30:00')->format('Y-m-d H:i:s.u');
                        return [
                            'open' => $now->isBetween($min, $max),
                            'type' => $max->isPast() ? 'afternoon' : 'morning',
                            'next' => $this->nextChecklistTime(),
                            'diffentInTime' => Carbon::now()->diffInMinutes($this->nextChecklistTime()),
                        ];
                        break;
                    case 'afternoon':
                        $min = Carbon::create('14:00:00')->format('Y-m-d H:i:s.u');
                        $max = Carbon::create('14:30:00')->format('Y-m-d H:i:s.u');
                        return [
                            'open' => $now->isBetween($min, $max),
                            'type' => 'afternoon',
                            'next' => $this->nextChecklistTime(),
                            'diffentInTime' => Carbon::now()->diffInMinutes($this->nextChecklistTime()),
                        ];
                        break;
                    case 'night':
                        $min = Carbon::create('08:00:00')->format('Y-m-d H:i:s.u');
                        $max = Carbon::create('08:30:00')->format('Y-m-d H:i:s.u');
                        return [
                            'open' => $now->isBetween($min, $max),
                            'type' => 'night',
                            'next' => $this->nextChecklistTime(),
                            'diffentInTime' => Carbon::now()->diffInMinutes($this->nextChecklistTime()),
                        ];
                        break;
                    default:
                        return [
                            'open' => false,
                            'type' => $this->getTimeOfTheDay,
                            'next' => $this->nextChecklistTime(),
                            'diffentInTime' => Carbon::now()->diffInMinutes($this->nextChecklistTime()),
                        ];

                        break;
                }
            }
        } else {
            switch ($this->getTimeOfTheDay()) {
                case 'morning':
                    $min = Carbon::create('08:00:00')->format('Y-m-d H:i:s.u');
                    $max = Carbon::create('08:30:00')->format('Y-m-d H:i:s.u');

                    return [
                        'open' => $now->isBetween($min, $max),
                        'type' => 'morning',
                        'next' => $this->nextChecklistTime(),
                        'diffentInTime' => Carbon::now()->diffInMinutes($this->nextChecklistTime()),
                    ];
                    break;
                case 'afternoon':
                    $min = Carbon::create('14:00:00')->format('Y-m-d H:i:s.u');
                    $max = Carbon::create('14:30:00')->format('Y-m-d H:i:s.u');

                    return [
                        'open' => $now->isBetween($min, $max),
                        'type' => 'afternoon',
                        'next' => $this->nextChecklistTime(),
                        'diffentInTime' => Carbon::now()->diffInMinutes($this->nextChecklistTime()),
                    ];
                    break;
                case 'night':
                    $min = Carbon::create('20:00:00')->format('Y-m-d H:i:s.u');
                    $max = Carbon::create('20:30:00')->format('Y-m-d H:i:s.u');

                    return [
                        'open' => $now->isBetween($min, $max),
                        'type' => 'night',
                        'next' => $this->nextChecklistTime(),
                        'diffentInTime' => Carbon::now()->diffInMinutes($this->nextChecklistTime()),
                    ];
                    break;
                default:
                    return [
                        'open' => false,
                        'type' => $this->getTimeOfTheDay,
                        'next' => $this->nextChecklistTime(),
                        'diffentInTime' => Carbon::now()->diffInMinutes($this->nextChecklistTime()),
                    ];
// date.timezone = "Africa/Lagos"
                    break;
            }

        }

    }
    public function getTimeOfTheDay()
    {

        $time = Carbon::now();

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

    /**
     *
     * Returns the latest checklist
     * @return Response
     */
    public function latest()
    {
        $checklist = Checklist::where('id', auth()->user()->id)->orderBy('created_at', 'desc')->first();
        return response($checklist);
    }

    /**
     *
     * Returns the next checklist time. If the use has store a checklist today, Returned base on the last sent
     * else, It return base on the time checked.
     * @return Carbon $time
     */
    public function nextChecklistTime()
    {
        $midnight = Carbon::create('00:00:00')->format('Y-m-d H:i:s.u');
        $lastPostToday = auth()->user()->Checklists()->whereDate('created_at', Carbon::today())->latest()->first();
        if ($lastPostToday) {
            switch ($lastPostToday->timeOfTheDay) {
                case $this->getTimeOfTheDay():
                    switch ($this->getTimeOfTheDay()) {
                        case 'morning':
                            return Carbon::create($midnight)->addHours(14)->addMinutes(30)->toDateTimeLocalString();
                            break;
                        case 'afternoon':
                            return Carbon::create($midnight)->addHours(20)->addMinutes(30)->toDateTimeLocalString();
                            break;
                        case 'night':
                            return Carbon::now()->tomorrow()->addHours(8)->addMinutes(30)->toDateTimeLocalString();

                            break;
                        case 'midnight':
                            return Carbon::now()->tomorrow()->addHours(8)->addMinutes(30)->toDateTimeLocalString();
                            break;

                        default:
                            # code...
                            break;
                    }
                    break;
                case 'morning':
                    return Carbon::create($midnight)->addHours(14)->addMinutes(30)->toDateTimeLocalString(); // to Afternoon
                    break;
                case 'afternoon':
                    return Carbon::create($midnight)->addHours(20)->addMinutes(30)->toDateTimeLocalString(); // To evening
                    break;
                case 'night':
                    return Carbon::create($midnight)->addDay()->addHours(8)->addMinutes(30)->toDateTimeLocalString(); // tomorrow
                default:
                    # code...
                    break;
            }
        } else {
            switch ($this->getTimeOfTheDay()) {
                case 'morning':
                    return Carbon::create($midnight)->addHours(8)->addMinutes(30)->toDateTimeLocalString();
                    break;
                case 'afternoon':
                    return Carbon::create($midnight)->addHours(14)->addMinutes(30)->toDateTimeLocalString();
                    break;
                case 'night':
                    return Carbon::create($midnight)->addHours(20)->addMinutes(30)->toDateTimeLocalString();
                    break;
                case 'midnight':
                    return Carbon::now()->tomorrow()->addHours(8)->addMinutes(30)->toDateTimeLocalString();
                    break;

                default:
                    # code...
                    break;
            }
        }
    }

    /**
     *
     * Check if the present checklist is okay
     * @return Boolean
     **/
    public function checkIfOkay($now, $previous = null)
    {
        if ($previous == null) {
            return true;
        }
        switch ($now) {
            case 'morning':
                return $previous == 'night' ? true : false;
                break;
            case 'afternoon':
                return $previous == 'morning' ? true : false;
                break;
            case 'night':
                return $previous == 'afternoon' ? true : false;
                break;
            default:
                return false;
                break;
        }
    }

    public function store()
    {
        $now = Carbon::now()->setTimezone('Africa/Lagos');
        // return $now;

        $user = auth()->user();
        $last = Checklist::where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
        if ($last) {
            $isOkay = $this->checkIfOkay($this->getTimeOfTheDay(Carbon::now()), $last->timeOfTheDay);
        } else {
            $isOkay = true;
        }
        $user->Checklists()->create([
            'isLate' => false,
            'isOkay' => $isOkay,
            'nextChecklist' => $this->nextChecklistTime(),
            'lastChecked' => Carbon::now(), // Added 5:30mins
            'timeOfTheDay' => $this->getTimeOfTheDay(),
        ]);
        return $this->shouldOpenDialog();

    }
}

//  /**check if posted checklist is > 2hrs
//      * Check if checklist exist in table
//      *
//      * @return Boolean
//      */
//     private function checkIfChecklistExist()
//     {
//         $checklist = Checklist::where('id', auth()->user()->id)->orderBy('created_at', 'desc')->first();
//         if (!$checklist) {
//             return false;
//         }
//         return true;
//     }

//     public function latest()
//     {
//         $checklist = Checklist::where('id', auth()->user()->id)->orderBy('created_at', 'desc')->first();
//         return response($checklist);
//     }

//     /**
//      * Store a newly created resource in storage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @return \Illuminate\Http\Response
//      */

//     public function store(Request $request)
//     {
//         $user = auth()->user();
//         $last = Checklist::where('user_id', $user->id)->orderBy('created_at', 'desc')->first();

//         if ($last) {
//             $isOkay = $this->checkIfOkay($this->getTimeOfTheDay(Carbon::now()), $last->timeOfTheDay);
//         } else {
//             $isOkay = true;
//         }
//         $checklist = $user->Checklists()->create([
//             'isLate' => false,
//             'isOkay' => $isOkay,
//             'nextChecklist' => $this->nextChecklistTime(),
//             'lastChecked' => Carbon::now(), // Added 5:30mins
//             'timeOfTheDay' => $this->getTimeOfTheDay(Carbon::now()),
//         ]);
//         return $this->shouldOpenDialog();
//     }

//
//

//     public function test()
//     {
//         // $AfternoonStart = Carbon::create('08:31:00'); new Carbon('tomorrow');
//         // $AfternoonEnd = Carbon::create('10:30:00');

//         $A = Carbon::createFromTimeString('2020-07-01 01:36:02')->format('h:i:s A');
//         return $A;
//     }

//     public function shouldOpenDialog()
//     {
//         $id = auth()->user()->id;
//         $LastChecklist = Checklist::where('user_id', $id)->orderBy('created_at', 'desc')->first();
//         if ($LastChecklist) {
//             // $diff = thi;
//             $diff = Carbon::createFromTimeString($LastChecklist->nextChecklist)->subMinutes(60)->isPast();
//             // return   $LastChecklist->nextChecklist;
//             return [
//                 'open' => false,
//                 'type' => $this->getTimeOfTheDay(),
//                 'next' => $this->nextChecklistTime(),
//                 'diffentInTime' => Carbon::now()->diffInMinutes($this->nextChecklistTime()),
//             ];
//         }
//         return [
//             'open' => false,
//             'type' => $this->getTimeOfTheDay(),
//             'next' => $this->nextChecklistTime(),
//             'diffentInTime' => Carbon::now()->diffInMinutes($this->nextChecklistTime()),
//         ];
//     }
//     /**
//      * Returns the 12hour format tine of next checklist
//      * @return Carbon
//      */
//
