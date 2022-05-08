<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Share;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Item $item
     * @return \Inertia\Response
     */
    public function show(Item $item)
    {

        $similarItems  = Item::where('category_id', $item->category_id)
            ->where('id', '<>', $item->id)
            ->orderByDesc('id')
            ->limit(4)
            ->get();

        $data  = [
            'title' => $item->name,
            'description' => $item->description,
            'item' => ItemResource::make($item),
            'similarItems' =>ItemResource::collection($similarItems),
            'url' => '/',
        ];

        return Inertia::render('Items/Show', $data);
    }

    public function checkout(Request $request,Item $item)
    {

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $data  = [
            'item' => ItemResource::make($item),
            'quantity' => $request->quantity,
        ];

        return Inertia::render('Items/Checkout', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
