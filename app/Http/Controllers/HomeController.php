<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\User;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $post;
    private $user;

    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    # Get all the posts if the users the AUTH USER is following
    private function getHomePosts(){
        $all_posts = $this->post->latest()->get();
        $home_posts = []; // this array will hold the posts (of the users being followed and the post of the currently logged-in users) in the homepage

        foreach($all_posts as $post) {
            if($post->user->isFollowed() || $post->user->id === Auth::user()->id) {
                $home_posts[] = $post;
            }
        }
        return $home_posts;
    }

    private function getSuggestedUsers(){

        $all_users = $this->user->all()->except(Auth::user()->id);
        $suggested_users = []; // a container that will hold every users

        foreach ($all_users as $user) {
            if(!$user->isFollowed()){
                $suggested_users[] = $user;
                # the data inside the array ($suggested_users) only contain
                # the users that are not yet being followed by the Logged_in user
            }
        }
        // return $suggested_users;
        return array_slice($suggested_users, 0, 5);
        # $suggested_users[0,1,2,3,4,5,6,7,8];
        # $suggested_users[0] =



        # array_slice(x,y,z)
        # x: name of the array
        # y: offset|starting index
        # z: number or length or how many
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $all_posts = $this->post->latest()->get();
        # Same as : SELECT * FROM posts ORDERD BY created_at DESC
        // return view('users.home')->with('all_posts', $all_posts);

        $home_posts = $this->getHomePosts();
        $suggested_users = $this->getSuggestedUsers();
        return view('users.home')
            ->with('home_posts', $home_posts)
            ->with('suggested_users', $suggested_users);
    }

    public function search(Request $request){
        $users = $this->user->where('name', 'like', '%'. $request->search .'%')->get();
        return view('users.search')->with('users', $users)->with('search', $request->search);

        // the '%' is like a wild card --> example
        /**
         * Mary, Maryjane, Danemary
         * in our search bar: mary , we will find above 3 mary
         * It doesn't matter upper lower
         */
        // We need create search.blade.php
    }
}
