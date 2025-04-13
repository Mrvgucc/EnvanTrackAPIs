<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function employeeInsert(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required',
            'status' => 'required'
        ]);

        $employee =Employee::create([
            'name' => $validated['name'],
            'surname' => $validated['surname'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'status' => $validated['status']
        ]);

        return response()->json([
            'message' => 'Employee inserted successfully',
        ]);
    }

    public function employeeUpdate(Request $request,$id){
        $validated = $request->validate([
            'name' => 'nullable',
            'surname' => 'nullable',
            'email' => 'nullable',
            'phone' => 'nullable',
            'password' => 'nullable',
            'status' => 'nullable'
        ]);

        $employee = Employee::find($id);

        if (!$employee){
            return response()->json([
                'message' => 'Employee not found.',
            ]);
        }

        if (isset($validated['name'])){
            $employee->name = $validated['name'];
        }
        if (isset($validated['surname'])){
            $employee->surname = $validated['surname'];
        }
        if (isset($validated['email'])){
            $employee->email = $validated['email'];
        }
        if (isset($validated['phone'])){
            $employee->phone = $validated['phone'];
        }
        if (isset($validated['password'])){
            $employee->password = Hash::make($validated['password']);
        }
        if (isset($validated['status'])){
            $employee->status = $validated['status'];
        }

        $employee->save();

        return response()->json([
            'message' => 'Employee updated successfully',
        ]);
    }
    public function employeeDelete($id){

        $employee = Employee::find($id);

        if (!$employee){
            return response()->json([
                'message' => 'Employee not found.',
            ]);
        }
        $employee->delete();
        return response()->json([
            'message' => 'Employee deleted successfully.',
        ]);
    }

    public function employeeList(){
        $employees = Employee::all();
        return response()->json([
            'employees' => $employees,
        ]);
    }

    public function employeeInfo(){
        $employeeId =auth()->id();

        if (!$employeeId){
            return response()->json([
                'message' => 'User not authenticated'
            ],401);
        }

        $employee = Employee::find($employeeId);

        if (!$employee) {
            return response()->json([
                'message' => 'Employee not found',
            ], 404);
        }

        return response()->json([
            'name' => $employee->name,
            'surname' => $employee->surname,
            'email' => $employee->email,
            'phone' => $employee->phone,
            'status' => $employee->status,

        ]);


    }
}
