<?php

namespace App\Http\Controllers;
use App\Models\NotificationsReschedule;
use App\Models\ApplicantReschedule;
use Illuminate\Http\Request;

class RescheduleController extends Controller
{
    public function index()
    {
        $reschedule = NotificationsReschedule::with('applications')->where('created_at', 'like', now()->format("Y-m-d").'%')->orderBy('created_at', 'desc')->get();

        return view('pages.reschedule.index', compact('reschedule'));
    }

    public function notifications(Request $request)
    {
        if($request->get('id'))
            $query = NotificationsReschedule::where('id', '>=', $request->get('id'));
        else
            $query = NotificationsReschedule::all();

        $data = $query;
        return response()->json($data);
    }
}
