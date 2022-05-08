<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Item;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\OrderItem;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $data =  [
            'orders' => OrderResource::collection(Order::all()),
        ];

        return Inertia::render('Orders/Index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreOrderRequest $request
     * @return \Illuminate\Http\JsonResponse|\Inertia\Response
     */
    public function store(StoreOrderRequest $request)
    {
        $item = Item::findOrFail($request->item);

        $order = new Order();
        $order->user_id = $request->user;
        $order->company_id = $item->company_id;
        $order->save();

        $order_item = new OrderItem();
        $order_item->order_id = $order->id;
        $order_item->item_id = $item->id;
        $order_item->quantity = $request->quantity;
        $order_item->currency_id = $item->currency_id;
        $order_item->save();

        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post(env('FRESH_PAY_API_URL', null), $data);
        $responseData = json_decode($response, true);
        $comment = $responseData['Comment'];
        $status = $response->status();


        return Inertia::render('Checkout', [
            'order' => $order,
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateOrderRequest $request
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
