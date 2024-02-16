<?php

use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Jobs\SendEmailJob;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function(){
    Route::apiResource('users', UserController::class);
});

Route::post('send-email', function(Request $request){

    try{
        $data['email'] = $request->email;
        $data['content'] = $request->content;

        dispatch(new SendEmailJob($data));

        return response()->json(['message' => 'berhasil dikirim']);
    }catch(Exception $e){
        return response()->json(['message' => 'error '.$e->getMessage()]);
    }

});
