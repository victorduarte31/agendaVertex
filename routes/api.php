<?php

use Illuminate\Http\Request;

Route::apiResource('agenda', 'AgendaController');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
