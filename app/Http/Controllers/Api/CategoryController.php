<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Api\CategoryNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
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
            /* Return all data paginated */
            $categories = Category::paginate();

            /* Return successful response */
            return response()->json([
                'data'          => $categories,
                'count'         => count($categories),
                'success'       => true,
                'msg'           => 'All categories retrieved'
            ], $this->successStatus);
        }
        catch (Exception $ex)
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
     * @param  CategoryRequest  $request
     * @return JsonResponse
     */
    public function store(CategoryRequest $request)
    {
        try
        {
            $category = Category::create($request->input());

            return response()->json([
                'category'      => $category,
                'count'         => 1,
                'success'       => true,
                'msg'           => 'Category added'
            ], $this->createdStatus);
        }
        catch (Exception $ex)
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try
        {
            $category = Category::find($id);

            /* Return successful response */
            return response()->json([
              'data'          => $category,
              'count'         => 1,
              'success'       => true,
              'msg'           => 'Category retrieved'
            ], $this->successStatus);
        }
        catch (Exception $ex)
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
	 * @param CategoryRequest $request
	 * @param int $id
	 * @return JsonResponse
	 * @throws Exception
	 */
    public function update(CategoryRequest $request, int $id): JsonResponse
    {
         $category = Category::find($id);

         if ($category)
         {
             $category->update($request->validated());

             /* Return successful response */
             return response()->json([
               'data'          => $category,
               'count'         => 1,
               'success'       => true,
               'msg'           => 'Category updated'
             ], $this->successStatus);
         }
         else
         {
            throw new Exception( 'Category not found!' , 404);
         }
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return JsonResponse
	 * @throws Exception
	 */
    public function destroy(int $id): JsonResponse
    {
	      $category = Category::find($id);

	      if($category)
	      {
	          $category->delete();

	          /* Return successful response */
	          return response()->json([
	            'data'          => $category,
	            'count'         => 1,
	            'success'       => true,
	            'msg'           => 'Category deleted'
	          ], $this->successStatus);
	      }
	      else
	      {
	          throw new Exception('Category not found' , 404);
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
            $categories = Category::withTrashed()->paginate();

            /* Return successful response */
            return response()->json([
              'data'          => $categories,
              'count'         => 1,
              'success'       => true,
              'msg'           => 'Deleted categories retrieved'
            ], $this->successStatus);
        }
        catch (Exception $ex)
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
     * Find subcategories with categories
     *
     * @api v1/categories/subcategories/data
     * @return JsonResponse
     */
	public function subcategories() : JsonResponse
	{
			$subcategories = Category::with('subcategories')->paginate();

			return response()->json([
				'data'      => $subcategories,
				'success'   => true,
				'msg'       => 'Subcategories were retrieved'
			]);
	}
}
