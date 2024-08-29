<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::all();

        return $this->success(['banners' => $banners], 200);
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
            'status' => 'boolean'
        ]);

        if ($validate->fails()) return $this->validateRes($validate->errors());

        $extension = $request->file('image')->getClientOriginalExtension();
        $image = time() . '.' . $extension;
        $path = 'public/banners';

        $request->file('image')->storeAs(
            $path,
            $image
        );

        Banner::create([
            'title' => $request->title,
            'image' => $path . '/' . $image,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return $this->success(['message' => 'Banner successfully created'], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $banner = Banner::find($id);

        if (!$banner) return $this->notfound(['message' => 'Banner not found']);

        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'image' => 'required|image',
            'description' => 'required',
            'status' => 'boolean'
        ]);

        if ($validate->fails()) return $this->validateRes($validate->errors());

        $bannerImg = $banner->image;

        if ($request->hasFile('image')) {
            Storage::delete($banner->image);

            $extension = $request->file('image')->getClientOriginalExtension();
            $image = time() . '.' . $extension;
            $path = 'public/banners';

            $request->file('image')->storeAs(
                $path,
                $image
            );

            $bannerImg = $path . '/' . $image;
        }

        $banner->update([
            'title' => $request->title,
            'image' => $bannerImg,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return $this->success(['message' => 'Banner successfully updated'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::find($id);

        if (!$banner) return $this->notfound(['message' => 'Banner not found']);

        Storage::delete($banner->image);

        $banner->delete();

        return $this->success([], 204);
    }
}
