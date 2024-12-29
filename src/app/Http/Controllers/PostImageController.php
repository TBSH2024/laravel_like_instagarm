<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Support\Facades\DB;

class PostImageController extends Controller
{
    public function store(Request $request, int $postId)
    {
        $request->validate([
            'images.*' => 'required|file|image|mimes:jpeg,png,jpg,gif',
        ]);

        $post = Post::findOrFail($postId);

        $postImage = new PostImage();

        $images = $request->file('images');

        foreach ($images as $image) {
            $postImage->saveImage($image, $postId);
        }

        return redirect()->route('posts.index');
    }

    public function update(Request $request, int $postId)
    {
        $request->validate([
            'images.*' => 'required|file|image|mimes:jpeg,png,jpg,gif',
        ]);

        $post = Post::findOrFail($postId);
        DB::transaction(function () use ($request, $post) {
            $postImage = new PostImage();
            $postImage->where('post_id', $post->id)->delete();
            $images = $request->file('images');
            foreach ($images as $image) {
                $postImage->saveImage($image, $post->id);
            }
        });

        return redirect()->route('posts.index');
    }

}
