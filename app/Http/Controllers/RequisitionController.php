<?php

namespace App\Http\Controllers;

use App\Models\Requisition;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

class RequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages._requisition');
    }
    public function get_datatable()
    {
        return Datatables::of($this->get_data())
                        ->addColumn('status', function($row){
                            $html = "<span class = 'badge badge-danger'>CANCELLED</span>";
                            if($row->type == 1) $html = "<span class = 'badge badge-primary'>REQUESTING</span>";
                            if($row->type == 2) $html = "<span class = 'badge badge-success'>APPROVED</span>";
                            return $html;  
                        })
                        ->addColumn('action', function($row){
                            return $html = "<button class = 'btn btn-primary btn-sm'><i class = 'fas fa-edit'></i></button>";
                        })
                        ->rawColumns(['status', 'action'])->make(true);
    }
    public function get_data()
    {
        // type = 6
        $sql = DB::select('select suppliers.*, items.*, supplier_items.*, movements.*, users.*, itemcategories.*
                                from suppliers, items, supplier_items, movements, users, itemcategories
                                where suppliers.id = supplier_items.supplier_id
                                and itemcategories.id = supplier_items.category_id
                                and items.id = supplier_items.item_id
                                and users.id = movements.user_id
                                and supplier_items.id = movements.supplieritem_id
                                and type = 6');
        return $sql;
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Requisition $requisition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Requisition $requisition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Requisition $requisition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requisition $requisition)
    {
        //
    }
}
