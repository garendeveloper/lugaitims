<?php

namespace App\Http\Controllers;

use App\Models\Requisition;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;
use App\Models\Movements;
use App\Models\Supplier_Items as SupplierItem;
use Illuminate\Support\Facades\Validator;

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
                            if($row->type == 6) $html = "<span class = 'badge badge-primary'>REQUESTING</span>";
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
        $validator  = Validator::make($request->all(), [
            'supplieritem' => 'required',
            'qty'=>'required|min:1',
            'requestor'=>'required',
        ]);
        $status=0; $message="";
        if($validator->fails())
        {
            $message = $validator->messages();
        }
        else
        {
            $supplieritem = SupplierItem::find($request->supplieritem);
            $message = "Sorry! Cannot process your request due to out of stock!";
            if($supplieritem->stock > 0)
            {
                if($supplieritem->stock >= $request->qty)
                {
                    $supplieritem->stock = $supplieritem->stock-$request->qty;
                    $supplieritem->update();
                    Movements::create([
                        'supplieritem_id'=>$request->supplieritem,
                        'user_id'=>$request->requestor,
                        'qty'=>$request->qty,
                        'notification'=>1,
                        'status'=>1,
                        'type'=>1,
                    ]);
                    $message='Request has been successfully processed!';
                    $status = 1;
                }
                else
                {
                    $message = "Sorry Invalid Quantity! Quantity must not be greater than stock!";
                    $status = 2;
                }
            }
        }

        return response()->json([
            'status'=>$status,
            'messages'=>$message,
        ]);
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
