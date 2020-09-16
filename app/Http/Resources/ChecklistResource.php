<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ChecklistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user' => $this->user,
            'isLate' => $this->isLate == true ? 'The checklist was checked a little bit late' : ' Checklist was checked in time ',
            'isOkay' => $this->isOkay == true || $this->isOkay == 1 ? 'Checklist is okay' : 'The manager missed the last checklist',
            'nextChecklist' => $this->nextChecklist,
            'lastChecked' => $this->lastChecked,
            'timeOfTheDay' => $this->timeOfTheDay,
            'created_at' => Carbon::parse($this->created_at)->diffForHumans([
                'parts' => 2,
            ]),
        ];
    }
}
