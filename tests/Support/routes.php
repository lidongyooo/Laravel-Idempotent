<?php

use Lidongyooo\Idempotent\Tests\Support\TestsController;

\Route::group([
    'middleware' => ['idempotent']
], function () {
    \Route::resource('tests', TestsController::class);
    \Route::post('tests/exception', TestsController::class.'@exception');
});