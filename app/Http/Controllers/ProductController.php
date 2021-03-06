<?php

namespace App\Http\Controllers;

use App\Exceptions\ProductNoteBelongsToUser;
use App\Http\Requests\PostRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index', 'show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     return ProductCollection::collection(Product::paginate(5));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest  $request)
    {
        $product =new Product();
        $product->name =$request->name;
        $product->stock =$request->stock;
        $product->price =$request->price;
        $product->discount =$request->discount;
        $product->detail =$request->description;
        $product->save();
        return response([
           " data" => new ProductResource($product)

            
        ],201); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
     return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
     
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->ProductUserCheck($product);
          $request['detail'] = $request->description ;

          unset($request->desbcription );
        $product->update($request->all());
        return response([
            " data" => new ProductResource($product)
             
         ],200); 
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    }
    public function destroy(Product $product)
    { 
        $this->ProductUserCheck($product);
        $product->delete();
        return response(null,200); 
    }

    public function ProductUserCheck($product){
        if(Auth::id()!==$product->user_id) {
            throw new ProductNoteBelongsToUser();
        }
    }
}
