<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PortfolioItem;
use App\Models\PortfolioType;

class PortfolioItemsController extends Controller
{
    public function index () {
        $items = PortfolioType::all();
        foreach ($items as $item) {
            $item->items = $item->PortfolioItems()->get();
        }

        return response()->json($items, 200);
    }

    public function show ($id) {
        $type = PortfolioType::find($id);
        $type->items = $type->PortfolioItems()->get();

        return response()->json($type, 200);
    }
}
