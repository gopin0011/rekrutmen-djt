<?php

namespace App\Http\Controllers;

use App\Models\Director;
use Illuminate\Http\Request;

class DirectorController extends Controller
{
    public function edit()
    {
        $data = Director::find(1);
        return view('pages.director.index', compact('data'));
    }

    public function store(Request $request)
    {
        Director::find(1)->update(['name' => $request->name]);
        return redirect(route('director.edit'));
    }
}
