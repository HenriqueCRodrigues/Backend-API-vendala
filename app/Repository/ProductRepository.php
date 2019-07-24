<?php

namespace App\Repository;

use App\Models\Marketplace;
use App\Models\Product;
use App\Models\ProductUpdate;
use App\Models\SellerData;
use App\Models\SystemAttribute;
use App\Models\Brand;
use App\Models\SystemCategory;
use App\Models\SystemDepartment;
use App\Models\SystemSubcategory;
use App\Models\SystemSubSubcategory;

use App\Services\ConnectionService;
use Carbon\Carbon;

use GuzzleHttp\Client;

use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Webpatser\Uuid\Uuid;
use Illuminate\Support\Collection;
use App\Models\Order;
use App\Models\OrderInvoice;
use Illuminate\Support\Facades\Cache;
use Storage;

class ProductRepository
{

  public function create($input)
  {
    $images = $input['images'];
    unset($input['images']);    
    $input['user_id'] = \Auth::id();
    $kits = explode(',', $input['kit']);
    if (count($kits)) {
      $name = '';
      foreach($kits as $kit)
      {
        $name .= ' + '.Product::where('user_id', \Auth::id())->where('id', $kit)->first()->name;
      }
      $input['name'] = substr($name, 3);
      $input['kit'] = json_encode($kits);
    } else {
      unset($input['kit']);
    }
    $product = Product::create($input);
    $file[$product->id] = [];
    $links = [];
    foreach($images as $img)
    {
      $file[$product->id] = str_random(32).'.'.$img->extension();
      $img->storeAs('products/'.$product->id, $file[$product->id]);
      $links[] = 'products/'.$product->id.'/'.$file[$product->id];
    } 
    $product->images = json_encode($links);
    $product->save();
    return $product;
  }


  public function getAll($request)
  {
    $columns = [
      'name',
      'price',
      'category',
      'description',
      'created_at',
      'action'
    ];

    $totalProducts = Product::count();
    $limit = $request['length'];
    $start = $request['start'];
    $order = $columns[$request['order'][0]['column']];
    $dir   = $request['order'][0]['dir'];

    if (empty($request['search']['value'])) 
    {
      $products = Product::offset($start)
      ->limit($limit)
      ->orderBy($order)
      ->where('user_id', \Auth::id())
      ->get();
      $totalFiltered = $totalProducts;
    } else {
      $search = $request['search']['value'];
      $products = Product::where('name', 'like', '%'.$search.'%')
                ->orWhere('price', 'like', '%'.$search.'%')
                ->orWhere('category', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%')
                ->orWhere('created_at', 'like', '%'.$search.'%')
                ->where('user_id', \Auth::id())
                ->offset($start)
                ->limit($limit)
                ->orderBy($order)
                ->get();
        
      $totalFiltered = $products->count();
      
    }
    
    $data = [];
    if ($products) 
    {
      foreach($products as $product)
      {
        $auxData['id'] = $product->id;
        $auxData['images'] = $product->images;
        $auxData['name'] = $product->name;
        $auxData['price'] = $product->price;
        $auxData['category'] = $product->category;
        $auxData['description'] = $product->description;
        $auxData['created_at'] = date('d/m/Y H:i:s', strtotime($product->created_at));
        $auxData['action'] = '
          <a onclick="editProduct('.$product->id.')" class="btn btn-warning btn-xs">Editar</a>
          <a onclick="deleteProduct('.$product->id.')" class="btn btn-danger btn-xs">Excluir</a>
        '; 
        $data[] = $auxData;
      }

    }

    $json = [
      'draw' => intval($request['draw']),
      'recordsFiltered' => intval($totalFiltered),
      'recordsTotal' => intval($totalProducts),
      'data' => $data
    ];

    return json_encode($json);
  }

  public function destroy($id)
  {
    return Product::where('id', $id)->where('user_id', \Auth::id())->delete();
  }

  public function getById($id)
  {
    return Product::where('user_id', \Auth::id())->find($id);
  }

  public function update($id, $input)
  {
    $product = Product::where('user_id', \Auth::id())->find($id);
    Storage::delete(json_decode($product->images, TRUE));
    $images = $input['images'];
    unset($input['images']);    
    $file[$product->id] = [];
    $links = [];
    foreach($images as $img)
    {
      $file[$product->id] = str_random(32).'.'.$img->extension();
      $img->storeAs('products/'.$product->id, $file[$product->id]);
      $links[] = 'products/'.$product->id.'/'.$file[$product->id];
    } 
    $input['images'] = json_encode($links);
    $product->update($input);
    return $product;
  }

}