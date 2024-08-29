<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::with('author')->get();

        return $this->success(['blogs' => $blogs], 200);
    }

    public function show($id)
    {
        $blog = Blog::with(['author', 'comments'])->whereId($id)->first();

        if (!$blog) return $this->notfound(['message' => 'Blog not found']);

        return $this->success(['blog' => $blog], 200);
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
            'tags' => 'array'
        ]);

        if ($validate->fails()) return $this->validateRes($validate->errors());

        $findToken = PersonalAccessToken::findToken($request->bearerToken());
        $user = $findToken->tokenable;

        $extension = $request->file('image')->getClientOriginalExtension();
        $image = time() . '.' . $extension;
        $path = 'public/blogs';

        $request->file('image')->storeAs(
            $path,
            $image
        );

        $blog = Blog::create([
            'title' => $request->title,
            'image' => 'storage/blogs/' . $image,
            'description' => $request->description,
            'author_id' => $request->author,
        ]);

        if ($request->tags) {
            foreach ($request->tags as $tag) {
                $tag['tag_id'] = $tag;
                $tag['blog_id'] = $blog->id;

                BlogTag::create($tag);
            }
        }


        return $this->success(['message' => 'Blog successfully created'], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $blog = Blog::find($id);

        if (!$blog) return $this->notfound(['message' => 'Blog not found']);

        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'image' => 'required|image',
            'description' => 'required',
            'status' => 'boolean'
        ]);

        if ($validate->fails()) return $this->validateRes($validate->errors());

        $bannerImg = $blog->image;

        if ($request->hasFile('image')) {
            $path = str_replace('storage/', '', $blog->image);
            Storage::delete('public/' . $path);


            $extension = $request->file('image')->getClientOriginalExtension();
            $image = time() . '.' . $extension;
            $path = 'public/blog';

            $request->file('image')->storeAs(
                $path,
                $image
            );

            $bannerImg = 'storage/blogs/' . $image;
        }

        foreach ($blog->tags as $tag) {
            $tag->delete();
        }

        foreach ($request->tags as $tag) {
            $tag['tag_id'] = $tag;
            $tag['blog_id'] = $blog->id;

            BlogTag::create($tag);
        }

        $blog->update([
            'title' => $request->title,
            'image' => $bannerImg,
            'description' => $request->description,
            'author_id' => $request->author,
        ]);

        return $this->success(['message' => 'Blog successfully updated'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::find($id);

        if (!$blog) return $this->notfound(['message' => 'Blog not found']);

        if ($blog->tags) {
            foreach ($blog->tags as $tag) {
                $tag->delete();
            }
        }

        $path = str_replace('storage/', '', $blog->image);
        Storage::delete('public/' . $path);


        $blog->delete();

        return $this->success([], 204);
    }
}
