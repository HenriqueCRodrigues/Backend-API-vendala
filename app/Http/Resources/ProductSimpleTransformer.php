<?php

namespace App\Transformer;

use function GuzzleHttp\json_decode;
use League\Fractal\TransformerAbstract;
use App\Models\Product;

class ProductSimpleTransformer extends TransformerAbstract
{
  function transform(Product $product)
  {
    $product->load(['seller','user','brand']);

    return
    [
      'id'              => $product->id,
      'ean'             => $product->ean,
      'group_id'        => $product->group_id,
      'code'            => isset($product->code) ? $product->code : null,
      'brand'           => $product->brand != null ? strtoupper($product->brand->name) : null,
      'title'           => $product->title,
      'status'          => $product->status,
      'price'           => $product->price,
      'price_discount'  => $product->price_discount,
      'quantity'        => $product->quantity,
      'images'          => isset($product->images) ? json_decode($product->images,TRUE) : null,
      'marketplaces'    => isset($product->marketplaces) ? json_decode($product->marketplaces,TRUE) : null,
      'created_at'      => date('d/m/Y', strtotime($product->created_at)),
      'updated_at'      => date('d/m/Y', strtotime($product->updated_at)),
    ];
  }
}
