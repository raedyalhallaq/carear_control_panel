<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permissions;
use App\User;
use Illuminate\Http\Request;

class PermssionController extends Controller
{
    public function index(){
        $users = User::select('name','id','email')->get();
        return view('admin.permissions.index',compact('users'));
    }
    public function getPermission($id){
        $user =User::findOrFail($id)->getAllPermissions()->toArray();
        return \response()->json(['data'=>$user]);
    }

    public function setPermission(Request $request){

       $user = auth()->user();
        $user->syncPermissions();
        $permissions = $request->input('permisssions');
        foreach ($permissions as $permission ){
          $user->givePermissionTo($permission);
        }
    }
    public function rules(){
        return["name" =>'required',"email" =>'required|email',"password" =>'required'];
    }
    public function delete($id){
        $user = User::findOrFail($id);
        $user->delete();
        return \response()->json([]);
    }
}
