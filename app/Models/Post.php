<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    # A post belongs to a user
    #Use this method to get the owner of the post
    public function user() {
        return $this->belongsTo(User::class)->withTrashed();
    }

    # To get the categories under the post
    public function categoryPost() {
        return $this->hasMany(categoryPost::class);
    }

    # Use this method to get all the comments under a post
    public function comments() {
        return $this->hasMany(comment::class)->withTrashed();;
    }

    # Use this method to get the Likes of a post
    public function likes(){
        return $this->hasMany(Like::class);
    }

    # Check if the post been liked
    # Return TRUE if the AUTH user already liked the post
    public function isLiked() {
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
    }

    #### Collaborative project
    public function favorite(){
        return $this->hasMany(Favorite::class);
    }
    public function befavorite() {
        return $this->favorite()->where('user_id', Auth::user()->id)->exists();
    }

}
