<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;
use App\Models\Todo;
use App\Models\Logs;
use App\Models\Item;
use App\Models\Setting;
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
        $setting = new Setting([
            'user_id' => $user->id,
            'welcomeAsSeller' => 0,
            'adBanner' => 1,
        ]);
        $setting->save();
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
                $setting = Setting::where('user_id', '=', auth()->user()->id)->first();

                return response()->json([
                    'message' => 'User logged in!',
                    'token' => $token,
                    'setting' => $setting,
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

        if($user->address != null && $user->contact != null && $user->gender != null && $user->birthday != null){
            $store = new Store([
                'store_name' => $request->storeName,
                'store_owner' => $request->id,
                'store_address' => $request->storeAddress,
                'store_website' => $request->storeWebsite,
                'store_description' => $request->storeDescription,
                'store_status' => 'pending',
            ]);
            $store->save();
        }
        else{   
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
        }   
       
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
    public function getActiveStores(){
        $sql = "SELECT * FROM stores JOIN users ON stores.store_owner = users.id WHERE store_status = 'active' OR store_status = 'banned'";
        $stores = DB::select($sql);
        return response()->json([
            'data' => $stores
        ]);
    }
    public function discard($id){
        $store = Store::find($id);
        $store->delete();
        return response()->json([
            'message' => 'Store discarded'
        ]);
    }

    public function addItem(Request $req){
        $item = new Item([
            'seller_id' => $req->id,
            'item_name' => $req->item_name,
            'category' => $req->category,
            'item_price' => $req->item_price,
            'item_quantity' => $req->item_quantity,
            'item_desc' => $req->item_desc,
            'status' => 'in-stock'
        ]);

        $item->save();
    }

    public function saveItem(Request $request) {
        $storeId = Store::where('store_owner', '=', auth()->user()->id)->first();
        // if($request->item_quantity > 0){
        $item = new Item([
            'item_name' => $request->item_name,
            'store_id' => $storeId->store_id,
            'category' => $request->category,
            'item_price' => $request->item_price,
            'item_quantity' => $request->item_quantity,
            'item_desc' => $request->item_desc,
            'item_status' => 'available'
        ]);
        $item->save();
        return response()->json([
            'message' => 'Item Added successfully',
            'data' => $item 
        ]);
    
    }
    public function items(){
        $store = Store::where('store_owner', '=', auth()->user()->id)->first();
        $items = Item::where('store_id', '=', $store->store_id)->get();

        return response()->json([
            'data' => $items
        ]);
    }

    public function deleteItem($id) {
        $item = Item::find($id);
        $item->delete();

        return response()->json([
            'message' => 'Item deleted successfully'
        ]);
    }

    public function updateItem($id, Request $req){

        if($req->item_quantity < 0){
            $item = Item::find($id);
            $item->item_name = $req->item_name;
            $item->category = $req->category;
            $item->item_price = $req->item_price;
            $item->item_quantity = '0';
            $item->item_desc = $req->item_desc;
            $item->item_status = 'out of stock';
            $item->save();

            return response()->json([
                'message' => 'Item updated successfully',
                'data' => $item,
            ]);
        }
        $item = Item::find($id);
        $item->item_name = $req->item_name;
        $item->category = $req->category;
        $item->item_price = $req->item_price;
        $item->item_quantity = $req->item_quantity;
        $item->item_desc = $req->item_desc;
        $item->item_status = 'available';
        $item->save();

        return response()->json([
            'message' => 'Item updated successfully',
            'data' => $item,
        ]);
    }

    public function dismissAd(){
        $setting = Setting::where('user_id', '=', auth()->user()->id)->first();
        $setting->adBanner = 0;
        $setting->save();
        return response()->json([
            'data' => $setting
        ]);
    }

    public function updateAd(Request $req){
        // return response()->json($setting)
        $userSetting = Setting::where('user_id', '=', auth()->user()->id)->first();
        $userSetting->adBanner = 0;
        $userSetting->save();
        // $userSetting->adBanner = 0;
        return response()->json([
            'data' => $userSetting
        ]);

    }
}
