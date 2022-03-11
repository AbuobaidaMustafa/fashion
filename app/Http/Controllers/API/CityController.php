<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\City;
use App\Http\Resources\CityResource;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = City::all();
        return response()->json([CityResource::collection($data), 'Cities fetched.']);
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
            'country_id' => 'required',
            'short_tag' => 'required|string|max:3'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $city = City::create([
            'name' => $request->name,
            'name_local' => $request->name_local,
            'country_id' => $request->country_id,
            'short_tag' => $request->short_tag

         ]);
        
        return response()->json(['City created successfully.', new CityResource($city)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $city = City::find($id);
        if (is_null($city)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new CityResource($city)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'name_local' => 'required',
            'country_id' => 'required',
            'short_tag' => 'required|string|max:3'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }
        $city->name = $request->name;
        $city->name_local = $request->name_local;
        $city->phone = $request->phone;
        $city->image = $request->image;
        $city->save();
        
        return response()->json(['City updated successfully.', new CityResource($city)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $city->delete();

        return response()->json('City deleted successfully');
    }
}
