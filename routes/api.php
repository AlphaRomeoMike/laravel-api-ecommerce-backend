<?php
    
use App\Http\Controllers\Api\CategoryController;
    use App\Http\Controllers\Api\OptionController;
    use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1/')->group(function () {
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
    
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('/{id}', [CategoryController::class, 'show']);
    });
    
    Route::prefix('options')->group(function () {
        Route::get('/', [OptionController::class, 'index']);
        Route::get('/{id}', [OptionController::class, 'show']);
    });
});

Route::middleware('auth:sanctum')->prefix('v1/')->group(function () {
    Route::prefix('categories')->group(function () {
        Route::get('deleted/data', [CategoryController::class, 'deleted']);
        Route::post('/', [CategoryController::class, 'store']);
        Route::put('/{id}', [CategoryController::class, 'update']);
        Route::delete('/{id}', [CategoryController::class, 'destroy']);
    });
    
    Route::prefix('options')->name('options.')->group(function () {
        Route::put('/{id}', [OptionController::class, 'update'])->name('update');
        Route::delete('/{id}', [OptionController::class, 'destroy'])->name('destroy');
        Route::get('/deleted/data', [OptionController::class, 'deleted'])->name('deleted');
        Route::post('/', [OptionController::class, 'store'])->name('store');
    });
});
