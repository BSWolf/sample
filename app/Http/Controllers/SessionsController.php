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

    //用户登录
    public function store(Request $request){

        $credentails = $this->validate($request,[

            'email' => 'required|email|max:255',
            'password' => 'required'

            ]);

        if(Auth::attempt($credentails,$request->has('remember'))){

            session()->flash('success','欢迎回来!');
            return redirect()->route('user.show',[Auth::user()]);

        }else{

            session()->flash('danger','对不起，您的邮箱和密码不匹配！');
            return redirect()->back();
        }
    }

    //用户退出
    public function destory(){

        Auth::logout();
        session()->flash('success','登出成功！');
        return redirect('login');

    }
}
