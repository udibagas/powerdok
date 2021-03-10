<?php

namespace App\Http\Resources;

use App\Models\Department;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DocumentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($item) {
                if ($item->departments !== null) {
                    $item->departments = Department::whereIn('id', $item->departments)->pluck('name', 'id');
                } else {
                    $item->departments = [];
                }

                return $item;
            })
        ];
    }
}
