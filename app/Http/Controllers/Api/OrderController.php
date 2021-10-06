<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
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
            $orders = Order::with('user')->paginate();

            return response()->json([
                'orders'    => $orders,
                'success'   => true,
                'msg'       => 'All orders were retrieved'
            ], 200);
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
     * @param  OrderRequest  $request
     * @return JsonResponse
     */
    public function store(OrderRequest $request): JsonResponse
    {
        try
        {
            /** 
             * Get all data except products to 
             * create an order 
             */
            $data = $request->except('products');

            $data['user_id'] = $request->user()->id;

            $products = $request->input('products');

            $order = Order::create([
                'user_id'   => $data['user_id'],
                'address'   => $data['address'],
                'email'     => $data['email'],
                'status'    => 'RECIEVED',
                'details'   => $data['details'],
                'ordered_at'=> now()
            ]);

            foreach ($products as $product) 
            {
                $find = Product::find($product['id']);

                if($find)
                {
                    $price = $find->price;
                
                    if ($product['quantity'] > $find->stock)
                    {
                        return response()->json([
                            'data'      => [],
                            'success'   => false,
                            'msg'       => 'Not enough item in the stock'
                        ], 422);
                    }

                    $amount = $price * $product['quantity'];

										$order->order_product()->attach($order->id, [
											// TODO: Continue working on orders
										]);
                }
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
              'success'   => false,
              'msg'       => $ex->getMessage() . ' on ' . $ex->getLine()
            ], $this->responseFailed);
        }
    }
}
