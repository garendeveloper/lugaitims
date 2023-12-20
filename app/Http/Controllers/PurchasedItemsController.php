<?php

namespace App\Http\Controllers;

use App\Models\purchased_items;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\DataTables;
use Illuminate\Support\Facades\Validator;

class PurchasedItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.purchasedItems');
    }

    public function get_allDataInDatatables()
    {
        return DataTables::of($this->get_allItems())
                ->addColumn('actions', function($row){
                    $html = "<td align='center'>";
                    $html = '<button type = "button" data-id = '.$row->id.' class = "btn btn-sm btn-primary edit"><i class = "fas fa-edit"></i>&nbsp;</button>';
                    $html .= '<button type = "button" data-id = '.$row->id.' class = "btn btn-sm btn-danger delete"><i class = "fas fa-trash"></i>&nbsp;</button>';
                    $html .= "</td>";
                    return $html;
                })      
                ->rawColumns(['actions'])
                ->make(true);
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
    public function show(purchased_items $purchased_items)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(purchased_items $purchased_items)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, purchased_items $purchased_items)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(purchased_items $purchased_items)
    {
        //
    }
}
