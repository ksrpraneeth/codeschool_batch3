<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalaryRequest;
use App\Http\Resources\SalaryCollection;
use App\Models\Employee;
use App\Models\Salary;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function index(Employee $employee)
    {
        return ["status" => true, "data" => SalaryCollection::collection($employee->salaries)];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function store(SalaryRequest $request, Employee $employee)
    {
        try {
            $salary = new Salary([
                "amount" => $request->amount,
                "date" => $request->date,
            ]);
            $newSalary = $employee->salaries()->save($salary);
            return ["status" => true, "data" => new SalaryCollection($newSalary)];
        } catch (\Throwable $error) {
            return ["status" => false, "message" => $error->getMessage()];
        }
    }
}
