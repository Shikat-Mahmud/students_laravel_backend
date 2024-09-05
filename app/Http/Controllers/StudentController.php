<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Validator;

class StudentController extends Controller
{
    public function index() {
        $students = Student::all();

        return response()->json([
            'status' => 'true',
            'data' => $students
        ]);
    }

    public function show($id) {
        $student = Student::find($id);

        if($student == null) {
            return response()->json([
                'status' => false,
                'message' => 'Student not found.'
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $student
        ]);
    }

    public function store(Request $request) {
        try{
            $validator = Validator::make($request->all(),
            [
                'name' => 'required|min:3',
                'email' => 'required|email',
                'phone' => 'nullable|min:10',
            ]
        );

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        $student = new Student;

        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->address = $request->address;

        $student->save();

        return response()->json([
            'status' => true,
            'message' => 'Student added successfully',
            'data' => $student
        ]);

        } catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => 'Exceptions: '.$e
            ]);
        }
    }
}
