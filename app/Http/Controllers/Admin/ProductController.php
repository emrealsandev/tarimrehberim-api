<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Product;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::all();
        $response = [
            'success' => true,
            'data' => ProductResource::collection($data),
            'message' => 'Products Fetched'
        ];
        return response()->json($response,200);
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'description' => 'required',
            'inventory' => 'required',
            'image' => 'string',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $Products = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $request->image,
            'inventory' => $request->inventory,
        ]);

        return response()->json(['Ürün Başarıyla Eklendi', new ProductResource($Products)]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if(is_null($product)){
            return response()->json('Data not found',404);
        }
        return response()->json([new ProductResource($product)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $input = $request->all();


        $validator = Validator::make($input,[
            'name' => 'required|string|max:255',
            'description' => 'required',
            'inventory' => 'required',
            'image' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $product->name = $input['name'];
        $product->description = $input['description'];
        $product->inventory = $input['inventory'];
        $product->image = $input['image'];
        $product->save();
        return response()->json(['Ürün güncellendi', new ProductResource($product)]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json('Ürün Başarıyla Silindi.');
    }
}
