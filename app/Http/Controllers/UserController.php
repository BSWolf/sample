<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Auth;

class UserController extends Controller
{
    //用户注册
    public function create(){
        return view('users.create');
    }

    public function show(User $user){
        return view('users.show',compact('user'));
    }

    /**
     * 注册
     */
    public function store(Request $request){
        $this->validate($request,[
            'name'=>'required|max:50',
            'email'=>'required|email|unique:users|max:255',
            'password'=>'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);

        Auth::login($user);
        session()->flash('success','恭喜您，注册成功！');
        return redirect(route('user.show',[$user]));
    }

    /**
     * 编辑个人资料初始化
     */
    public function edit(User $user){

        return view('users.edit',compact('user'));
    }

    /**
     * 修改资料
     */
    public function update(User $user,Request $request){

        $this->validate($request,[
            'name'=>'required|max:50',
            'password'=>'nullable|confirmed|min:6:'
        ]);

        $data = [];
        $data['name'] = $request->name;

        if ($request->password){
            $data['password'] = bcrypt($request->password);
        }

        $user ->update($data);
        session()->flash('success','资料修改成功!');

        return redirect()->route('user.show',$user->id);
    }
}
