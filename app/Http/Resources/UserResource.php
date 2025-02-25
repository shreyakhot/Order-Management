<?php

namespace App\Http\Resources;

use App\Traits\ImageHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    use ImageHelper;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username ' => $this->username ,
            'email' => $this->email,
            'phone' => $this->phone,
            'image' => $this->image ? $this->getFileFullUrl($this->image): null,
            'emailVerifiedAt' => $this->email_verified_at,
        ];
    }
}
