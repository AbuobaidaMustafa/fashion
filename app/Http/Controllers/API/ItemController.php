<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Item;
use App\Http\Resources\ItemResource;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Item::all();
        return response()->json([ItemResource::collection($data), 'Items fetched.']);
    }



    public function filter(Request $request){
        if($request->from&&$request->to){
            $query = Item::whereBetween('price',[$request->from,$request->to])->get();
            return response()->json([ItemResource::collection($query), 'price fetched.']);
        }
        if($request->category_id){
            $query = Item::where('category_id',$request->category_id)->get();
            return response()->json([ItemResource::collection($query), 'By category fetched.']);
        }
        if($request->city_id){
            $query = Item::where('city_id',$request->city_id)->get();
            return response()->json([ItemResource::collection($query), 'By city fetched.']);
        }
        if($request->store_id){
            $query = Item::where('store_id',$request->store_id)->get();
            return response()->json([ItemResource::collection($query), 'By store fetched.']);
        }
        if($request->in_stock){
            $query = Item::where('in_stock',$request->store_id)->get();
            return response()->json([ItemResource::collection($query), 'By store fetched.']);
        }
        
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
            'name_local' => 'requiredstring|max:255',
            'store_id' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'sales_price' => 'required'
            
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $item = Item::create([
            'name' => $request->name,
            'name_local' => $request->name_local,
            'store_id' => $request->store_id,
            'category_id' => $request->category_id

         ]);
        
        return response()->json(['Item created successfully.', new ItemResource($item)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::find($id);
        if (is_null($item)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new ItemResource($item)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'name_local' => 'required',
            'phone' => 'required|max:6'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }
        $item->name = $request->name;
        $item->name_local = $request->name_local;
        $item->phone = $request->phone;
        $item->image = $request->image;
        $item->save();
        
        return response()->json(['Item updated successfully.', new ItemResource($item)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return response()->json('Item deleted successfully');
    }
}
