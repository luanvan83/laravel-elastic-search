<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    protected $withoutFields = ['created_at', 'updated_at'];

    // Set the keys that are supposed to be filtered out
    public function hide(array $fields)
    {
        $this->withoutFields = $fields;
        return $this;
    }

    // Remove the filtered keys.
    protected function filterFields($array)
    {
        return collect($array)->forget($this->withoutFields)->toArray();
    }

    public function toArray($request)
    {
        $lData = $this->resource->toArray();
        $lData['authors'] = $this->authors->map(function($author) {
            return $author->only(['name']);
        });
        return $this->filterFields($lData);
    }
}
