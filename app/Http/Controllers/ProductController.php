<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ProductRepository;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct()
    {
        $this->productRepository  = new ProductRepository();
    }

    public function insert(Request $request)
    {
        $data     = $request->all();
        $product  = $this->productRepository->create($data);
        $response = new ProductResource($product);
        
        return $response;
    }
    public function getAll(Request $request)
    {
        $data     = $request->all();
        $product  = $this->productRepository->getAll($data);
        return $product;
    }

    public function show($id)
    {
        $product = $this->productRepository->getById($id);
        if ($product) {
            $response = new ProductResource($product);
        } else {
            $response = response('Não autorizado', 401);
        }

        return $response;
    }

    public function update($id, Request $request)
    {
        $data    = $request->all();
        $product = $this->productRepository->update($id, $data);
        $response = new ProductResource($product);

        return $response;
    }

    public function destroy($id)
    {
        $product = $this->productRepository->destroy($id);
        return $product;
    }

}
