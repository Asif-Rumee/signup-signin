<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attempt;
use Hash;
use Session;
use Carbon\Carbon;


class AuthController extends Controller
{
    public function loginView(){
        return view('auth.login');
    }

    public function registerView(){
        return view('auth.register');
    }

    public function register(Request $request){
        $request->validate([
            'name'=>'required',
            'emailOrMobile'=>'required|unique:users',
            'password'=>'required|confirmed'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->emailOrMobile = $request->emailOrMobile;
        $user->password = Hash::make($request->password);
        $res = $user->save();
        if($res){
            return back()->with('success','You have registered successfully.');
        }else{
            return back()->with('fail','Something went wrong.');
        }
    }

    public function login(Request $request){
        $request->validate([
            'emailOrMobile'=>'required',
            'password'=>'required'
        ]);

        $user = User::where('emailOrMobile', '=', $request->emailOrMobile)->first();
        $attempt = Attempt::where('user_id', '=', $user->id)->first();
        // if($attempt){
        //     $attemptTime = Carbon::parse($attempt->last_attempt_time)->addMinutes(3);
        //     if($attemptTime > now()){
        //         return back()->with('fail','You have reached the limit, please try later.');
        //     }
        // }
        if($user){
            if(Hash::check($request->password, $user->password)){
                $attempt = Attempt::where('user_id', '=', $user->id)->first();
                if($attempt){
                    $attempt->count = 0;
                    $attempt->last_attempt_time	= now();
                    $attempt->save();
                }else{
                    $attempt = new Attempt();
                    $attempt->user_id = $user->id;
                    $attempt->count = 0;
                    $attempt->last_attempt_time	= now();
                    $attempt->save();
                }
                $request->session()->put('loginId', $user->id);
                return redirect('dashboard');
            }else{
                $attempt = Attempt::where('user_id', '=', $user->id)->first();
                if($attempt){
                    if($attempt->count == 3){
                        return back()->with('fail','You have reached the limit, please try later.');
                    }else{
                        $attempt->count += 1;
                        $attempt->last_attempt_time	= now();
                        $attempt->save();
                    }
                }else{
                    $attempt = new Attempt();
                    $attempt->user_id = $user->id;
                    $attempt->count = 1;
                    $attempt->last_attempt_time	= now();
                    $attempt->save();
                }
                return back()->with('fail','The password not matches.');
            }
        }else{
            return back()->with('fail','This email or mobile number is not registered.');
        }
    }

    public function dashboard(){
        if(Session::has('loginId')){
            $data = User::where('id', '=', Session::get('loginId'))->first(); 
        }
        return view('dashboard', compact('data'));
    }

    public function logout(){
        if(Session::has('loginId')){
            Session::pull('loginId');
            return redirect('login');
        }
    }

    public function checkEmail(Request $request) {
        $emailOrMobile = $request->input('emailOrMobile');
        $user = User::where('emailOrMobile', $emailOrMobile)->first();
        if ($user) {
            return 'exists';
        } else {
            return 'not_exists';
        }
    }
}
