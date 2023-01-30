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
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function create(Employee $employee)
    {
        //
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee, Salary $salary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee, Salary $salary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee, Salary $salary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee, Salary $salary)
    {
        //
    }
}
