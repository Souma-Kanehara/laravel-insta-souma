<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;

class FavoriteController extends Controller
{
    private $favorite;
    private $post;
    private $user;

    public function __construct(Post $post, User $user, Favorite $favorite)
    {
        $this->post = $post;
        $this->user = $user;
        $this->favorite = $favorite;
    }

    public function store($post_id) {
        $this->favorite->user_id = Auth::user()->id;
        $this->favorite->post_id = $post_id;
        $this->favorite->save();

        return redirect()->back();
    }
    public function destroy($post_id){
        $this->favorite
            ->where('user_id', Auth::user()->id)
            ->where('post_id', $post_id)
            ->delete();

        return redirect()->back();
    }

    // まりかさんのfunction
    public function showFavorites($id)
    {
        $user = $this->user->findOrFail($id);
        $user_favorites= $user->favorites;
        // $users_collections = $this->user->findOrFail($id);
        return view('users.profile.favorites')
                ->with('user', $user)
                ->with('user_favorites', $user_favorites);
    }
}
