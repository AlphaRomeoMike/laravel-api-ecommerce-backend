<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Picture;
use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Ramsey\Uuid\Uuid;

class ProductController extends Controller
{
    protected $successStatus = 200;
    protected $createdStatus = 201;
    protected $requestFailed = 404;
    protected $responseFailed = 500;
    protected $forbiddenStatus = 403;

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try
        {
            $product = Product::with('pictures', 'categories', 'subcategories')->paginate();
    
            return response()->json([
              'data' => $product,
              'success' => true,
              'msg' => 'Products were retrieved'
            ], $this->successStatus);
        }
        catch(Exception $ex)
        {
            /* Return failure response*/
            return response()->json([
              'data'      => [],
              'success'   => false,
              'msg'       => $ex->getMessage() . ' on ' . $ex->getLine()
            ], $this->responseFailed);
        }
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductRequest  $request
     *
     * @return JsonResponse
     */
    public function store(ProductRequest $request): JsonResponse
    {
        try
        {
            /** @var $data, get validated data only */
            $data = $request->validated();
            
            /* append a unique sku to the validated data */
            $data['sku'] = Str::slug($data['name']). '-' . time() . '-' . rand(111111, 9999999);
            
            /** @var $product, create a product */
            $product = Product::create($data);
            
            /* Create tags if the request has tags array */
            if($request->has('tags'))
            {
                if(!empty($request->input('tags')))
                {
                    $product->attachTags($request->input('tags'));
                }
            }
            
            /* process the images */
            if($request->hasFile('images'))
            {
                $images = $request->images;
                
                /** @var $image, iterated over the images array */
                foreach ($images as $image)
                {
                    /** @var  $filename */
                    $filename = $product->id . '-' . rand(111111, 999999) . '-' . time() . '.' . $image->getClientOriginalExtension();
                    
                    /** @var $image_resized, resize the image from real path */
                    $image_resized = Image::make($image->getRealPath())->resize(500, 500);
                    
                    /** @var $image_resized, save to public path */
                    $image_resized->save(public_path() . '/product/' . $filename);
                    
                    /** @var $picture, create a new instance of picture */
                    $picture = new Picture();
                    $picture->product_id = $product->id;
                    $picture->picture = $filename;
                    $picture->save();
                }
            }
            
            /** Process the categories */
            if ($request->has('categories'))
            {
                $categories = $request->get('categories');
                
                $count = 1;
                
                foreach ($categories as $category)
                {
                    $product->categories()->attach($category);
                }
            }
            
            /** Process the subcategories */
            if ($request->has('subcategories'))
            {
                $subcategories = $request->get('subcategories');
                
                foreach ($subcategories as $subcategory)
                {
                    $product->subcategories()->attach($subcategory);
                }
            }
            
            $responseArray = Product::with('categories', 'subcategories', 'pictures')->find($product->id);
    
            return response()->json([
              'data'    => $responseArray,
              'success' => true,
              'count'   => 1,
              'msg'     => 'Product was created'
            ], $this->createdStatus);
        }
        catch(Exception $ex)
        {
            /* Return failure response*/
            return response()->json([
              'data'      => [],
              'success'   => false,
              'file'      => $ex->getFile(),
              'msg'       => $ex->getMessage() . ' on ' . $ex->getLine(),
              'stack'     => $ex->getTraceAsString()
            ], $this->responseFailed);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try
        {
            $product = Product::with('categories', 'subcategories', 'pictures')->findOrFail($id);
    
            return response()->json([
              'data'    => $product,
              'success' => true,
              'count'   => 1,
              'msg'     => 'Product was retrieved'
            ], $this->successStatus);
        }
        catch(Exception $ex)
        {
            /* Return failure response*/
            return response()->json([
              'data'      => [],
              'success'   => false,
              'msg'       => $ex->getMessage() . ' on ' . $ex->getLine()
            ], $this->responseFailed);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(ProductRequest $request, int $id): JsonResponse
    {
        try
        {
            $product = Product::findOrFail($id);
            
            if ($product)
            {
                $product->update($request->validated());
    
                return response()->json([
                  'data'    => $product,
                  'success' => true,
                  'count'   => 1,
                  'msg' => 'Product was updated'
                ], $this->successStatus);
            }
        }
        catch(Exception $ex)
        {
            /* Return failure response*/
            return response()->json([
              'data'      => [],
              'success'   => false,
              'msg'       => $ex->getMessage() . ' on ' . $ex->getLine()
            ], $this->responseFailed);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try
        {
            $product = Product::findOrFail($id);
            
            if ($id)
            {
                $product->delete();
                
                return response()->json([
                  'data'    => [],
                  'success' => true,
                  'msg'     => 'Product was destroyed'
                ], $this->successStatus);
            }
        }
        catch(Exception $ex)
        {
            /* Return failure response*/
            return response()->json([
              'data'      => [],
              'success'   => false,
              'msg'       => $ex->getMessage() . ' on ' . $ex->getLine()
            ], $this->responseFailed);
        }
    }

    /**
     * Retrieve soft deleted resources.
     *
     * @return JsonResponse
     */
    public function deleted(): JsonResponse
    {
        try
        {
            $products = Product::onlyTrashed()->paginate();
    
            return response()->json([
              'data' => $products,
              'success' => true,
              'msg' => 'Deleted products were retrieved'
            ], $this->successStatus);
        }
        catch(Exception $ex)
        {
            /* Return failure response*/
            return response()->json([
              'data'      => [],
              'success'   => false,
              'msg'       => $ex->getMessage() . ' on ' . $ex->getLine()
            ], $this->responseFailed);
        }
    }
}
