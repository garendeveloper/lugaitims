<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Item;
use App\Models\Supplier_Items;
use App\Models\Movements;
use App\Models\RequestingItems;
use App\Models\ItemCategory;
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
        $years = DB::select('select supplier_items.id, items.item, suppliers.name from items, supplier_items, suppliers where items.id = supplier_items.item_id and suppliers.id = supplier_items.supplier_id');
        $max = 0;
        foreach($years as $year)
        {
            $years_ofPurchasedLabel[] = $year->item." - ".$year->name;
            $values = DB::select('select count(movements.user_id) as total
                                from users, movements, supplier_items, items
                                where items.id = supplier_items.item_id
                                and supplier_items.id = movements.supplieritem_id
                                and movements.user_id = users.id
                                and supplier_items.id = '.$year->id.' order by total desc');

            $values_ofPurchased[] = $values[0]->total;
        }

        $years_ofReleasedLabel = [];
        $values_ofReleased = [];
        $years_r = DB::select('SELECT DISTINCT YEAR(movements.created_at) as years , QUARTER(movements.created_at) as quarters
            FROM movements WHERE type = 3 ORDER BY YEAR(movements.created_at) asc');

        foreach($years_r as $year)
        {
            $amount_total = DB::select('select SUM(supplier_items.cost*movements.qty) as accumulated from supplier_items, movements where supplier_items.id = movements.supplieritem_id and QUARTER(movements.created_at) = "'.$year->quarters.'" and YEAR(movements.created_at) = "'.$year->years.'" and movements.type = 3');
            $acc = $amount_total[0]->accumulated;
            if($acc === null)
            {
               $acc = 0;
            }
            $total = " P ".number_format((float)$acc, 2, '.', ',');
            $years_ofReleasedLabel[] = $year->years." - Q".$year->quarters." : ".$total;
            $values = DB::select('SELECT count(supplier_items.id) as total
            FROM items
            INNER JOIN supplier_items on supplier_items.item_id = items.id
            INNER JOIN movements on movements.supplieritem_id = supplier_items.id and movements.type = 3 and QUARTER(movements.created_at) = "'.$year->quarters.'" and YEAR(movements.created_at) = "'.$year->years.'" ');
            
            $values_ofReleased[] = $values[0]->total;
        }

        return view('pages.home', compact('data', 'years_ofPurchasedLabel', 'values_ofPurchased', 'years_ofReleasedLabel', 'values_ofReleased'));       
    }
    public function get_categorizedChart(Request $request)
    {
        
        if($request->ajax())
        {
            $category = ItemCategory::where('category',$request->category)->get();
            $years = DB::select('select supplier_items.id, items.item, suppliers.name from items, supplier_items, suppliers where items.id = supplier_items.item_id and suppliers.id = supplier_items.supplier_id and supplier_items.category_id = '.$category[0]->id.'');
            $years_ofPurchasedLabel = [];
            $values_ofPurchased = [];
            
            foreach($years as $year)
            {
                $years_ofPurchasedLabel[] = $year->item." - ".$year->name;
                $values = DB::select('select distinct count(users.id) as total
                                    from users, movements, supplier_items, items
                                    where items.id = supplier_items.item_id
                                    and supplier_items.id = movements.supplieritem_id
                                    and movements.user_id = users.id
                                    and supplier_items.id = '.$year->id.' and supplier_items.category_id = '.$category[0]->id.' order by total desc');

                $values_ofPurchased[] = $values[0]->total;
            }
            return response()->json([
                'labels'=>$years_ofPurchasedLabel,
                'values'=>$values_ofPurchased,
            ]);
        }
    }
    public function categorizedMostRequestedItems()
    {
        $sql = DB::select('SELECT supplier_items.* from supplier_items');
        return $sql;
    }
    public function get_allYears()
    {
        $sql = DB::select('SELECT DISTINCT YEAR(date) as year 
                        FROM movements WHERE type = 3');
        return $sql;
    }

    public function count_noOfPurchased()
    {
        $sql = Supplier_Items::where('status', 1)->count();
        return $sql;
    }
    public function count_noOfDelivered()
    {
        $sql = Movements::where('type', 3)->count();
        return $sql;
    }
    public function count_noOfRequisition()
    {
        $sql = Movements::where('type', 1)->count();
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
