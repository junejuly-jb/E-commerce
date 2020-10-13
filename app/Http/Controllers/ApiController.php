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
            if(auth()->user()->status == 'active'){
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
                    'message' => 'inactive'
                ]);
            }
            
        }
        else{
            return response()->json([
                'message' => 'fail'
            ]);
        }
    }

    public function updateMe(Request $request){
        $user = User::find($request->id);

        $user->name = $request->name;
        $user->contact = $request->contact;
        $user->address = $request->address;

        $user->save();
        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }

    public function getAllUsers(){
        $user = User::where('usertype', '=', 'user')->orWhere('usertype', '=', 'seller')->get();
        return response()->json($user);
    }

    public function deactivateUser(Request $request){
        $user = User::find($request->id);

        $user->status = $request->status;
        $user->save();
        
        return response()->json([
            'message' => 'User deactivated'
        ]);
    }
}
