<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Export;
use App\Models\Visitors;
use App\Models\PassValidity;
use App\Models\VisitingPurpose;
use App\Models\Department;
use App\Models\Passfor;
use Carbon\Carbon;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $today = Carbon::now()->toDateString();
        $durationInMinutes = 3 * 60; // 3 hours * 60 minutes/hour
        $durationInMinutesnew = 5 * 60; // 3 hours * 60 minutes/hour

        if (auth()->user()->role === 'hod')
        {
            $todayEntryVisitorsCount = DB::table('visitors')->where('visiting_dept',auth()->user()->department)->whereDate('entry_datetime', $today)->count();
            $todayExitVisitorsCount = DB::table('visitors')->where('visiting_dept',auth()->user()->department)->whereDate('entry_datetime', $today)->whereDate('exit_datetime',$today)->count();
            $todayPendingExitCount = DB::table('visitors')->where('visiting_dept',auth()->user()->department)->whereDate('entry_datetime', $today)->where('exit_datetime','=',null)->count();
            
            $morethanthreehourscount = DB::table('visitors')
            ->select(DB::raw('COUNT(*) as count'))
            ->where('visiting_dept',auth()->user()->department)
            ->whereRaw('TIMESTAMPDIFF(MINUTE, entry_datetime, exit_datetime) > ?', [$durationInMinutes])
             ->whereRaw('DATE(entry_datetime) = CURDATE()')
            ->first()
            ->count;
            
             $morethanfivehourscount = DB::table('visitors')
            ->select(DB::raw('COUNT(*) as count'))
            ->where('visiting_dept',auth()->user()->department)
            ->whereRaw('TIMESTAMPDIFF(MINUTE, entry_datetime, exit_datetime) > ?', [$durationInMinutesnew])
            ->whereRaw('DATE(entry_datetime) = CURDATE()')
            ->first()
            ->count;
            
        }else{
            $todayEntryVisitorsCount = DB::table('visitors')->whereDate('entry_datetime', $today)->count();
            $todayExitVisitorsCount = DB::table('visitors')->whereDate('entry_datetime', $today)->whereDate('exit_datetime',$today)->count();
            $todayPendingExitCount = DB::table('visitors')->whereDate('entry_datetime', $today)->where('exit_datetime','=',null)->count();
            
            $morethanthreehourscount = DB::table('visitors')
            ->select(DB::raw('COUNT(*) as count'))
            ->whereRaw('TIMESTAMPDIFF(MINUTE, entry_datetime, exit_datetime) > ?', [$durationInMinutes])
             ->whereRaw('DATE(entry_datetime) = CURDATE()')
            ->first()
            ->count;
            
            $morethanfivehourscount = DB::table('visitors')
            ->select(DB::raw('COUNT(*) as count'))
            ->whereRaw('TIMESTAMPDIFF(MINUTE, entry_datetime, exit_datetime) > ?', [$durationInMinutesnew])
            ->whereRaw('DATE(entry_datetime) = CURDATE()')
            ->first()
            ->count;
        }
        

        

        

        return view('home',compact('todayEntryVisitorsCount','todayExitVisitorsCount','todayPendingExitCount','morethanthreehourscount','morethanfivehourscount'));
    }

    public function register_visitor()
    {
        $department = Department::where('is_delete','0')->get();
        $VisitingPurpose = VisitingPurpose::where('is_delete','0')->get();
        return view('register_visitor',compact('department','VisitingPurpose'));
    }

    public function store_visitor(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'organization' => 'required',
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'purpose_of_visit'=>'required',
            'visiting_dept' => 'required',
            'to_visit' => 'required',
            'pass_id' => 'required'
         ]);

        //  $unique_pass_id = Visitors::where('pass_id',$request->input('pass_id'))->where('exit_datetime',null)->count();
        //  if($unique_pass_id > 0)
        //  {
        //     return redirect()->route('register.visitor')->with('error', 'This visitor pass id is already assigend to someone please use diffrent pass id.');
        //  }

         Visitors::create([
            'name' => $request->input('name'),
            'mobile' => $request->input('mobile'),
            'organization' => $request->input('organization'),
            'purpose_of_visit' => $request->input('purpose_of_visit'),
            'visiting_dept' => $request->input('visiting_dept'),
            'to_visit' => $request->input('to_visit'),
            'pass_id' => $request->input('pass_id'),
            'entry_datetime' => Carbon::now(),
        ]);
         return redirect()->route('register.visitor')->with('success', 'Visitor is successfully Store');
    }

    public function exit_list_visitor(Request $request)
    {
        // $visitors = Visitors::all();

        $name = $request->input('name');
        $mobno = $request->input('mobnumber');
        $dept = $request->input('dept');
        $passid = $request->input('passid');

        $query = visitors::query();

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        // if ($mobno) {
        //     $query->where('mobile', $mobno);
        // }

        // if ($dept) {
        //     $query->where('visiting_dept', $dept);
        // }

        if ($passid) {
            $query->where('pass_id', $passid);
        }
        
        $today = Carbon::now()->format('Y-m-d');
        if (auth()->user()->role === 'hod'){
            $visitors = $query->whereDate('entry_datetime', $today)->where('exit_datetime',null)->where('visiting_dept',auth()->user()->department)->orderBy('id','desc')->get();
        }else{
            $visitors = $query->whereDate('entry_datetime', $today)->where('exit_datetime',null)->orderBy('id','desc')->get();
        }
        $department = Department::where('is_delete','0')->get();
        $VisitingPurpose = VisitingPurpose::where('is_delete','0')->get();

        return view('visitor_list',compact('visitors','department','VisitingPurpose'));
    }

    public function entry_list_visitor(Request $request)
    {
        $name = $request->input('name');
        $passid = $request->input('passid');
        // $dept = $request->input('dept');
        // $oragnization = $request->input('oraganization');

        $query = visitors::query();

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        if ($passid) {
            $query->where('pass_id', $passid);
        }

        // if ($dept) {
        //     $query->where('visiting_dept', $dept);
        // }

        // if ($oragnization) {
        //     $query->where('organization', 'like', '%' . $oragnization . '%');
        // }

        $today = Carbon::now()->format('Y-m-d');
        if (auth()->user()->role === 'hod')
        {
            $visitors = $query->whereDate('entry_datetime', $today)->where('exit_datetime',null)->where('visiting_dept',auth()->user()->department)->orderBy('id','desc')->get();
        }else{
            $visitors = $query->whereDate('entry_datetime', $today)->where('exit_datetime',null)->orderBy('id','desc')->get();
        }
        $department = Department::where('is_delete','0')->get();
        $VisitingPurpose = VisitingPurpose::where('is_delete','0')->get();
        // $visitors = Visitors::all();
        return view('entry_visitor_list',compact('visitors','department','VisitingPurpose'));
    }

    public function update_visitor_exit_time($id)
    {
        $user = Visitors::find($id);
        if (!$user) {
            abort(404); // User not found
        }
        // Update the exit time for the user
        $user->exit_datetime = now(); // Set the exit time to the current datetime
        $user->save();
        return redirect()->route('exitedlist.visitor')->with('success', 'Exit time updated successfully');
    }

    public function exited_list_visitor(Request $request)
    {
        // $visitors = Visitors::all();

        $name = $request->input('name');
        $mobno = $request->input('mobnumber');
        $dept = $request->input('dept');
        $passid = $request->input('passid');

        $query = visitors::query();

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        // if ($mobno) {
        //     $query->where('mobile', $mobno);
        // }

        // if ($dept) {
        //     $query->where('visiting_dept', $dept);
        // }

        if ($passid) {
            $query->where('pass_id', $passid);
        }

        if (auth()->user()->role === 'hod'){
            $visitors = $query->where('exit_datetime','!=',null)->where('visiting_dept',auth()->user()->department)->orderBy('id','desc')->get();
        }else{
            $visitors = $query->where('exit_datetime','!=',null)->orderBy('id','desc')->get();
        }
        $department = Department::where('is_delete','0')->get();
        $VisitingPurpose = VisitingPurpose::where('is_delete','0')->get();

        return view('exited',compact('visitors','department','VisitingPurpose'));
    }

    public function checkPassId(Request $request) {
        $passId = $request->input('pass_id');
    
        // Check if the pass_id exists in the database
        $pass = Visitors::where('pass_id',$passId)->where('exit_datetime',null)->count();
    
        if ($pass > 0) {
            // Pass ID is already assigned
            return response()->json(['message' => 'Pass ID is already assigned.'], 200);
        }
    
        // Pass ID is available
        return response()->json(['message' => 'Pass ID is available.'], 200);
    }

    public function term_condition()
    {
        return view('term_condition');
    }

    public function privacy_policy()
    {
        return view('privacy_policy');
    }

    public function special_pass(Request $request)
    {
        $name = $request->input('name');
        $mobno = $request->input('mobnumber');
        $dept = $request->input('dept');
        $oragnization = $request->input('oraganization');

        $query = DB::table('special_pass_visitors');

        if ($name) {
            $query->where('first_name', 'like', '%' . $name . '%');
        }

        if ($mobno) {
            $query->where('mob_no', $mobno);
        }

        if ($dept) {
            $query->where('department_name', $dept);
        }

        if ($oragnization) {
            $query->where('organization_name', 'like', '%' . $oragnization . '%');
        }
        
        
        if (auth()->user()->role === 'hod'){
            $visitors = $query->where('department_name',auth()->user()->department)->orderBy('special_pass_visitors_id','desc')->get();
        }else{
            $visitors = $query->orderBy('special_pass_visitors_id','desc')->get();
        }
        $department = Department::where('is_delete','0')->get();
        $VisitingPurpose = VisitingPurpose::where('is_delete','0')->get();
        // $visitors = Visitors::all();
        return view('specialpass',compact('visitors','department','VisitingPurpose'));
    }

    public function add_specialpass()
    {
        $department = Department::where('is_delete','0')->get();
        $PassValidity = PassValidity::where('is_delete','0')->get();
        $Passfor = Passfor::where('is_delete','0')->get();
        return view('add_specialpass',compact('department','PassValidity','Passfor'));
    }

    public function store_special_pass(Request $request)
    {
        $request->validate([
            'f_name' => 'required|string',
            'l_name' => 'required|string',
            'age' => 'required|integer',
            'email' => 'required|email',
            'address' => 'required',
            'mobile' => ['required', 'numeric', 'digits:10'],
            'organization' => 'required',
            'visiting_dept' => 'required',
            'validity' => 'required',
            'made_for' => 'required',
            'photo' => 'required', // Customize for image uploads
        ]);

        $unique_pass_id = 'TMC-'.date('Y-m');
    
        $data = [
            'first_name' => $request->input('f_name'),
            'special_pass_visitor_unique_id'=>$unique_pass_id,
            'middle_name' => $request->input('m_name'),
            'last_name' => $request->input('l_name'),
            'age' => $request->input('age'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'mob_no' => $request->input('mobile'),
            'organization_name' => $request->input('organization'),
            'department_name' => $request->input('visiting_dept'),
            'pass_validity' => $request->input('validity'),
            'pass_made_for_type' => $request->input('made_for'),
            'valid_from' => date('d-m-Y'),
            'valid_till' => $request->input('valid_till'),
        ];

        if ($request->hasFile('photo')) {
            // Specify the folder where you want to save the images
            $folderName = 'admin/img';

            // Get the uploaded file
            $imageFile = $request->file('photo');

            // Generate a unique filename for the image (e.g., using timestamp)
            $imageName = time() . '.' . $imageFile->getClientOriginalExtension();

            // Move the uploaded file to the specified folder
            $imageFile->move(public_path($folderName), $imageName);


            $data['photo'] = $folderName . '/' . $imageName;
        }
    
        DB::table('special_pass_visitors')->insert($data);
    
        return redirect()->route('add.specialpass')->with('success', 'Visitor information has been stored successfully.');
    }
    
    public function pending_special_pass(Request $request)
    {
        $name = $request->input('name');
        $mobno = $request->input('mobnumber');
        $dept = $request->input('dept');
        $oragnization = $request->input('oraganization');

        $query = DB::table('special_pass_visitors');

        if ($name) {
            $query->where('first_name', 'like', '%' . $name . '%');
        }

        if ($mobno) {
            $query->where('mob_no', $mobno);
        }

        if ($dept) {
            $query->where('department_name', $dept);
        }

        if ($oragnization) {
            $query->where('organization_name', 'like', '%' . $oragnization . '%');
        }
        if (auth()->user()->role === 'hod'){
            $visitors = $query->where('approval_status','pending')->where('department_name',auth()->user()->department)->orderBy('special_pass_visitors_id','desc')->get();
        }else{
            $visitors = $query->where('approval_status','pending')->orderBy('special_pass_visitors_id','desc')->get();
        }
        $department = Department::where('is_delete','0')->get();
        $VisitingPurpose = VisitingPurpose::where('is_delete','0')->get();
        
        return view('pending_special_pass',compact('visitors','department','VisitingPurpose'));
    }
    
    public function special_pass_approval(Request $request,$id)
    {
        $remark = $request->input('approveremark');
        DB::table('special_pass_visitors')
        ->where('special_pass_visitors_id', $id) // Specify the condition for the update
        ->update([
            'approval_status' => 'approved',
            'approval_by' => auth()->user()->first_name,
            'approval_date' => date('d-m-Y'),
            'remark' => $remark
        ]);

        return redirect()->route('pending.special_pass')->with('success', 'Special pass approved successfully');
    }

    public function special_pass_reject(Request $request,$id)
    {
        $remark = $request->input('rejectremark');
        DB::table('special_pass_visitors')
        ->where('special_pass_visitors_id', $id) // Specify the condition for the update
        ->update([
            'approval_status' => 'reject',
            'approval_by' => auth()->user()->first_name,
            'approval_date' => date('d-m-Y'),
            'remark' => $remark
        ]);

        return redirect()->route('pending.special_pass')->with('success', 'Special pass rejected successfully');
    }

    // view speical pass
    public function special_pass_view($id)
    {
        $data = DB::table('special_pass_visitors')->where('special_pass_visitors_id', $id)->first();
        $department = Department::where('is_delete','0')->get();
        $PassValidity = PassValidity::where('is_delete','0')->get();
        $Passfor = Passfor::where('is_delete','0')->get();
        return view('view_specialpass',compact('data','department','PassValidity','Passfor'));
    }
    
    // not submitted pass (not exited)
    
    public function notexited_list_visitor(Request $request)
    {
        $name = $request->input('name');
        $passid = $request->input('passid');

        $query = visitors::query();

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        if ($passid) {
            $query->where('pass_id', $passid);
        }

        $visitors = $query->where('exit_datetime',null)->orderBy('id','desc')->get();
        $department = Department::where('is_delete','0')->get();
        $VisitingPurpose = VisitingPurpose::where('is_delete','0')->get();
        return view('notsubmitted_visitor_list',compact('visitors','department','VisitingPurpose'));
    }

}