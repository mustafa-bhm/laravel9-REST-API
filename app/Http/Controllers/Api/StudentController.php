<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(){

        $students = Student::all();
        if($students->count()>0){
            $data = [
                'status' => 200,
                'students'=> $students,
            ];

            return response()->json($data, 200);
        }else{
            $data = [
                'status' => 404,
                'message'=> 'No Data found !',
            ];

            return response()->json($data, 200);
        }

    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=> 422,  // 422 => input error
                'errors'=> $validator->messages()
            ], 422);
        } else {
            $student = Student::create([
                'name'=> $request->name,
                'course'=> $request->course,
                'email'=> $request->email,
                'phone'=> $request->phone,
            ]);
            if($student){
                return response()->json([
                    'status' =>200,
                    'message'=> 'Student Created Successfully !'
                ], 200);
            }else {
                return response()->json([
                    'status' =>500,
                    'message'=> 'somthing went wrong'
                ], 500);
            }
        }
    }

    public function show($id){

        $student = Student::find($id);
        if($student){
            return response()->json([
                'status' =>200,
                'student' =>$student
            ], 200);
        }else{
            return response()->json([
                'status' =>404,
                'message'=> 'No student found'
            ], 404);
        }

    }

    public function edit($id){
        $student = Student::find($id);
        if($student){
            return response()->json([
                'status' =>200,
                'student' =>$student
            ], 200);
        }else{
            return response()->json([
                'status' =>404,
                'message'=> 'No student found'
            ], 404);
        }
    }

    public function update(Request $request, int $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=> 422,  // 422 => input error
                'errors'=> $validator->messages()
            ], 422);
        } else {
            $student = Student::find($id);

            if($student){
                $student->update([
                    'name'=> $request->name,
                    'course'=> $request->course,
                    'email'=> $request->email,
                    'phone'=> $request->phone,
                ]);
                return response()->json([
                    'status' =>200,
                    'message'=> 'Student has been updated Successfully !'
                ], 200);
            }else {
                return response()->json([
                    'status' =>404,
                    'message'=> 'student not found'
                ], 404);
            }
        }
    }
}
