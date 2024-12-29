<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CreatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_id = $request->id;
        $posts = Post::all();
        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request)
    {
        $post = new Post;
        $result = $post->createPost($request);

        // postImagesテーブルに画像を保存
        if ($request->file('images') > 0) {
            $postImageController = new PostImageController();
            $postImageController->store($request, $result->id);
        }
        return redirect()->route('posts.index')->with([
            'type' => 'success',
            'message' => '投稿を作成しました',
        ]);;
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $post = Post::findOrFail($id);

        Gate::authorize('update', $post); // policyの適用

        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        $postId = $request->input('id');

        try {
        // データの存在有無を確認
        Post::findOrFail($postId);

        $post = new Post;
        $result = $post->updatePost($request->all(), $postId);

        if ($request->file('images') > 0) {
            $postImageController = new PostImageController();
            $postImageController->update($request, $result->id);
        }
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());
            return abort(404);
        }

        return redirect()->route('post.show', ['post' => $postId])
        ->with([
            'type' => 'success',
            'message' => '投稿を更新しました',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $post = new Post();
        $result = $post->deletePost($id);
        return redirect()->route('posts.index')->with([
            'type' => 'danger',
            'message' => '投稿を削除しました',
        ]);
    }
}
