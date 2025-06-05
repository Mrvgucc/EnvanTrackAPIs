<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use function PHPUnit\Framework\isEmpty;

class EmployeeController extends Controller
{
    public function employeeInsert(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|unique:employees,email|email',
            'phone' => 'required',
            'password' => 'required',
            'status' => ['required', Rule::in(['personal', 'manager'])]
        ]);

        $employee = Employee::create([
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

    public function employeeUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'nullable',
            'surname' => 'nullable',
            'email' => 'nullable',
            'phone' => 'nullable',
            'password' => 'nullable',
            'status' => 'nullable'
        ]);

        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'message' => 'Employee not found.',
            ]);
        }

        if (isset($validated['name'])) {
            $employee->name = $validated['name'];
        }
        if (isset($validated['surname'])) {
            $employee->surname = $validated['surname'];
        }
        if (isset($validated['email'])) {
            $employee->email = $validated['email'];
        }
        if (isset($validated['phone'])) {
            $employee->phone = $validated['phone'];
        }
        if (isset($validated['password'])) {
            $employee->password = Hash::make($validated['password']);
        }
        if (isset($validated['status'])) {
            $employee->status = $validated['status'];
        }

        $employee->save();

        return response()->json([
            'message' => 'Employee updated successfully',
        ]);
    }

    public function employeeDelete($id)
    {

        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'message' => 'Employee not found.',
            ]);
        }
        $employee->delete();
        return response()->json([
            'message' => 'Employee deleted successfully.',
        ]);
    }

    public function employeeList()
    {
        $employees = Employee::all();
        return response()->json([
            'employees' => $employees,
        ]);
    }

    public function employeeInfo()
    {
        $employeeId = auth()->id();

        if (!$employeeId) {
            return response()->json([
                'message' => 'User not authenticated'
            ], 401);
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

    public function employeeSearchWithName(Request $request)
    {
        $name = $request->input('name');
        $surname = $request->input('surname');

        if ($name && $surname) {
            $employees = Employee::where('name', 'like', '%' . $name . '%')
                ->where('surname', 'like', '%' . $surname . '%')
                ->get(); // get() metodu butun sutunlari ceker

            if (!$employees || $employees->isEmpty()) {
                return response()->json([
                    'message' => 'Employee not found',
                ], 400);
            }

            return response()->json([
                'employees' => $employees,
            ]);
        }

        return response()->json([
            'message' => 'Ad-Soyad bilgisi girilmelidir.'
        ], 400);


    }

    public function employeeSearchWithId(Request $request)
    {
        $id = $request->input('id');
        if ($id) {
            $employees = Employee::where('id', $id)->first();

            if (!$employees) {
                return response()->json([
                    'message' => 'Employee not found',
                ], 404);
            }

            return response()->json([
                'employees' => [$employees], // dizi olarak dondurduk ki java tarafinda name ile arama yapilan classi ortak kullanalim
            ]);
        }
        return response()->json([
            'message' => 'Ad-Soyad bilgisi girilmelidir.'
        ]);


    }


    public function transactions(Request $request, $transactionName = null)
    {
        return match ($transactionName) {
            'create' => $this->employeeInsert($request),
            'update' => $this->employeeUpdate(),
            'delete' => $this->employeeDelete($request),
            default => response()->json(['message' => 'Invalid transaction name'], 404),
        };
    }
}
