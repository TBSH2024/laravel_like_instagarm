<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    protected $fillable = ['post_id', 'url'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function saveImage($image, int $postId): PostImage
    {
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);

        $postImage = new PostImage();
        $postImage->post_id = $postId;
        $postImage->url = 'images/' . $imageName;
        $postImage->save();
        return $postImage;
    }
}
