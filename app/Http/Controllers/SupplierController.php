<?php

namespace App\Http\Controllers;

use App\Models\supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use DB;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Datatables::of($this->get_allData())
                            ->addColumn('actions', function($row){
                                $html = "<td align='center'>";
                                $html .= '<button type = "button" data-id = '.$row->id.' class = "btn  btn-primary btn-sm edit"><i class = "fas fa-edit"></i>&nbsp;</button>&nbsp;&nbsp;';
                                $html .= "</td>";
                                return $html;
                            })      
                            ->rawColumns(['actions'])
                            ->make(true);
    }
    public function get_allData()
    {
        return Supplier::all();
    }
    public function get_allDataByJson()
    {
        return response()->json($this->get_allData());
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
        $status = false; $msg = ""; $validatedData = [];
        if($request->supplier_id !== null)
        {
            $validatedData = [
                'name' => 'required|unique:suppliers,name,'.$request->supplier_id.',id',
                'contact_number'=>'required|min:10|max:10',
                'address'=>'required|min:6',
                'vatReg'=>'required',
                'tin'=>'required',
            ];
        }
        else
        {
            $validatedData = [
                'name' => 'required|min:5|unique:suppliers',
                'contact_number'=>'required|min:10|max:10',
                'address'=>'required|min:6',  
                'vatReg'=>'nullable|min:6',
                'tin'=>'nullable|numeric',
            ];
        }

        $validator = Validator::make($request->all(), $validatedData);

        if($validator->fails())
            $msg = $validator->messages();
        else
        {
            Supplier::updateOrCreate(['id'=>$request->supplier_id], [
                'name' => strtoupper($request->name),
                'contact_number' => $request->contact_number,
                'address'=>strtoupper($request->address),
                'vatReg' => $request->vatReg,   
                'tin'=>$request->tin,   
            ]);
            $status = true; $msg = "Supplier has been successfully saved!";
        }

        return response()->json(['status'=>$status, 'messages'=>$msg]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return response()->json($supplier);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        $supplier->update();
        return response()->json(['status'=>true,'messages'=>'Successfully Activated!']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        //  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->status = 0;
        $supplier->update();
        return response()->json(['status'=>true,'messages'=>'Successfully Deactivated!']);
    }
}
