<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\CreatePortfolioItemRequest;
use App\Models\PortfolioItem;
use Intervention\Image\Facades\Image;
use App\Models\PortfolioType;

class PortfolioItemsController extends Controller
{
    public function create () {
        $portfolioTypes = PortfolioType::all();

        return Inertia::render('portfolio/Create', [
            'portfolioTypes' => $portfolioTypes
        ]);
    }

    public function store ( CreatePortfolioItemRequest $request ) {
        $portfolioItem = new PortfolioItem;
        $portfolioItem->title = $request->title;
        $portfolioItem->desctiption = $request->description;
        $portfolioItem->website = "test";
        $portfolioItem->main_photo = "main_photo";
        $portfolioItem->portfolio_type_id = $request->typeSelected;
        $portfolioItem->save();

        $image = $request->photo;
        $img = Image::make($image);

        $img->fit(300, 300);
        $img->save(storage_path('app/public/images/' . $portfolioItem->id . '-' . $image->getClientOriginalName()));    

        $portfolioItem->main_photo = asset( '/storage/images/' . $portfolioItem->id . '-' . $image->getClientOriginalName());
        $portfolioItem->save();

        return redirect()->route('portfolio-items.index');
    }

    public function index () {
        $portfolioItems = PortfolioItem::all();
        return Inertia::render('portfolio/index', [
            'items' => $portfolioItems
        ]);
    }

    public function destroy ($id) {
        PortfolioItem::findorfail($id)->delete();
        return redirect()->route('portfolio-items.index');
    }

    public function edit ($id) {
        $item = PortfolioItem::findorfail($id);
        $portfolioTypes = PortfolioType::all();

        $item->Type = PortfolioType::find($item->portfolio_type_id);
        
        return Inertia::render('portfolio/Edit', [
            'Item' => $item,
            'portfolioTypes' => $portfolioTypes
        ]);
    }

    public function update ( $id, Request $request ) {
        $portfolioItem = PortfolioItem::findorfail($id);
        $portfolioItem->title = $request->title;
        $portfolioItem->desctiption = $request->description;
        $portfolioItem->portfolio_type_id = $request->typeSelected;
        $portfolioItem->save();

        if ($request->hasFile('photo')) {
            $image = $request->photo;
            $img = Image::make($image);

            $img->fit(300, 300);
            $img->save(storage_path('app/public/images/' . $portfolioItem->id . '-' . $image->getClientOriginalName()));    

            $portfolioItem->main_photo = asset( '/storage/images/' . $portfolioItem->id . '-' . $image->getClientOriginalName());
            $portfolioItem->save();
        }

        return redirect()->route('portfolio-items.index');
    }
}
