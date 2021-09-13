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
            $product = Product::with('pictures', 'categories', 'subcategories')->paginate(20);
    
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
              'count'     => 0,
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
            $responseArray = array();
            /** @var $data, get validated data only */
            $data = $request->validated();
            
            /** append a unique sku to the validated data */
            $data['sku'] = Str::slug($data['name']). '-' . time() . '-' . rand(111111, 9999999);
            
            /** @var $product, create a product */
            $product = Product::create($data);
            
            $responseArray['product'] = $product;
            
            /** process the images */
            if($request->has('images'))
            {
                $images = $request->get('images');
                
                $count = 0;
                
                /** @var $image, iterated over the images array */
                foreach ($images as $image)
                {
                    /** @var  $filename */
                    $filename = $product->id . '-' . rand(111111, 999999) . '-' . time();
                    
                    /** @var $image_resized, resize the image from real path */
                    $image_resized = Image::make($image->getRealPath())->resize(500, 500);
                    
                    /** @var $image_resized, save to public path */
                    $image_resized->save(public_path('product/' . $filename));
                    
                    /** @var $picture, create a new instance of picture */
                    $picture = new Picture();
                    $picture->product_id = $product->id;
                    $picture->picture = $filename;
                    $picture->save();
                    
                    $responseArray['pictures'][$count++] = $picture;
                }
            }
            
            /** Process the categories */
            if ($request->has('categories'))
            {
                $count = 0;
                $categories = $request->get('categories');
                
                foreach ($categories as $category)
                {
                
                }
            }
        }
        catch(Exception $ex)
        {
            /* Return failure response*/
            return response()->json([
              'data'      => [],
              'count'     => 0,
              'success'   => false,
              'msg'       => $ex->getMessage() . ' on ' . $ex->getLine()
            ], $this->responseFailed);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try
        {

        }
        catch(Exception $ex)
        {
            /* Return failure response*/
            return response()->json([
              'data'      => [],
              'count'     => 0,
              'success'   => false,
              'msg'       => $ex->getMessage() . ' on ' . $ex->getLine()
            ], $this->responseFailed);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        try
        {

        }
        catch(Exception $ex)
        {
            /* Return failure response*/
            return response()->json([
              'data'      => [],
              'count'     => 0,
              'success'   => false,
              'msg'       => $ex->getMessage() . ' on ' . $ex->getLine()
            ], $this->responseFailed);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try
        {

        }
        catch(Exception $ex)
        {
            /* Return failure response*/
            return response()->json([
              'data'      => [],
              'count'     => 0,
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

        }
        catch(Exception $ex)
        {
            /* Return failure response*/
            return response()->json([
              'data'      => [],
              'count'     => 0,
              'success'   => false,
              'msg'       => $ex->getMessage() . ' on ' . $ex->getLine()
            ], $this->responseFailed);
        }
    }
}
