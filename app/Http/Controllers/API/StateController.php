<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\State;
use App\Http\Resources\StateResource;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = State::all();
        return response()->json([StateResource::collection($data), 'States fetched.']);
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

        $state = State::create([
            'name' => $request->name,
            'name_local' => $request->name_local,
            'country_id' => $request->country_id,
            'short_tag' => $request->short_tag

         ]);
        
        return response()->json(['State created successfully.', new StateResource($state)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $state = State::find($id);
        if (is_null($state)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new StateResource($state)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, State $state)
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
        $state->name = $request->name;
        $state->name_local = $request->name_local;
        $state->phone = $request->phone;
        $state->image = $request->image;
        $state->save();
        
        return response()->json(['State updated successfully.', new StateResource($state)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state)
    {
        $state->delete();

        return response()->json('State deleted successfully');
    }
}
