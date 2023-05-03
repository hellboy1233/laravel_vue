<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class usercontroller extends Controller
{
    public function index(){
        $users = User::all();
        
        return response()->json($users);
    }  
    public function add(Request $request){
        request()->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required|min(8)'
        ]);
        
        return User::create([
            'name'=>$request->post('name'),
            'email'=>$request->post('email'),
            'password'=>$request->post('password'),
        ]);
        
        
        
    }  
    public function update(Request $request){
        $user=User::find($request->post('id'));
        $user->name=$request->post('name');
        $user->email=$request->post('email');
        $user->password=$request->post('password');
        $user->save();
       echo "updated";
    }  
    public function delete($id){
        $user=User::find($id);
        $user->delete();
        
        echo "deleted";
    }
}
?>