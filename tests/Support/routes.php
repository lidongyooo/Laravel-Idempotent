<?php

use Illuminate\Support\Str;

\Route::post('token', function (){
    return Str::uuid();
});