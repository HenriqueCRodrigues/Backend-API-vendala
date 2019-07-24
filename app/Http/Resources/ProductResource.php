<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
  function toArray($request)
  {
    return
    [
      'id'                => $this->id,
      'name'              => $this->name,
      'description'       => $this->description,
      'category'          => $this->category,
      'images'            => isset($this->images) ? json_decode($this->images, TRUE) : null,
      'price'             => $this->price,
      'isKit'             => isset($this->kit) ? true : false,
      'created_at'        => date('d/m/Y H:i', strtotime($this->created_at)),
      'updated_at'        => date('d/m/Y H:i', strtotime($this->updated_at)),
    ];
  }
}