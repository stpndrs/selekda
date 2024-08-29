<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $portfolios = Portfolio::all();

        return $this->success(['portfolios' => $portfolios], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'image' => 'required|image',
            'description' => 'required',
            'author' => 'integer'
        ]);

        if ($validate->fails()) return $this->validateRes($validate->errors());

        $extension = $request->file('image')->getClientOriginalExtension();
        $image = time() . '.' . $extension;
        $path = 'public/portfolios';

        $request->file('image')->storeAs(
            $path,
            $image
        );

        Portfolio::create([
            'title' => $request->title,
            'image' => $path . '/' . $image,
            'description' => $request->description,
            'author' => $request->author
        ]);

        return $this->success(['message' => 'Portfolio successfully created'], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $portfolio = Portfolio::find($id);

        if (!$portfolio) return $this->notfound(['message' => 'Portfolio not found']);

        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'image' => 'required|image',
            'description' => 'required',
            'author' => 'boolean'
        ]);

        if ($validate->fails()) return $this->validateRes($validate->errors());

        $bannerImg = $portfolio->image;

        if ($request->hasFile('image')) {
            Storage::delete($portfolio->image);

            $extension = $request->file('image')->getClientOriginalExtension();
            $image = time() . '.' . $extension;
            $path = 'public/portfolios';

            $request->file('image')->storeAs(
                $path,
                $image
            );

            $bannerImg = $path . '/' . $image;
        }

        $portfolio->update([
            'title' => $request->title,
            'image' => $bannerImg,
            'description' => $request->description,
            'author' => $request->author
        ]);

        return $this->success(['message' => 'Portfolio successfully updated'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $portfolio = Portfolio::find($id);

        if (!$portfolio) return $this->notfound(['message' => 'Portfolio not found']);

        Storage::delete($portfolio->image);

        $portfolio->delete();

        return $this->success([], 204);
    }
}
