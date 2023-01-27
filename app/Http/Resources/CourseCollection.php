<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CourseCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map->only(
            'id',
            'name',
            'description',
            'credit_hours',
            'url',
            'source',
            'due_date',
            'is_approved',
            'remarks',
            'courseAassignment',
            'users',
            'courseCategories',
        );
    }
}
