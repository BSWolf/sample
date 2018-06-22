<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

class SessionsController extends Controller
{
    public function create(){

        return view('sessions.create');
    }

    public function store(Request $request){

        $credentails = $this->validate($request,[

            'email' => 'required|email|max:255',
            'password' => 'required'

            ]);

        if(Auth::attempt($credentails)){

            session()->flash('success','欢迎回来!');
            return redirect()->route('user.show',[Auth::user()]);

        }else{

            session()->flash('danger','对不起，您的邮箱和密码不匹配！');
            return redirect()->back();
        }
    }
}
