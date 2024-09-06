<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Validator;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();

        return response()->json([
            'status' => 'true',
            'data' => $students
        ]);
    }

    public function show($id)
    {
        $student = Student::find($id);

        if ($student) {
            return response()->json([
                'status' => true,
                'data' => $student
            ]);

        }

        return response()->json([
            'status' => false,
            'message' => 'Student not found.'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|min:3|max:255',
                    'email' => 'required|email|max:255|unique:students,email',
                    'phone' => 'nullable|string|min:10',
                    'address' => 'nullable|string|max:255'
                ]
            );

            if ($validator->fails()) {
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
            $student->status = 'active';

            $student->save();

            return response()->json([
                'status' => true,
                'message' => 'Student added successfully',
                'data' => $student
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred.',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $student = Student::find($id);

            if ($student == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Student not found.'
                ]);
            }

            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|min:3|max:255',
                    'email' => 'required|email|max:255',
                    'phone' => 'nullable|string|min:10',
                    'address' => 'nullable|string|max:255'
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $student->name = $request->name;
            $student->email = $request->email;
            $student->phone = $request->phone;
            $student->address = $request->address;
            $student->status = 'active';

            $student->save();

            return response()->json([
                'status' => true,
                'message' => 'Student updated successfully',
                'data' => $student
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $student = Student::find($id);

        if ($student == null) {
            return response()->json([
                'status' => false,
                'message' => 'Student not found.',
            ]);
        }

        $student->delete();

        return response()->json([
            'status' => true,
            'message' => 'Student deleted successfully.',
        ]);
    }
}
