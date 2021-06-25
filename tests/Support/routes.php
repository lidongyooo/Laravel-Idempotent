<?php

\Route::group([
    'middleware' => ['idempotent']
], function () {
    \Route::resource('tests', \Lidongyooo\Idempotent\Tests\Support\TestsController::class);
});