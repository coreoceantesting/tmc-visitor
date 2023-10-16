<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\VisitingPurpose;
use App\Models\Department;

use App\Models\Visitors;
use Carbon\Carbon;
use DB;

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
                return response()->json(['success'=>true,'data' => $user,'message'=>'Login Success'], 200);
            }else{
                Auth::logout();
                return response()->json(['success'=>false,'error' => 'Unauthorized','message'=>'Login fail'], 401);
            }

        }

        return response()->json(['success'=>false,'error' => 'Unauthorized','message'=>'Login fail'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['sucess'=>true,'data' => 'Logged out successfully','message'=>'success'], 200);
    }
    
    // dropdown listing api
    public function visit_purpose_list()
    {
        $VisitingPurpose = VisitingPurpose::where('is_delete','0')->get();
        return response()->json(['sucess'=>true,'data' => $VisitingPurpose,'message'=>'success'], 200);
    }

    public function department_list()
    {
        $VisitingPurpose = Department::where('is_delete','0')->get();
        return response()->json(['sucess'=>true,'data' => $VisitingPurpose,'message'=>'success'], 200);
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
            'photo' => 'required', // Adjust max file size as needed
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

            if ($request->has('photo')) {
                $photoData = $request->input('photo');
                
                // Determine the image extension
                $imageType = explode('/', mime_content_type("data:application/octet-stream;base64,$photoData"))[1];
                
                // Save the image to a folder (you may need to adjust the path)
                $folderName = 'admin/img';
                $imageName = time() . ".$imageType";
                file_put_contents(public_path($folderName . '/' . $imageName), base64_decode($photoData));
        
                $visitor->photo = $folderName . '/' . $imageName;
            }

            $visitor->save();

            return response()->json(['sucess'=>true,'data' => 'Visitor created successfully','message'=>'success'], 201);
        }
        else
        {
            return response()->json(['success'=>false,'error' => 'Unauthorized','message'=>'false'], 401);
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
        
        $visitors = $query->where('exit_datetime',null)->orderBy('id','desc')->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $visitors->items(),
            'message' => 'success',
            'links' => [
                'first' => $visitors->url(1),
                'last' => $visitors->url($visitors->lastPage()),
                'prev' => $visitors->previousPageUrl(),
                'next' => $visitors->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $visitors->currentPage(),
                'from' => $visitors->firstItem(),
                'last_page' => $visitors->lastPage(),
                'links' => [
                    [
                        'url' => $visitors->url(1),
                        'label' => '&laquo; Previous',
                        'active' => !$visitors->onFirstPage(),
                    ],
                    [
                        'url' => $visitors->url($visitors->lastPage()),
                        'label' => $visitors->lastPage(),
                        'active' => $visitors->currentPage() == $visitors->lastPage(),
                    ],
                    [
                        'url' => $visitors->nextPageUrl(),
                        'label' => 'Next &raquo;',
                        'active' => $visitors->hasMorePages(),
                    ],
                ],
                'path' => $visitors->url(1),
                'per_page' => $visitors->perPage(),
                'to' => $visitors->lastItem(),
                'total' => $visitors->total(),
            ],
        ], 200);
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
        $visitors = $query->whereDate('entry_datetime', $today)->where('exit_datetime',null)->orderBy('id','desc')->paginate(10);
        
        return response()->json([
            'success' => true,
            'data' => $visitors->items(),
            'message' => 'success',
            'links' => [
                'first' => $visitors->url(1),
                'last' => $visitors->url($visitors->lastPage()),
                'prev' => $visitors->previousPageUrl(),
                'next' => $visitors->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $visitors->currentPage(),
                'from' => $visitors->firstItem(),
                'last_page' => $visitors->lastPage(),
                'links' => [
                    [
                        'url' => $visitors->url(1),
                        'label' => '&laquo; Previous',
                        'active' => !$visitors->onFirstPage(),
                    ],
                    [
                        'url' => $visitors->url($visitors->lastPage()),
                        'label' => $visitors->lastPage(),
                        'active' => $visitors->currentPage() == $visitors->lastPage(),
                    ],
                    [
                        'url' => $visitors->nextPageUrl(),
                        'label' => 'Next &raquo;',
                        'active' => $visitors->hasMorePages(),
                    ],
                ],
                'path' => $visitors->url(1),
                'per_page' => $visitors->perPage(),
                'to' => $visitors->lastItem(),
                'total' => $visitors->total(),
            ],
        ], 200);

        // return response()->json(['sucess'=>true,'data' => $visitors,'message'=>'success', 200]);
    }
    
    // exited list
    public function exitsearchVisitors(Request $request)
    {
        $passId = $request->input('pass_id');
        $name = $request->input('name');
        $today = Carbon::now()->format('Y-m-d');

        $query = Visitors::query();

        if ($passId) {
            $query->where('pass_id', $passId)->where('exit_datetime', '!=', null);
        }

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%')->where('exit_datetime', '!=', null);
        }
        // If no search criteria are provided, by default, show today's exited visitors
        if (empty($passId) && empty($name)) {
            $query->whereDate('exit_datetime', $today);
        }

        $visitors = $query->orderBy('id', 'desc')->paginate(10);
        
        return response()->json([
            'success' => true,
            'data' => $visitors->items(),
            'message' => 'success',
            'links' => [
                'first' => $visitors->url(1),
                'last' => $visitors->url($visitors->lastPage()),
                'prev' => $visitors->previousPageUrl(),
                'next' => $visitors->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $visitors->currentPage(),
                'from' => $visitors->firstItem(),
                'last_page' => $visitors->lastPage(),
                'links' => [
                    [
                        'url' => $visitors->url(1),
                        'label' => '&laquo; Previous',
                        'active' => !$visitors->onFirstPage(),
                    ],
                    [
                        'url' => $visitors->url($visitors->lastPage()),
                        'label' => $visitors->lastPage(),
                        'active' => $visitors->currentPage() == $visitors->lastPage(),
                    ],
                    [
                        'url' => $visitors->nextPageUrl(),
                        'label' => 'Next &raquo;',
                        'active' => $visitors->hasMorePages(),
                    ],
                ],
                'path' => $visitors->url(1),
                'per_page' => $visitors->perPage(),
                'to' => $visitors->lastItem(),
                'total' => $visitors->total(),
            ],
        ], 200);

        // return response()->json(['success' => true, 'data' => $visitors, 'message' => 'success'], 200);
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
        $visitors = $query->whereDate('entry_datetime', $today)->whereDate('exit_datetime', $today)->orderBy('id','desc')->paginate(10);
        
        return response()->json([
            'success' => true,
            'data' => $visitors->items(),
            'message' => 'success',
            'links' => [
                'first' => $visitors->url(1),
                'last' => $visitors->url($visitors->lastPage()),
                'prev' => $visitors->previousPageUrl(),
                'next' => $visitors->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $visitors->currentPage(),
                'from' => $visitors->firstItem(),
                'last_page' => $visitors->lastPage(),
                'links' => [
                    [
                        'url' => $visitors->url(1),
                        'label' => '&laquo; Previous',
                        'active' => !$visitors->onFirstPage(),
                    ],
                    [
                        'url' => $visitors->url($visitors->lastPage()),
                        'label' => $visitors->lastPage(),
                        'active' => $visitors->currentPage() == $visitors->lastPage(),
                    ],
                    [
                        'url' => $visitors->nextPageUrl(),
                        'label' => 'Next &raquo;',
                        'active' => $visitors->hasMorePages(),
                    ],
                ],
                'path' => $visitors->url(1),
                'per_page' => $visitors->perPage(),
                'to' => $visitors->lastItem(),
                'total' => $visitors->total(),
            ],
        ], 200);

        // return response()->json(['sucess'=>true,'data' => $visitors,'message'=>'success', 200]);
    }
    
    // update visitor exit datetime
    public function updateexitDatetime(Request $request, $id)
    {
        // Find the visitor by ID
        $visitor = Visitors::find($id);

        if (!$visitor) {
            return response()->json(['sucess'=>false,'data' => 'Visitor Not Found','message'=>'Not Found',], 404);
        }

        // Update the exit date and time
        $visitor->exit_datetime = Carbon::now();
        $visitor->save();

        return response()->json(['sucess'=>true,'data' => 'Visitor Exit Time Updated','message' => 'Visitor has exited successfully'], 200);
    }
    
    // validation for passid 
    public function checkPassId(Request $request)
    {
        // Check if there is a visitor with the provided pass ID who hasn't exited
        $pass_id = $request->input('pass_id');
        $visitor = Visitors::where('pass_id', $pass_id)
            ->whereNull('exit_datetime')
            ->first();

        if ($visitor) {
            return response()->json(['success' => 'true','data' => 'Pass ID already Assigend','message' => 'Pass ID is already assigned to an active visitor'], 200);
        }

        return response()->json(['success' => 'true','data'=>'Pass ID is available','message' => 'Pass ID is available'], 200);
    }
    
    // dashboard count
    public function dashboard_counts()
    {   
        $today = Carbon::now()->toDateString();
        $durationInMinutes = 3 * 60; // 3 hours * 60 minutes/hour
        $durationInMinutesnew = 5 * 60; // 3 hours * 60 minutes/hour
        
        $data['todayEntryVisitorsCount'] = DB::table('visitors')->whereDate('entry_datetime', $today)->count();
        
        $data['todayExitVisitorsCount'] = DB::table('visitors')->whereDate('entry_datetime', $today)->whereDate('exit_datetime',$today)->count();
        
        $data['todayPendingExitCount'] = DB::table('visitors')->whereDate('entry_datetime', $today)->where('exit_datetime','=',null)->count();
        
        $data['morethanthreehourscount'] = DB::table('visitors')
            ->select(DB::raw('COUNT(*) as count'))
            ->whereRaw('TIMESTAMPDIFF(MINUTE, entry_datetime, exit_datetime) > ?', [$durationInMinutes])
            ->whereRaw('DATE(entry_datetime) = CURDATE()')
            ->first()
            ->count;

        $data['morethanfivehourscount'] = DB::table('visitors')
        ->select(DB::raw('COUNT(*) as count'))
        ->whereRaw('TIMESTAMPDIFF(MINUTE, entry_datetime, exit_datetime) > ?', [$durationInMinutesnew])
        ->whereRaw('DATE(entry_datetime) = CURDATE()')
        ->first()
        ->count;
        
        return response()->json(['success' => true,'data' => $data,'message' => 'success'], 200);
        
    }
    
}
