<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\User;
use App\Models\Career;
use App\Models\Competency;
use App\Models\Family;
use App\Models\Language;
use App\Models\Profile;
use App\Models\Question;
use App\Models\Reference;
use App\Models\Social;
use App\Models\Study;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class PrintContoller extends Controller
{
    public function applicant($id)
    {
        $data = Application::find($id);
        try
        {
            if($data->user_id == Auth::user()->id)
            {
                $userid = $data->user_id;
                
                $application = Application::where('id', $id)->get();
                $user = User::where('id', $userid)->get();
                $profile = Profile::where('user_id', $userid)->get();
                $family = Family::where('user_id', $userid)->get();
                $study = Study::where('user_id', $userid)->get();
                $training = Training::where('user_id', $userid)->get();
                $language = Language::where('user_id', $userid)->get();
                $social = Social::where('user_id', $userid)->get();
                $reference = Reference::where('user_id', $userid)->get();
                $career = Career::where('user_id', $userid)->get();
                $question = Question::where('user_id', $userid)->get();

                $pdf = PDF::loadView('print.applicant', compact('application','user','profile','family','study','training','language','social','reference','career','question'))->setPaper('a4', 'potrait');
                return $pdf->stream();
            }
            else{
                
            }
        }
        catch (\Exception $e)
        {
            
        }
    }

    public function applicantdev($id)
    {
        $data = Application::find($id);
        try
        {
            if(Auth::user()->admin != '0')
            {
                $userid = $data->user_id;
                
                $application = Application::where('id', $id)->get();
                $user = User::where('id', $userid)->get();
                $profile = Profile::where('user_id', $userid)->get();
                $family = Family::where('user_id', $userid)->get();
                $study = Study::where('user_id', $userid)->get();
                $training = Training::where('user_id', $userid)->get();
                $language = Language::where('user_id', $userid)->get();
                $social = Social::where('user_id', $userid)->get();
                $reference = Reference::where('user_id', $userid)->get();
                $career = Career::where('user_id', $userid)->get();
                $question = Question::where('user_id', $userid)->get();

                $pdf = PDF::loadView('print.applicant', compact('application','user','profile','family','study','training','language','social','reference','career','question'))->setPaper('a4', 'potrait');
                return $pdf->stream();
            }
            else{
                
            }
        }
        catch (\Exception $e)
        {
            
        }
    }

    public function appcomp($id)
    {
        $data = Application::find($id);
        try
        {
            if(Auth::user()->admin != '0')
            {
                $userid = $data->user_id;
                
                $application= Application::where('id', $id)->get();
                $user       = User::where('id', $userid)->get();
                $profile    = Profile::where('user_id', $userid)->get();
                $family     = Family::where('user_id', $userid)->get();
                $study      = Study::where('user_id', $userid)->get();
                $training   = Training::where('user_id', $userid)->get();
                $language   = Language::where('user_id', $userid)->get();
                $social     = Social::where('user_id', $userid)->get();
                $reference  = Reference::where('user_id', $userid)->get();
                $career     = Career::where('user_id', $userid)->get();
                $question   = Question::where('user_id', $userid)->get();
                $comp       = Competency::where('user_id', $userid)->first();

                if($comp == null)
                {
                    $xhr        = "00000000000000000000000000000";
                    $xuser      = "00000000000000000000000000000";
                }else{
                    $xhr        = $comp->hr;
                    $xuser      = $comp->user;

                    if($xhr == null)
                    {
                        $xhr        = "00000000000000000000000000000";
                    }

                    if($xuser == null)
                    {
                        $xuser        = "00000000000000000000000000000";
                    }
                }

                $pdf        = PDF::loadView('print.appcomp', compact('application','user','profile','family','study','training','language','social','reference','career','question','xhr','xuser'))->setPaper('a4', 'potrait');
                return $pdf->stream();
            }
            else{
                
            }
        }
        catch (\Exception $e)
        {
            
        }
    }
}
