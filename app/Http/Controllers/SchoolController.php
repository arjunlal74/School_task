<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\SelectedSchool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolController extends Controller
{
    public function schoolSelect(Request $request){
        $selectedSchoolIds = $request->action;
        $selectedSchool = SelectedSchool::where('user_id',Auth::user()->id)->first();
        if(!$selectedSchool){
            if(count($selectedSchoolIds) >3){
                return redirect()->back()->with('error','Maximum 3 schools can be selected');
            }
            $selectedSchool = new SelectedSchool();
            $selectedSchool->user_id = Auth::user()->id;
            $selectedSchool->selected_school = json_encode($selectedSchoolIds);
            $issave = $selectedSchool->save();
            if($issave){
                return redirect()->back()->with('success','submitted successfully');
            }
        }else{
            $selectedSchoolArray = json_decode( $selectedSchool->selected_school);
            $incomingSelectedSchoolArray = $request->action;
            foreach($incomingSelectedSchoolArray as $value){
                $selectedSchoolArray[] = $value;
            }
            if(count($selectedSchoolArray) >3){
                return redirect()->back()->with('error','Maximum 3 schools can be selected');
            }
            $selectedSchoolArray = json_encode($selectedSchoolArray);
            $selectedSchool->selected_school = $selectedSchoolArray;
            $issave = $selectedSchool->save();
            if($issave){
                return redirect()->back()->with('success','submitted successfully');

            }
        }

    }

    public function selectedSchool(){
        $selectedSchool = SelectedSchool::where('user_id',Auth::user()->id)->first();
        if($selectedSchool){
            $selectedSchools = json_decode($selectedSchool->selected_school);
            $schools = School::whereIn('id',$selectedSchools)->get();
        }else{
            $schools = [];
        }

        return view('selected-schools',compact('schools'));
    }

    public function removeSchool(Request $request){
        $selectedSchools = SelectedSchool::where('user_id',Auth::user()->id)->first();
        $selectedSchool = json_decode($selectedSchools->selected_school);
        $removed_result = array_diff($selectedSchool , $request->action);
        $removed_result = array_values($removed_result);
        $removed_result = json_encode($removed_result);
        $selectedSchools->selected_school = $removed_result;
        $issremove = $selectedSchools->save();
        if($issremove){
            return redirect()->back()->with('success','Removed successfully');
        }
    }

}
