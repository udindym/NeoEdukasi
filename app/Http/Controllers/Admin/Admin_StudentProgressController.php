<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Student;
use App\Models\admin\Vacancy;
use App\Models\Tentor;
use App\Models\admin\TutoredStudents;
use App\Models\tentor\StudentProgress;
use App\Models\tentor\TentorApplication;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Mail;
use PDF;

class Admin_StudentProgressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $stdProgress = StudentProgress::join('tutored-students', 'tutored-students.id', '=', 'students_progress.tentored_student_id') 
        ->join('students', 'tutored-students.student_id', '=', 'students.id') 
        ->join('tentors', 'tutored-students.tentor_id', '=', 'tentors.id') 
        ->join('branchs', 'tentors.branch_id', '=', 'branchs.branch_id')
        ->where('students_progress.status','!=', 10)
        ->select('students_progress.*','tutored-students.subject','students.first_name as stdFirstName', 'students.last_name as stdLastName','tentors.first_name as tntrFirstName', 'tentors.last_name as tntrLastName','branchs.branch_name')
        ->orderBy('students_progress.month', 'DESC')->get();

        return view('admin.pages.student-progress.index', ['datas' => $stdProgress]);
    }

    public function view($id)
    {
        $studentProgress = StudentProgress::join('tutored-students', 'tutored-students.id', '=', 'students_progress.tentored_student_id')  
        ->join('students','tutored-students.student_id','=','students.id')
        ->where('students_progress.id','=', $id)
        ->select('students_progress.*','tutored-students.subject','students.id as stdId','students.first_name as stdFirstName', 'students.last_name as stdLastName')
        ->get()->first();;
        return view('admin.pages.student-progress.view', ['data' => $studentProgress]);
    }


    public function create()
    {
        $tentorList= Tentor::where('account_status','=',100)
        ->get(['tentors.id','tentors.first_name','tentors.last_name']);;
        return view('admin.pages.student-progress.create', ['tentorList'=>$tentorList]);
    }

    public function postCreate(Request $request)
    {   
        $request->validate([
            'tentored_id' => ['required', 'numeric'],
            'learning_progression' => ['required', 'string'],
            'feedback' => ['required', 'string'],
            'study_method' => ['required', 'string'],
            'study_target' => ['required', 'string'],
            'month' => ['required'],
         ]);     
        StudentProgress::create([
            'tentored_student_id' => $request->tentored_id,
            'learning_progression' => $request->learning_progression,
            'feedback' => $request->feedback,
            'study_method' => $request->study_method,
            'study_target' => $request->study_target,
            'month' => $request->month,
            'status' => 0,
        ]);

        
        Alert::success('Success', 'Your report successfully submitted');
        return redirect()->route('admin.submission.student-progress.index');
    }

    public function getStudent(Request $request){
        $id = $request->id;
        $data = Student::join('tutored-students', 'tutored-students.student_id', '=', 'students.id')
        ->where('tutored-students.tentor_id','=',$id)
        ->get(['tutored-students.id as stdId','students.*', 'tutored-students.subject'])->sortBy('month');
        $response = array();
        foreach($data as $data)
        { 
                $response[] = array(
                    "id"=>$data->stdId,
                    "text"=>$data->first_name.' '.$data->last_name.' ( '.$data->subject.' )', PHP_EOL
                );
        }    
        return $response;
     }

     public function getMonth(Request $request){

        $id = $request->id;
        $data = TutoredStudents::find($id);
        $timedata = TutoredStudents::select('created_at as month')
        ->where('tutored-students.id','=',$id)
        ->get()->first();
        $strmonth = strtotime($timedata->month); 
        $created_date = date("Y-m",$strmonth);
        $created_1month = $created_date.'-13';
        $created_month = strtotime($created_1month);

        $response = array();
        $start = $month = strtotime("-1 month", $created_month);
        $end = strtotime(date('Y-m-d'));
        while($month <= $end)
        { 
            $month = strtotime("+1 month", $month);
            $checkdate = date('Y-m-d',$month);
            $checkData = StudentProgress::where('tentored_student_id','=', $id)
                ->where('month','=',$checkdate)
                ->get()->first();
                $date= date('Y-m-d');
                $date1 = $date;
                $str = strtotime($date1);
                if(!$checkData AND $month <= $str){
                    $response[] = array(
                        "id"=>date('Y-m-d',$month),
                        "text"=>date('F Y', $month), PHP_EOL
                    );
                }
        }    
        return $response;
     }

    public function approve(Request $request)
    {
        $id = $request->id; 
        $stdProgress = StudentProgress::find($id);
        if($stdProgress){
            $stdProgress->status = 10;
            $stdProgress->save();
        }
        $response="Student Progress Report Status Successfully Updated";
        return $response;
    }

    public function decline(Request $request)
    {
        $id = $request->id; 
        $stdProgress = StudentProgress::find($id);
        if($stdProgress){
            $stdProgress->status = -10;
            $stdProgress->save();
        }
        $response="Student Progress Report Status Successfully Updated";
        return $response;
    }
}
