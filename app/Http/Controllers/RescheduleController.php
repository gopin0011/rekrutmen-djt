<?php

namespace App\Http\Controllers;
use App\Models\NotificationsReschedule;
use App\Models\ApplicantReschedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        if($request->get('notifiable_id')) {
            $query = auth()->user()->unreadNotifications()
                ->where('type', 'App\Models\NotificationsReschedule')
                ->where('notifiable_id', '>', $request->get('notifiable_id'))
                ->whereDate('created_at', Carbon::today())
                ->get();
        }
        else {
            $query = auth()->user()->notifications()
                ->where('type', 'App\Models\NotificationsReschedule')
                ->whereDate('created_at', Carbon::today())
                ->get();
        }
        $data = $query;
        return response()->json($data);
    }
}
