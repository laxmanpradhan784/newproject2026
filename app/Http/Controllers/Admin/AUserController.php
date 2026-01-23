<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AUserController extends Controller
{
    public function index()
    {
        $users = User::where('role','user')->orderBy('id','desc')->get();
        return view('admin.users', compact('users'));
    }

    public function delete($id)
    {
        User::find($id)->delete();
        return back()->with('success','User Deleted');
    }
}
