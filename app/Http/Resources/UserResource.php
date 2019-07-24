<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
  function toArray($request)
  {
    return
    [
      'id'                => $this->id,
      'email'             => $this->email,
      'name'              => $this->name,
      'created_at'        => date('d/m/Y H:i', strtotime($this->created_at)),
      'updated_at'        => date('d/m/Y H:i', strtotime($this->updated_at)),
    ];
  }
}