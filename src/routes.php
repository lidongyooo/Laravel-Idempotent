<?php


\Route::group([
    'namespace' => 'Lidongyooo\Idempotent'
], function(){
    \Route::post('idempotent', 'IdempotentController@store');
});

