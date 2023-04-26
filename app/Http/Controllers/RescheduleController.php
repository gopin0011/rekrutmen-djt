<?php

namespace App\Http\Controllers;
use App\Models\NotificationsReschedule;
use App\Models\ApplicantReschedule;
use Illuminate\Http\Request;

class RescheduleController extends Controller
{
    public function index()
    {
        $reschedule = auth()->user()->notifications()->whereType('App\Models\NotificationsReschedule')->where('created_at', 'like', now()->format("Y-m-d").'%')->get();
        // $reschedule = NotificationsReschedule::with('applications')->where('created_at', 'like', now()->format("Y-m-d").'%')->orderBy('created_at', 'desc')->get();

        return view('pages.reschedule.index', compact('reschedule'));
    }

    public function notifications(Request $request)
    {
        if($request->get('id')) {
            $query = auth()->user()->notifications()->whereType('App\Models\NotificationsReschedule')->where('created_at', 'like', now()->format("Y-m-d").'%')->get();
            // $query = NotificationsReschedule::where('id', '>=', $request->get('id'))->where('created_at', 'like', now()->format("Y-m-d").'%')->orderBy('created_at', 'desc')->get();
        }
        else
            $query = NotificationsReschedule::where('created_at', 'like', now()->format("Y-m-d").'%')->orderBy('created_at', 'desc')->get();

        $data = $query;
        return response()->json($data);
    }
}
