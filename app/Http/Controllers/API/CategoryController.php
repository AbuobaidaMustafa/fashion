<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::all();
        return response()->json([CategoryResource::collection($data), 'Categories fetched.']);
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
            'parent_id' => 'required',
            'user_id' => 'required|string|max:3'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $category = Category::create([
            'name' => $request->name,
            'name_local' => $request->name_local,
            'country_id' => $request->parent_id,
            'user_id' => $request->user_id

         ]);
        
        return response()->json(['Category created successfully.', new CategoryResource($category)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new CategoryResource($category)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
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
        $category->name = $request->name;
        $category->name_local = $request->name_local;
        $category->phone = $request->phone;
        $category->image = $request->image;
        $category->save();
        
        return response()->json(['Category updated successfully.', new CategoryResource($category)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json('Category deleted successfully');
    }
}
