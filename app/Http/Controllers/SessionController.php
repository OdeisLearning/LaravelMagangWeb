<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    function index(){
        return view('Login');
    }
    function login(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ],[
            'email.required'=>'Email wajib Diisi',
            'password.required'=>'Password wajib Diisi',
        ]);

        $infoLogin=[
            'email'=>$request->email,
            'password'=>$request->password,
        ];
        if(Auth::attempt($infoLogin)){
            return redirect('Welcome');
        }else{
            return redirect('')->withErrors('Email atau Password Salah')->withInput();
        }
    }
    function logout(){
        Auth::logout();
        return redirect('');
    }
}
