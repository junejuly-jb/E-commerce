<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ApiController extends Controller
{
    public function register(Request $request){
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required',
            'password' => 'required|min:6'
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $user->save();

        return response()->json([
            'data' => $user,
            'message' => 'User added successfully'
        ]);
    }

    public function login(Request $request){
        $pass_phrase = "VirginiaFoodsIncorporated";

        if(auth()->attempt($request->all())){
            $token = auth()->user()->createToken($pass_phrase);
            $usertype = auth()->user()->usertype;

            return response()->json([
                'message' => 'User logged in!',
                'token' => $token,
                'user' => auth()->user()
            ]);
        }
        else{
            return response()->json([
                'message' => 'fail'
            ]);
        }
    }
}
