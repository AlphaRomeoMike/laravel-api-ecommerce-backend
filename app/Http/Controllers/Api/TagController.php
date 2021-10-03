<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagsRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Spatie\Tags\Tag;

class TagController extends Controller
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
            $tags = Tag::paginate(50);
    
            return response()->json([
              'data' => $tags,
              'success' => true,
              'msg' => 'Tags were retrieved'
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
     * @param  TagsRequest  $request
     *
     * @return JsonResponse
     */
    public function store(TagsRequest $request): JsonResponse
    {
        try
        {
            $data = Str::ucfirst($request->input('name'));
            
            $tag = Tag::create([
              'name'    => $data
            ]);
    
            return response()->json([
              'data' => $tag,
              'success' => true,
              'msg' => 'Tag was created'
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
     * @param  Tag $tag
     * @return JsonResponse
     */
    public function show(Tag $tag): JsonResponse
    {
        try
        {
            return response()->json([
              'data' => $tag,
              'success' => true,
              'msg' => 'Tag was retrieved'
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
     * @param  TagsRequest  $request
     * @param  Tag  $tag
     *
     * @return JsonResponse
     */
    public function update(TagsRequest $request, Tag $tag): JsonResponse
    {
        try
        {
            $tag->update($request->validated());
    
            return response()->json([
              'data' => $tag,
              'success' => true,
              'msg' => 'Tag was updated'
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
     * Remove the specified resource from storage.
     *
     * @param  Tag  $tag
     *
     * @return JsonResponse
     */
    public function destroy(Tag $tag): JsonResponse
    {
        try
        {
            $tag->delete();
    
            return response()->json([
              'data' => $tag,
              'success' => true,
              'msg' => 'Tag was deleted'
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
