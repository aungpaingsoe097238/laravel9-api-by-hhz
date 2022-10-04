<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductApiController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return json(
            ProductResource::collection(Product::latest('id','desc')->paginate(10)),
            'success',
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'user_id' => Auth::id(),
        ]);

        $photos = [];
        foreach ($request->file('photos') as $key => $photo) {
            $newName = $photo->store('public');
            $photos[$key] = new Photo(['name' => $newName]);
        }

        $product->photos()->saveMany($photos);

        return json(
            new ProductResource($product),
            'success',
            200
        );
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

        if (is_null($product)) {
            return json([],'data not found',404);
        }

        return json(
            new ProductResource($product),
            'success',
            200
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {

        $product = Product::find($id);

        if (is_null($product)) {
            return json([],'data not found',404);
        }

        if ($request->has('name')) {
            $product->name = $request->name;
        }

        if ($request->has('price')) {
            $product->price = $request->price;
        }

        if ($request->has('stock')) {
            $product->stock = $request->stock;
        }

        $product->update();

        return json(
            new ProductResource($product),
            'success',
            200
        );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return json([],'data not found',404);
        }

        $product->delete();

        return json(
            new ProductResource($product),
            'success',
            200
        );
    }
}
