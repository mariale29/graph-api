<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use NumberFormatter;
use Carbon\Carbon;

class NodeResource extends JsonResource
{
    
    public function toArray(Request $request): array
    {
        
        $lang = $request->header('Accept-Language', 'en');    
        
        $timezone = $request->header('X-Timezone', 'UTC');

        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'title' => $this->translateIdToText($this->id, $lang),
            'created_at' => Carbon::parse($this->created_at)
                ->timezone($timezone)
                ->toDateTimeString()
        ];
    }

    private function translateIdToText($id, $lang)
    {        
        $formatter = new NumberFormatter($lang, NumberFormatter::SPELLOUT);    
        return $formatter->format($id) ?: $id;
    }
}