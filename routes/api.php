<?php
    
    use App\Http\Controllers\Api\CategoryController;
    use App\Http\Controllers\Api\OptionController;
	 use App\Http\Controllers\Api\OrderController;
	 use App\Http\Controllers\Api\ProductController;
    use App\Http\Controllers\Api\SubCategoryController;
    use App\Http\Controllers\Api\TagController;
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
    
    /* @link 'localhost:8000/api/v1' */
    Route::prefix('v1/')->group(function () {
        /**
         * @link 'localhost:8000/api/v1/register'
         * @api POST
         */
        Route::post('register', [UserController::class, 'register']);
        /**
         * @link 'localhost:8000/api/v1/login'
         * @api POST
         */
        Route::post('login', [UserController::class, 'login']);
        
        /**
         * @link 'localhost:8000/api/v1/categories'
         * Categories Routes - No Middleware
         */
        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index']);
            Route::get('/{id}', [CategoryController::class, 'show']);
        });
        
        /**
         * @link 'localhost:8000/api/v1/product'
         * Product Routes - No Middleware
         */
        Route::prefix('products')->name('product.')->group(function () {
            Route::get('/tags', [ProductController::class, 'tags'])->name('tags');
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/{id}', [ProductController::class, 'show'])->name('show');
        });
        
        /**
         * @link 'localhost:8000/api/v1/options'
         * Options Routes - No Middleware
         */
        Route::prefix('options')->group(function () {
            Route::get('/', [OptionController::class, 'index']);
            Route::get('/{id}', [OptionController::class, 'show']);
        });
        
        /**
         * @link 'localhost:8000/api/v1/subcategories'
         * SubCategories Routes - No Middleware
         */
        Route::prefix('subcategories')->group(function () {
            Route::get('/', [SubCategoryController::class, 'index']);
            Route::get('/{id}', [SubCategoryController::class, 'show']);
        });
    
        /**
         * @link 'localhost:8000/api/v1/tags'
         * Tags Routes - No Middleware
         */
        Route::apiResource('tags', TagController::class)->only(['index', 'show']);
    });
    
    Route::middleware('auth:sanctum')->prefix('v1/')->group(function () {
        /**
         * @link 'localhost:8000/api/v1/categories'
         * Categories Routes
         */
        Route::prefix('categories')->group(function () {
            /* @api GET */
            Route::get('deleted/data', [CategoryController::class, 'deleted']);
            /* @api POST */
            Route::post('/', [CategoryController::class, 'store']);
            /* @api PUT */
            Route::put('/{id}', [CategoryController::class, 'update']);
            /* @api DELETE */
            Route::delete('/{id}', [CategoryController::class, 'destroy']);
            /* @api GET */
            Route::get('/subcategories/data', [CategoryController::class, 'subcategories']);
        });
    
        /**
         * @link 'localhost:8000/api/v1/options'
         * Option Routes
         */
        Route::prefix('options')->name('options.')->group(function () {
            /* @api PUT */
            Route::put('/{id}', [OptionController::class, 'update'])->name('update');
            /* @api DELETE */
            Route::delete('/{id}', [OptionController::class, 'destroy'])->name('destroy');
            /* @api GET */
            Route::get('/deleted/data', [OptionController::class, 'deleted'])->name('deleted');
            /* @api POST */
            Route::post('/', [OptionController::class, 'store'])->name('store');
        });
        
        /**
         * @link 'localhost:8000/api/v1/subcategories'
         * SubCategories Routes
         */
        Route::prefix('subcategories')->name('options.')->group(function () {
            /* @api PUT */
            Route::put('/{id}', [SubCategoryController::class, 'update'])->name('update');
            /* @api DELETE */
            Route::delete('/{id}', [SubCategoryController::class, 'destroy'])->name('destroy');
            /* @api GET */
            Route::get('/deleted/data', [SubCategoryController::class, 'deleted'])->name('deleted');
            /* @api POST */
            Route::post('/', [SubCategoryController::class, 'store'])->name('store');
        });
        
        Route::prefix('products')->name('product.')->group(function () {
            /**
             * @link 'localhost:8000/api/v1/product'
             * @api POST
             */
            Route::post('/', [ProductController::class, 'store'])->name('create');
            /* @api PUT */
            Route::put('/{id}', [ProductController::class, 'update'])->name('update');
            /* @api DELETE */
            Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
            /* @api GET */
            Route::get('/deleted/data', [ProductController::class, 'deleted'])->name('deleted');
        });
    
        /* @link 'localhost:8000/api/v1/tags' */
        Route::apiResource('tags', TagController::class)->except(['index', 'show']);
        
        /* @link 'localhost:8000/api/v1/orders */
			 Route::apiResource('orders', OrderController::class);
    });
