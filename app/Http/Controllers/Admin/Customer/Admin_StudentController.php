<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Branch;
use App\Models\ClassModel;
use App\Models\ModelClass;
use App\Models\Tentor;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use PHPUnit\Framework\MockObject\Builder\Stub;
use RealRashid\SweetAlert\Facades\Alert;

class Admin_StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $student = Student::join('branchs', 'students.branch_id', '=', 'branchs.branch_id')
        ->orderBy('students.first_name', 'ASC')->get([ 'students.*','branchs.branch_name']);;
        return view('admin.pages.students.index', ['students' => $student]);
    }

    public function addnew()
    {
        $branchs = Branch::all();
        $class = ClassModel::all();
        return view('admin.pages.students.newstudent',  ['branchs' => $branchs,'class' => $class]);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string','max:255'],
            'email' => ['required', 'string','email', 'unique:students', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'POB' => ['required', 'string', 'max:255'],
            'DOB' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'numeric', 'unique:students', 'digits_between:10,13'],
            'parent_phone_number' => ['required', 'numeric', 'unique:students', 'digits_between:10,13'],
            'religion' => ['string', 'max:255'],
            'school' => ['required', 'string', 'max:20'],
            'class' => ['required', 'string', 'max:20'],
            'curriculum' => ['required', 'string', 'max:20'],
            'branch' => ['required', 'numeric'],
          ]);

        $token = Str::random(64);
        $password = Hash::make(strtolower($request->first_name).'12345');
        
        if (substr($request->phone_number, 0, 1) === '0') { 
              $phone_number = substr($request->phone_number,1);
              $phone_number = '62'.$phone_number;
        }else{
            $phone_number = $request->phone_number;
        }
        if (substr($request->parent_phone_number, 0, 1) === '0') { 
              $parent_phone_number = substr($request->parent_phone_number,1);
              $parent_phone_number = '62'.$parent_phone_number;
        }else{
            $parent_phone_number = $request->parent_phone_number;
        }
        Student::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'email' => $request->email,
            'password' => $password,
            'gender' => $request->gender,
            'POB' => $request->POB,
            'DOB' => $request->DOB,
            'phone_number' => $phone_number,
            'parent_phone_number' => $phone_number,
            'religion' => $request->religion,
            'school' => $request->school,
            'class_id' => $request->class,
            'curriculum' => $request->curriculum,
            'branch_id' => $request->branch,
            'token'=>$token,
            'account_status'=> "-10",
          ]);

        Alert::success('Success', 'Siswa Berhasil Ditambahkan!');
        return redirect()->route('admin.student.all.all');
    }

    public function show($id)
    {
        $data = Student::join('branchs', 'students.branch_id', '=', 'branchs.branch_id')
        ->join('class','class.id','=','students.class_id')
        ->where('students.id','=', $id)
        ->get([ 'students.*','branchs.branch_name','class.class'])->first();;

        $branchs = Branch::all();
        $class = ModelClass::all();
        
        return view('admin.pages.students.view', ['data' => $data, 'branchs'=>$branchs, 'class'=>$class]);
    }

    public function remove(Request $request)
    {
        $id = $request->id; 
        Student::where('id', $id)->delete();
        $response="Student Record Successfully Deleted ";
        return $response;
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string','max:255'],
            'email' => ['required', 'string','email', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'POB' => ['required', 'string', 'max:255'],
            'DOB' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'numeric', 'digits_between:10,13'],
            'parent_phone_number' => ['required', 'numeric', 'digits_between:10,13'],
            'religion' => ['string', 'max:255'],
            'school' => ['required', 'string', 'max:20'],
            'class' => ['required', 'string', 'max:20'],
            'curriculum' => ['required', 'string', 'max:20'],
            'branch' => ['required', 'numeric'],
          ]);
        if (substr($request->phone_number, 0, 1) === '0') { 
            $phone_number = substr($request->phone_number,1);
            $phone_number = '62'.$phone_number;
        }else{
          $phone_number = $request->phone_number;
        }
        if (substr($request->parent_phone_number, 0, 1) === '0') { 
            $parent_phone_number = substr($request->parent_phone_number,1);
            $parent_phone_number = '62'.$parent_phone_number;
        }else{
          $parent_phone_number = $request->parent_phone_number;
        }
          $student=Student::find($request->id);
          
          $student->first_name=$request->first_name;
          $student->last_name=$request->last_name;
          $student->address=$request->address;
          $student->email=$request->email;
          $student->gender=$request->gender;
          $student->POB=$request->POB;
          $student->DOB=$request->DOB;
          $student->phone_number=$phone_number;
          $student->parent_phone_number=$parent_phone_number;
          $student->religion=$request->religion;
          $student->school=$request->school;
          $student->class_id=$request->class;
          $student->curriculum=$request->curriculum;
          $student->branch_id=$request->branch;
          $student->save();


        Alert::success('Success', 'Student Data successfully updated!');
        return redirect()->route('admin.student.all.all');
    }
}
