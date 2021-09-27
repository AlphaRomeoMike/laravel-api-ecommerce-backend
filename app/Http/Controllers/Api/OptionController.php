<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OptionRequest;
use App\Http\Resources\OptionResource;
use App\Models\Option;
use Exception;
use Illuminate\Http\JsonResponse;

class OptionController extends Controller
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
            $options = Option::paginate(50);

            /* Return successful response */
            return response()->json([
                'data'      => $options,
                'success'   => true,
                'msg'       => 'Options were retrieved'
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
     * @param  OptionRequest  $request
     *
     * @return JsonResponse
     */
    public function store(OptionRequest $request): JsonResponse
    {
        try
        {
            $option = Option::create($request->validated());

            return response()->json([
              'data' => $option,
              'success' => true,
              'msg' => 'Option was stored'
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
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try
        {
            $option = Option::findOrFail($id);

            return response()->json([
              'data' => $option,
              'success' => true,
              'msg' => 'Option was retrieved'
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
     * @param  OptionRequest  $request
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function update(OptionRequest $request, $id): JsonResponse
    {
        try
        {
            $option = Option::findOrFail($id);

            if ($option)
            {
                $option->update($request->validated());

                return response()->json([
                  'data' => $option,
                  'success' => true,
                  'msg' => 'Option was updated'
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
            $option = Option::findOrFail($id);

            if ($option)
            {
                $option->delete();

                return response()->json([
                  'data' => $option,
                  'success' => true,
                  'msg' => 'Option was destroyed'
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
            $options = Option::withTrashed()->paginate(50);

            return response()->json([
              'data' => $options,
              'success' => true,
              'msg' => 'Options with deleted data were retrieved'
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
