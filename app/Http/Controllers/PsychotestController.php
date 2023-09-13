<?php

namespace App\Http\Controllers;

use App\Models\Psychotest;
use Illuminate\Http\Request;

class PsychotestController extends Controller
{
    public function index($id)
    {
        $data = Psychotest::where('user_id',$id)->first();
        return view('pages.psychotest.index', compact('data','id'));
    }

    public function store(Request $request)
    {
        Psychotest::updateOrCreate(
            ['id' => $request->data_id],
            [
                'user_id' => $request->user_id,
                'disctest' => $request->disctest,
                'ist' => $request->ist,
                'cfit' => $request->cfit,
                'armyalpha' => $request->armyalpha,
                'papikostik' => $request->papikostik,
                'kreplin' => $request->kreplin,
            ]
        );
        return redirect(route('applications.today'));
    }
}
