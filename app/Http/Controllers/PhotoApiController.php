<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhotoRequest;
use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return json(Photo::all(),'success',200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePhotoRequest $request)
    {
        foreach($request->file('photos') as $key=>$photo){
        $newName = $photo->store('public');
            Photo::create([
                'name' => $newName,
                'product_id' => $request->product_id
            ]);
        }
        return json('','success',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $photo = Photo::find($id);
        if(is_null($photo)){
            return json([],'photo not found',404);
        }
        return json($photo,'photo not found',200);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $photo = Photo::find($id);
        if(is_null($photo)){
            return json([],'photo not found',404);
        }
        $photo->delete();
        return json($photo,'success',200);
    }
}
