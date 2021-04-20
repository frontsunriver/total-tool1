<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "vendor" middleware group. Enjoy building your Vendors API!
|
*/

Route::middleware('auth:vendor')->get('/user', function (Request $request) {
    return $request->user();
});




/*
	|--------------------------------------------------------------------------
	| Vendor Controller Routes
	|--------------------------------------------------------------------------
	|
	| This section contains all Routes of vendor application
	|
	|
*/