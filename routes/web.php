<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Roofy is API-first. Web routes are minimal — the SPA frontend handles UI.
| Duplicate auth routes removed; use /api/register and /api/login instead.
*/

Route::get('/', function () {
    return response()->json([
        'name' => 'Roofy API',
        'version' => '1.0',
        'docs' => 'See README.md for API endpoint documentation.',
    ]);
});
