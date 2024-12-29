<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Requests\CreatePostRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function postImages()
    {
        return $this->hasMany(postImage::class);
    }

    public function createPost(CreatePostRequest $data): Post
    {
        // データベースに保存
        $user = Auth::user();

        $post = new Post;
        $post->user_id = $user->id;
        $post->title = $data['title'];
        $post->body = $data['body'];
        $post->save();
        return $post;
    }

    public function updatePost($data, int $id): Post
    {
        $post = Post::find($id);

        Gate::authorize('update', $post); // policyの適用
        
        $post->title = $data['title'];
        $post->body = $data['body'];
        $post->save();
        return $post;
    }

    public function deletePost($id): Post
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return $post;
    }
}
