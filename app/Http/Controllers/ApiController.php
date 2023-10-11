<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Token;
use Illuminate\Support\Str;
use App\Models\VisitingPurpose;
use App\Models\Department;

use App\Models\Visitors;
use Carbon\Carbon;

class ApiController extends Controller
{
    // login logout api
    public function login(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            if (Auth::user()->is_delete === 0) 
            {
                $user = Auth::user();
                $token = explode('|', $user->createToken('AuthToken')->plainTextToken, 2);
                $user['token']= $token[1];
                return response()->json(['success'=>'true','data' => $user,'message'=>'Login Success'], 200);
            }else{
                Auth::logout();
                return response()->json(['error' => 'Unauthorized'], 401);
            }

        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['sucess'=>'true','message' => 'Logged out successfully'], 200);
    }

    // dropdown listing api
    public function visit_purpose_list()
    {
        $VisitingPurpose = VisitingPurpose::where('is_delete','0')->get();
        return response()->json(['sucess'=>'true','data' => $VisitingPurpose], 200);
    }

    public function department_list()
    {
        $VisitingPurpose = Department::where('is_delete','0')->get();
        return response()->json(['sucess'=>'true','data' => $VisitingPurpose], 200);
    }


    // store visitor api
    public function store_visitor(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'organization' => 'required',
            'purpose_of_visit' => 'required',
            'visiting_dept' => 'required',
            'to_visit' => 'required',
            'pass_id' => 'required',
            'entry_datetime' => 'required|date',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max file size as needed
        ]);
        if (Auth::check()) 
        {
            $user = Auth::user();

            $visitor = new Visitors;
            $visitor->name = $request->input('name');
            $visitor->mobile = $request->input('mobile');
            $visitor->organization = $request->input('organization');
            $visitor->purpose_of_visit = $request->input('purpose_of_visit');
            $visitor->visiting_dept = $request->input('visiting_dept');
            $visitor->to_visit = $request->input('to_visit');
            $visitor->pass_id = $request->input('pass_id');
            $visitor->entry_datetime = $request->input('entry_datetime');
            $visitor->created_by = $user->id;
            $visitor->updated_by = $user->id;

            if ($request->hasFile('photo')) 
            {
                $folderName = 'admin/img';
                $imageFile = $request->file('photo');
                $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path($folderName), $imageName);
                $visitor->photo = $folderName . '/' . $imageName;
            }

            $visitor->save();

            return response()->json(['success'=>'true','message' => 'Visitor created successfully'], 201);
        }
        else
        {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
    }

    // search visitor by pass id and name
    public function searchVisitors(Request $request)
    {
        $passId = $request->input('pass_id');
        $name = $request->input('name');

        $query = Visitors::query();

        if ($passId) {
            $query->where('pass_id', $passId);
        }

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }
        
        $visitors = $query->orderBy('id','desc')->get();

        return response()->json(['sucess'=>true,'data' => $visitors,'message'=>'success', 200]);
    }
    
     public function todaysVisitors(Request $request)
    {
        $passId = $request->input('pass_id');
        $name = $request->input('name');

        $query = Visitors::query();

        if ($passId) {
            $query->where('pass_id', $passId);
        }

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        $today = Carbon::now()->format('Y-m-d');
        $visitors = $query->whereDate('entry_datetime', $today)->where('exit_datetime',null)->orderBy('id','desc')->get();

        return response()->json(['sucess'=>true,'data' => $visitors,'message'=>'success', 200]);
    }

    public function exitsearchVisitors(Request $request)
    {
        $passId = $request->input('pass_id');
        $name = $request->input('name');

        $query = Visitors::query();

        if ($passId) {
            $query->where('pass_id', $passId);
        }

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }
        
        $visitors = $query->where('exit_datetime','!=',null)->orderBy('id','desc')->get();

        return response()->json(['sucess'=>true,'data' => $visitors,'message'=>'success', 200]);
    }
    
     public function exittodaysVisitors(Request $request)
    {
        $passId = $request->input('pass_id');
        $name = $request->input('name');

        $query = Visitors::query();

        if ($passId) {
            $query->where('pass_id', $passId);
        }

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        $today = Carbon::now()->format('Y-m-d');
        $visitors = $query->whereDate('entry_datetime', $today)->whereDate('exit_datetime', $today)->orderBy('id','desc')->get();

        return response()->json(['sucess'=>true,'data' => $visitors,'message'=>'success', 200]);
    }
}
