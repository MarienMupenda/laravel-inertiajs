<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Company;
use App\Models\Item;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

use Inertia\Inertia;
use function App\Helpers\Helpers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //  $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Inertia\Response
     */
    public function index()
    {

        $items = Item::orderBy('created_at', 'desc');
        $items = ItemResource::collection($items->limit(12)->get());


        $data  = [
            'title' => 'Uzaraka - Le grand marché de Lubumbashi',
            'description' => 'bienvenu sur uzaraka',
            'url' => '/',
            'topItems' => $items,
            'topCompany' => $items,
            'recentItems' => $items,
        ];


       return Inertia::render('HomePage', $data);
    }

    public function products()
    {
        4 == 6;

        $page  = [
            'title' => 'Home',
            'description' => 'bienvenu sur uzaraka',
            'url' => '/'
        ];

        return view('index')->with('page', (object)$page);
    }
}
