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


    }
}
