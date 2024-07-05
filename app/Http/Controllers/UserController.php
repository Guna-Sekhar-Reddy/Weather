<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
class UserController extends Controller
{
    public function login(Request $request){
        $incomingFields=$request->validate([
            "loginname"=> "required",
            "loginpassword"=>'required'
        ]) ;
        if(auth()->attempt(['name'=>$incomingFields['loginname'],'password'=>$incomingFields['loginpassword']])){
            $request->session()->regenerate();                                                //generate session and cookie
        }
        return redirect('/');
    }
    public function logout(){
        auth()->logout();
        return redirect('/');
    }
    public function register(Request $request){
        $incomingFields=$request->validate([
            'name'=>['required' , 'min:3', 'max:10', Rule::unique('users','name')], //for name field to be unique  in users table 
            'email'=> ['required','email', Rule::unique('users','email')],
            'password'=>['required','min:8','max:200']
        ]);

        $incomingFields['password']=bcrypt($incomingFields['password']);
        $user=User::create($incomingFields);               //storing in data base
        auth()->login($user);
        return redirect('/');                                //redirecting to home
    
}
}