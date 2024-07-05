<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Models\Post;

Route::get('/', function () {
   // $posts=Post::all();       //this is to get all posts
  // $posts=Post::where('user_id',auth()->id())->get();                   //gives current user
   $posts=[];

   if(auth()->check()){                                                                  
       $posts=auth()->user()->usersCoolPosts()->latest()->get();
   }
    return view('home',['posts'=>$posts]);
});

Route::post('/register',[UserController::class, 'register']); // first arg is url , second contains class and function 

Route::post('/logout',[UserController::class,'logout']);

Route::post('/login',[UserController::class,'login']);

//Blog post related routes
Route::post('/create-post',[PostController::class,'createPost']);

Route::get('/edit-post/{post}',[PostController::class,'showEditScreen']);

Route::put('/edit-post/{post}',[PostController::class,'actuallyUpdatePost']);           //updating

Route::delete('/delete-post/{post}',[PostController::class,'deletePost']);