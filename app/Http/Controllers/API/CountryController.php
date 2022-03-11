<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Country;
use App\Http\Resources\CountryResource;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Country::all();
        return response()->json([CountryResource::collection($data), 'Countries fetched.']);
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

        $country = Country::create([
            'name' => $request->name,
            'name_local' => $request->name_local,
            'phone' => $request->phone,
            'image' => $request->image

         ]);
        
        return response()->json(['Country created successfully.', new CountryResource($country)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $country = Country::find($id);
        if (is_null($country)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new CountryResource($country)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'name_local' => 'required',
            'phone' => 'required|max:6'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }
        $country->name = $request->name;
        $country->name_local = $request->name_local;
        $country->phone = $request->phone;
        $country->image = $request->image;
        $country->save();
        
        return response()->json(['Country updated successfully.', new CountryResource($country)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        $country->delete();

        return response()->json('Country deleted successfully');
    }
}
