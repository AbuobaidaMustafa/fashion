<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Store;
use App\Http\Resources\StoreResource;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Store::all();
        return response()->json([StoreResource::collection($data), 'Stores fetched.']);
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
            'name_local' => 'required',
            'phone' => 'required|max:6'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $store = Store::create([
            'name' => $request->name,
            'name_local' => $request->name_local,
            'phone' => $request->phone,
            'image' => $request->image

         ]);
        
        return response()->json(['Store created successfully.', new StoreResource($store)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $store = Store::find($id);
        if (is_null($store)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new StoreResource($store)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Store $store)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'name_local' => 'required',
            'phone' => 'required|max:6'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }
        $store->name = $request->name;
        $store->name_local = $request->name_local;
        $store->phone = $request->phone;
        $store->image = $request->image;
        $store->save();
        
        return response()->json(['Store updated successfully.', new StoreResource($store)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        $store->delete();

        return response()->json('Store deleted successfully');
    }
}
