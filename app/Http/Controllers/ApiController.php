<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;
use App\Models\Todo;
use App\Models\Logs;
use Illuminate\Support\Facades\DB;

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

    public function deactivateUser(Request $request, $id){
        $user = User::find($id);

        $user->status = $request->status;
        $user->save();
        
        return response()->json([
            'message' => 'User deactivated'
        ]);
    }
    public function activateUser(Request $request, $id){
        $user = User::find($id);
        $user->status = $request->status;
        $user->save();
        return response()->json([
            'message' => 'User activated'
        ]);
    }
    public function profile(){
        $user = auth()->user();
        return response()->json($user);
    }

    public function storeRegistration(Request $request){
        $user = User::find($request->id);
        $user->contact = $request->contact;
        $user->address = $request->address;
        $user->gender = $request->gender;
        $user->birthday = $request->birthday;
        $user->save();

        $store = new Store([
            'store_name' => $request->storeName,
            'store_owner' => $request->id,
            'store_address' => $request->storeAddress,
            'store_website' => $request->storeWebsite,
            'store_description' => $request->storeDescription,
            'store_status' => 'pending',
        ]);
        $store->save();
        return response()->json([
            'message' => 'Success!'
        ], 200);
    }

    public function checkIfExists($id){
        // $user = Store::where('store_owner', '=', $id)->get();

        // if($user == null){
        //     return response()->json([
        //         'message' => 'not found',
        //     ]);
        // }
        // else{
        //     return response()->json([
        //         'message' => 'exists',
        //     ]);
        // }
        if(Store::where('store_owner', '=', $id)->exists()){
            return response()->json([
                'message' => 'exists',
            ]);
        }
        else{
            return response()->json([
                'message' => 'not found',
            ]);
        }
    }

    public function getAllStores(){
        $sql = "SELECT * FROM stores JOIN users on stores.store_owner = users.id WHERE store_status = 'pending'";
        $stores = DB::select($sql);
        return response()->json([
            'data' => $stores
        ]);
    }
    public function grant(Request $request){
        $store = Store::find($request->store_id);
        $store->store_status = 'active';
        $store->save();

        $user = User::find($request->id);
        $user->usertype = 'seller';
        $user->save();

        $log = new Logs([
            'admin_id' => auth()->user()->id,
            'log' => "You accepted ".$user->name."`s Store"
        ]);
        $log->save();

        return response()->json([
            'message' => 'Store granted successfully'
        ], 200);
    }

    public function getTotal(){
        $users = User::where('usertype', '=', 'user')->count();
        $sellers = User::where('usertype', '=', 'seller')->count();
        $stores = Store::where('store_status', '=', 'active')->count();

        return response()->json([
            'users' => $users,
            'sellers' => $sellers,
            'stores' => $stores
        ]);
    }
    public function getTodos(){
        $userId = auth()->user()->id;
        $todos = Todo::where('admin_id', '=', $userId)->get();
        return response()->json([
            'data' => $todos
        ]);
    }

    public function addTodo(Request $request){
        $userId = auth()->user()->id;
        $todo = new Todo([
            'todo' => $request->todo,
            'status' => 'incomplete',
            'admin_id' => $userId,
        ]);
        $todo->save(); 
        return response()->json([
            'message' => 'Todo added ✔',
            'data' => $todo
        ]);
    }

    public function deleteTodo($id){
        $todo = Todo::find($id);
        $todo->delete();

        return response()->json([
            'message' => 'Todo deleted successfully'
        ]);
    }
    
    public function updateTodo($id, Request $request){
        $todo = Todo::find($id);
        $todo->todo = $request->todo;
        $todo->save();
        return response()->json([
            'message' => 'Todo updated successfully',
            'data' => $todo
        ]);
    }

    public function mark(Request $request, $id){
        $todo = Todo::find($id);

        if($request->status == 'incomplete'){   
            $todo->status = 'complete';
            $todo->save();
            return response()->json([
                'message' => 'Marked as complete',
                'data' => $todo
            ]);
        }
        else{
            $todo->status = 'incomplete';
            $todo->save();
            return response()->json([
                'message' => 'Marked as incomplete',
                'data' => $todo
            ]);
        }
    }
}
