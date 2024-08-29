<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class BlogCommentsController extends Controller
{
    public function index(Request $request, $blog_id)
    {
        $blog = Blog::with('comments')->find($blog_id);

        return $this->success(['comments' => $blog->comments], 200);
    }

    public function store(Request $request, $blog_id)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'website' => 'required',
            'comment' => 'required',
        ]);

        if ($validate->fails()) return $this->validateRes($validate->errors());

        $findToken = PersonalAccessToken::findToken($request->bearerToken());
        $user = $findToken->tokenable;

        $request['blog_id'] =  $blog_id;
        $request['user_id'] =  $user->id;

        BlogComment::create($request->all());
    }

    public function update(Request $request, $blog_id, $id)
    {
        $comment = BlogComment::find($id);

        if (!$comment) return $this->notfound(['message' => 'Comment not found']);

        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'website' => 'required',
            'comment' => 'required',
        ]);

        if ($validate->fails()) return $this->validateRes($validate->errors());

        $findToken = PersonalAccessToken::findToken($request->bearerToken());
        $user = $findToken->tokenable;

        if ($user->id !== $comment->user_id) return $this->forbidden();

        // $request['blog_id'] =  $blog_id;
        // $request['user_id'] =  $user->id;

        $comment->update($request->all());
    }
}
