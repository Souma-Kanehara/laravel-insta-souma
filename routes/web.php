<?php

# Regular users controller
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;

# Admin user controller
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\CategoriesController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Auth::routes();

# we have to protect our routes -- we will use the class called ['middleware' => 'auth']
# The 'auth' - authentication
Route::group(['middleware' => 'auth'], function(){
    # Route for homepage
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/people', [HomeController::class, 'search'])->name('search');
    # Open create post form
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    # Save/Insert post details to database tables
    Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
    # Open show post page
    Route::get('/post/{id}/show', [PostController::class, 'show'])->name('post.show');
    # Open edit page
    Route::get('/post/{id}/edit', [PostController::class, 'edit'])->name('post.edit');
    # Update the post record
    Route::patch('/post/{id}/update',[PostController::class, 'update'])->name('post.update');
    # Route for deleteing the post
    Route::delete('/post/{id}/destoy', [PostController::class, 'destroy'])->name('post.destroy');




    # Comments
    Route::post('/comment/{post_id}/store', [CommentController::class, 'store'])->name('comment.store');
    # Delete comment
    Route::delete('/comment/{id}/destroy',[CommentController::class, 'destroy'])->name('comment.destroy');



    # Profile section
    Route::get('/profile/{id}/show', [ProfileController::class, 'show'])->name('profile.show');
    # Edit Profile
    Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    # Update the user profile
    // Route::patch('/profile/{id}/update',[ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile//update',[ProfileController::class, 'update'])->name('profile.update');
    # followers
    Route::get('/profile/{id}/followers', [ProfileController::class, 'followers'])->name('profile.followers');
    Route::get('/profile/{id}/following', [ProfileController::class, 'following'])->name('profile.following');



    # Like section
    Route::post('/like/{post_id}/store',[LikeController::class, 'store'])->name('like.store');
    Route::delete('/like/{post_id}/destroy',[LikeController::class, 'destroy'])->name('like.destroy');



    # Follow section
    Route::post('/follow/{user_id}/store', [FollowController::class, 'store'])->name('follow.store');
    Route::delete('/follow/{user_id}/destroy',[FollowController::class, 'destroy'])->name('follow.destroy');



    #### Admin Section ####
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function(){
        /**
         * 'middleware' => 'admin'のadminはKernel.phpのmiddleware aliases.から来てる
         */
        // User
        Route::get('/users', [UsersController::class, 'index'])->name('users'); // admin.users
        Route::delete('/users/{id}/deactivate',[UsersController::class, 'deactivate'])->name('users.deactivate'); // admin.users.deactivate
        Route::patch('/users/{id}/activate', [UsersController::class, 'activate'])->name('users.activate'); // admin.users.activate

        // Posts
        Route::get('/posts',[PostsController::class, 'index'])->name('posts');
        Route::delete('/posts/{id}/hide',[PostsController::class, 'hide'])->name('posts.hide');
        Route::patch('/posts/{id}/unhide',[PostsController::class, 'unhide'])->name('posts.unhide');

        // Categories
        Route::get('/categories',[CategoriesController::class, 'index'])->name('categories');
        Route::post('/categories/store',[CategoriesController::class, 'store'])->name('categories.store');
        Route::patch('/categories/{id}/update',[CategoriesController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}/destroy',[CategoriesController::class, 'destroy'])->name('categories.destroy');
    });
});

