<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\SubCategory;
use Exception;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\JsonResponse;

class SubCategoryController extends Controller
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
            $subcategory = SubCategory::with('category')->paginate(50);
    
            return response()->json([
              'data' => $subcategory,
              'success' => true,
              'msg' => 'Subcategories were retrieved'
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
     * @param  SubCategoryRequest  $request
     *
     * @return JsonResponse
     */
    public function store(SubCategoryRequest $request): JsonResponse
    {
        try
        {
            $subcategory = SubCategory::create($request->validated());
    
            return response()->json([
              'data' => $subcategory,
              'success' => true,
              'msg' => 'Subcategory was created'
            ], $this->createdStatus);
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
     * @param  mixed  $id
     *
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try
        {
            $subcategory = SubCategory::with('category')->where('category_id', $id)->get();
    
            return response()->json([
              'data' => $subcategory,
              'success' => true,
              'msg' => 'Subcategory retrieved'
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
     * Update the specified resource in storage.
     *
     * @param  SubCategoryRequest  $request
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function update(SubCategoryRequest $request, $id): JsonResponse
    {
        try
        {
            $subcategory = SubCategory::findOrFail($id)->first();
            
            if ($subcategory)
            {
                $subcategory->update($request->validated());
    
                return response()->json([
                  'data' => $subcategory,
                  'success' => true,
                  'msg' => 'Options was updated'
                ], $this->successStatus);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try
        {
            $subcategory = SubCategory::findOrFail($id)->first();
            
            if ($subcategory)
            {
                $subcategory->delete();
                
                return response()->json([
                  'data' => $subcategory,
                  'success' => true,
                  'msg' => 'Subcategory was deleted'
                ], $this->successStatus);
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
     * Retrieve soft deleted resources.
     *
     * @return JsonResponse
     */
    public function deleted(): JsonResponse
    {
        try
        {
            $subcategories = SubCategory::withTrashed()->paginate(50);
    
            return response()->json([
              'data' => $subcategories,
              'success' => true,
              'msg' => 'Subcategories with deleted records were retrieved'
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
}
