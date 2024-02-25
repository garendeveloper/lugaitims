<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Yajra\Datatables\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.departments');
    }
    public function get_allDataInDatatables()
    {
        return DataTables::of($this->get_alldepartments())
                        ->addColumn('department_name', function($row){
                            $totalUsers = User::where('department_id', $row->id)->count();
                            return $row->department_name."&nbsp;&nbsp;<i class='fas fa-users'></i>&nbsp;&nbsp;".$totalUsers;
                        })
                        ->addColumn('actions', function($row){
                            $html = "<td align='center'>";
                            $html .= '<button type = "button" data-id = '.$row->id.' class = "btn  btn-primary btn-sm edit"><i class = "fas fa-edit"></i>&nbsp;</button>&nbsp;&nbsp;';
                            $html .= '<button type = "button" data-id = '.$row->id.' class = "btn btn-secondary  btn-sm createPurchaser"><i class = "fas fa-user-plus"></i>&nbsp;</button>';
                            $html .= "</td>";
                            return $html;
                        })      
                        ->rawColumns(['department_name', 'actions'])
                        ->make(true);
    }
    public function get_alldepartments()
    {
        return Department::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = []; $messages; $status="";
        if($request->dept_id !== null)
        {
            $validatedData = [
                'department_name'=>'required|unique:departments,department_name,'.$request->dept_id.',id',
            ];
            $messages = "Department has been successfully updated!";
        }
        else
        {
            $validatedData = [
                'department_name'=>'required|unique:departments',
            ];
            $messages = "Department has been successfully added!";
        }

        $validator = Validator::make($request->all(), $validatedData);
        if($validator->fails())
        {
            $messages = $validator->messages();
        }   
        else
        {
            Department::updateorCreate(['id'=>$request->dept_id], [
                'department_name'=>strtoupper($request->department_name),
            ]);
            $status = true;
        }

        return response()->json([
            'status'=>$status,
            'messages'=>$messages,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        return response()->json($department);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return response()->json($department);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        //
    }
}
