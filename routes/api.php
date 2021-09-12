<?php
    
use App\Http\Controllers\Api\CategoryController;
    use App\Http\Controllers\Api\OptionController;
    use App\Http\Controllers\Api\SubCategoryController;
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
    
    /** Categories Routes - No Middleware */
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('/{id}', [CategoryController::class, 'show']);
    });
    
    /** Options Routes - No Middleware */
    Route::prefix('options')->group(function () {
        Route::get('/', [OptionController::class, 'index']);
        Route::get('/{id}', [OptionController::class, 'show']);
    });
    
    /** SubCategories Routes - No Middleware */
    Route::prefix('subcategories')->group(function () {
        Route::get('/', [SubCategoryController::class, 'index']);
        Route::get('/{id}', [SubCategoryController::class, 'show']);
    });
});

Route::middleware('auth:sanctum')->prefix('v1/')->group(function () {
    /** Categories Routes */
    Route::prefix('categories')->group(function () {
        Route::get('deleted/data', [CategoryController::class, 'deleted']);
        Route::post('/', [CategoryController::class, 'store']);
        Route::put('/{id}', [CategoryController::class, 'update']);
        Route::delete('/{id}', [CategoryController::class, 'destroy']);
    });
    
    /** Option Routes */
    Route::prefix('options')->name('options.')->group(function () {
        Route::put('/{id}', [OptionController::class, 'update'])->name('update');
        Route::delete('/{id}', [OptionController::class, 'destroy'])->name('destroy');
        Route::get('/deleted/data', [OptionController::class, 'deleted'])->name('deleted');
        Route::post('/', [OptionController::class, 'store'])->name('store');
    });
    
    /** SubCategories Routes */
    Route::prefix('subcategories')->name('options.')->group(function () {
        Route::put('/{id}', [SubCategoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [SubCategoryController::class, 'destroy'])->name('destroy');
        Route::get('/deleted/data', [SubCategoryController::class, 'deleted'])->name('deleted');
        Route::post('/', [SubCategoryController::class, 'store'])->name('store');
    });
});
