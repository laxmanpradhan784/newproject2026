<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class AContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('id','desc')->get();
        return view('admin.contacts', compact('contacts'));
    }

    public function delete($id)
    {
        Contact::find($id)->delete();
        return back()->with('success','Message Deleted');
    }
}
