<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Item;
use App\Models\Supplier_Items;
use App\Models\Movements;
use App\Models\RequestingItems;
class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'itemCount'=>Supplier_Items::count(),
            'no_ofPurchased' => $this->count_noOfPurchased(),
            'no_ofDelivered' => $this->count_noOfDelivered(),
            'no_ofRequisition' => $this->count_noOfRequisition(),
        ];

        $years_ofPurchasedLabel = [];
        $values_ofPurchased = [];
        $years = DB::select('select supplier_items.id, items.item, suppliers.name from items, supplier_items, suppliers where items.id = supplier_items.item_id and suppliers.id = supplier_items.supplier_id order by suppliers.id asc');
        foreach($years as $year)
        {
            $years_ofPurchasedLabel[] = $year->item." - ".$year->name;
            $values = DB::select('select count(movements.user_id) as total
                                from users, movements, supplier_items, items
                                where items.id = supplier_items.item_id
                                and supplier_items.id = movements.supplieritem_id
                                and movements.user_id = users.id
                                and supplier_items.id = '.$year->id.'');

            $values_ofPurchased[] = $values[0]->total;
        }

        $years_ofReleasedLabel = [];
        $values_ofReleased = [];
        $years_r = DB::select('SELECT DISTINCT YEAR(movements.created_at) as year 
            FROM movements WHERE type = 3 ORDER BY YEAR(movements.created_at) asc');

        foreach($years_r as $year)
        {
            $years_ofReleasedLabel[] = $year->year;
            $values = DB::select('SELECT count(items.id) as total
            FROM items
            INNER JOIN supplier_items on supplier_items.item_id = items.id
            INNER JOIN movements on movements.supplieritem_id = supplier_items.id and movements.type = 3 and YEAR(movements.created_at) = "'.$year->year.'"');

            $values_ofReleased[] = $values[0]->total;
        }
    
        return view('pages.home', compact('data', 'years_ofPurchasedLabel', 'values_ofPurchased', 'years_ofReleasedLabel', 'values_ofReleased'));       
    }
    public function get_allYears()
    {
        $sql = DB::select('SELECT DISTINCT YEAR(date) as year 
                        FROM movements WHERE type = 3');
        return $sql;
    }

    public function count_noOfPurchased()
    {
        $sql = Movements::where('type', 2)->count();
        return $sql;
    }
    public function count_noOfDelivered()
    {
        $sql = RequestingItems::where('status', 2)->count();
        return $sql;
    }
    public function count_noOfRequisition()
    {
        $sql = RequestingItems::where('status', 1)->count();
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
