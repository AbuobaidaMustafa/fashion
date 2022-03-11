<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Language;
 use \API\CountryController;
 use \API\StateController;
 use \API\AreaController;
 use \API\ItemController;
 use \API\StoreController;
 use \API\CategoryController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

    //APIs
    Route::resource("/countries", CountryController::class);
    Route::resource("/states", StateController::class);
    Route::resource("/areas", AreaController::class);
    Route::resource("/items", ItemController::class);
    Route::resource("/stores", StoreController::class);
    Route::resource("/categories", CategoryController::class);

    //Filter Items 
    Route::get("/item",[App\http\Controllers\API\ItemController::class,'filter']);

Route::get("/languages", function(){
    return Language::all();
});

// Route::get("/countries", function(){
//     return Country::all();
// });

