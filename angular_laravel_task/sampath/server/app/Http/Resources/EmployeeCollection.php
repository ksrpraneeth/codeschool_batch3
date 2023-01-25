<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "dob" => $this->dob,
            "email" => $this->email,
            "phone" => $this->phone,
            "position" => $this->position,
            "salary" => $this->salary,
            "gender" => $this->gender,
        ];
    }
}
