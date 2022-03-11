<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Area;
use App\Http\Resources\AreaResource;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Area::all();
        return response()->json([AreaResource::collection($data), 'Areas fetched.']);
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
            'name' => ['required', 'unique:areas', 'max:50'],
            'name_local' => ['unique:areas', 'max:50'],
            'city_id' => ['required']
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $area = Area::create([
            'name' => $request->name,
            'name_local' => $request->name_local,
            'city_id' => $request->city_id

         ]);
        
        return response()->json(['Area created successfully.', new AreaResource($area)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $area = Area::find($id);
        if (is_null($area)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new AreaResource($area)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Area $area)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'name_local' => 'required',
            'phone' => 'required|max:6'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }
        $area->name = $request->name;
        $area->name_local = $request->name_local;
        $area->phone = $request->phone;
        $area->image = $request->image;
        $area->save();
        
        return response()->json(['Area updated successfully.', new AreaResource($area)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        $area->delete();

        return response()->json('Area deleted successfully');
    }
}
