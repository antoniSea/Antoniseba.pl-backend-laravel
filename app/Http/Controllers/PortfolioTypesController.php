<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PortfolioItem;
use App\Models\PortfolioType;
use Inertia\Inertia;

class PortfolioTypesController extends Controller
{
    public function create () {
        return Inertia::render('portfolio/CreateType');
    }

    public function store (Request $request) {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $type = new PortfolioType();
        $type->name = $request->name;
        $type->save();

        return redirect()->route('portfolio-type.index');
    }

    public function index () {
        $types = PortfolioType::all();
        return Inertia::render('portfolio/IndexType', [
            'types' => $types
        ]);
    }

    public function show ($id) {

    }

    public function destroy ($id) {
        PortfolioType::find($id)->delete();
        return redirect()->route('portfolio-type.index');
    }
}
