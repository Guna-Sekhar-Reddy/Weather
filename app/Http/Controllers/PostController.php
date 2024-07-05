<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
class PostController extends Controller
{
    public function deletePost(Post $post){
        if(auth()->user()->id===$post['user_id']){      //author only allowed to delete the post
            $post->delete();                            
        }

        return redirect('/');
    }
    public function actuallyUpdatePost(Post $post,Request $request){            //post-> the data needed to update , request -> the form which contains updated data
         if(auth()->user()->id!==$post['user_id']){             //if not author of post, then go to home 
            return redirect('/');
        }
        $incomingFields=$request->validate([
            'title'=>'required',
            'body'=>'required'
        ]);
        $incomingFields['title']=strip_tags($incomingFields['title']);
        $incomingFields['body']=strip_tags($incomingFields['body']);
        $post->update($incomingFields);
        return redirect('/');
    }
    public function showEditScreen(Post $post){
        if(auth()->user()->id!==$post['user_id']){
            return redirect('/');
        }
        return view('edit-post',['post'=>$post]);                                //edit-post is the blade template
    }
    public function createPost(Request $request) {
        $incomingFields=$request->validate([
            'title'=>'required',
            'body'=> 'required',
        ]);

        $incomingFields['title']=strip_tags($incomingFields['title']);
        $incomingFields['body']=strip_tags($incomingFields['body']);
        $incomingFields['user_id']=auth()->id();
        Post::create($incomingFields);
        return redirect('/');
    }
}
