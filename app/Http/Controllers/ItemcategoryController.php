<?php

namespace App\Http\Controllers;

use App\Models\itemcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use DB;

class ItemcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Datatables::of($this->get_allData())
                            ->addColumn('actions', function($row){
                                $html = "<td align='center'>";
                                    $html .= '<button type = "button" data-id = '.$row->id.' class = "btn btn-sm btn-primary edit"><i class = "fas fa-edit"></i>&nbsp;</button>&nbsp;&nbsp;';
                                    if($row->status == 0)
                                        $html .= '<button type = "button" data-id = '.$row->id.' class = "btn btn-sm btn-primary activate"><i class = "fas fa-unlock"></i>&nbsp;</button>&nbsp;&nbsp;';
                                    if($row->status == 1)
                                        $html .= '<button type = "button" data-id = '.$row->id.' class = "btn btn-sm btn-danger deactivate"><i class = "fas fa-lock"></i>&nbsp;</button>&nbsp;&nbsp;';
                                $html .= "</td>";
                                return $html;
                            })
                            ->rawColumns(['actions'])
                            ->make(true);
    }
    public function get_categoriesByJson()
    {
        return response()->json($this->get_allData());
    }
    public function get_allData()
    {
        return ItemCategory::all();
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
    public function countItems()
    {
        $sql = DB::select("SELECT COUNT(supplier_items.id) AS totalItems, category
                            FROM itemcategories, supplier_items
                            WHERE itemcategories.id = supplier_items.category_id
                            GROUP BY itemcategories.category");
        return response()->json($sql);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $status = false; $msg = ""; $validatedData = [];
        if($request->category_id !== null)
        {
            $validatedData = [
                'category' => 'required|unique:itemcategories,category,'.$request->category_id.',id',
            ];
        }
        else
        {
            $validatedData = [
                'category' => 'required|min:5|unique:itemcategories',
            ];
        }

        $validator = Validator::make($request->all(), $validatedData);

        if($validator->fails())
            $msg = $validator->messages();
        else
        {
            ItemCategory::updateOrCreate(['id'=>$request->category_id], [
                'category' => strtoupper($request->category),
                'status' => 1,
            ]);
            $status = true; $msg = "Category has been successfully saved!";
        }

        return response()->json(['status'=>$status, 'messages'=>$msg]);
    }

    /**
     * Display the specified resource.
     */
    public function show(itemcategory $itemcategory)
    {
        return response()->json($itemcategory);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(itemcategory $itemcategory)
    {
        $itemcategory->status = 1;
        $itemcategory->update();
        return response()->json(['status'=>true,'messages'=>'Successfully Activated!']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, itemcategory $itemcategory)
    {
        //  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(itemcategory $itemcategory)
    {
        $itemcategory->status = 0;
        $itemcategory->update();
        return response()->json(['status'=>true,'messages'=>'Successfully Deactivated!']);
    }
}
