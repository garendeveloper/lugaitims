<?php

namespace App\Http\Controllers;

use App\Models\item;
use App\Models\Supplier_Items as SupplierItem;
use App\Models\Movements;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\DataTables;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\RequestingItems;
use Carbon\Carbon;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return view('pages.items');
    }
    public function get_myRequestedItems()
    {
       return Datatables::of($this->get_requestedItems())
                ->addColumn('status', function($row) {
                    $html = "<span class = 'badge badge-danger'>CANCELLED</span>";
                    if($row->req_status == 1) $html = "<span class = 'badge badge-primary'>REQUESTING</span>";
                    if($row->req_status == 2) $html = "<span class = 'badge badge-success'>APPROVED</span>";
                    return $html;  
                })->rawColumns(['status'])->make(true);
    }
    public function get_allItemsInDatatables()
    {
        return DataTables::of($this->get_allItems())
                ->addColumn('type', function($row){
                    $html = "";
                    if($row->status==0) $html = "<span class = 'badge badge-warning'>WASTED</span>";
                    if($row->status==1) $html = "<span class = 'badge badge-primary'>ACTIVE</span>";
                    return $html;   
                })      
                ->addColumn('checkboxes', function($row){
                    $html = "<input class = 'checkboxes' style = 'width: 20px; height: 20px;' type = 'checkbox' name = 'itemCheck' id = 'itemCheck' data-supplieritem_id=".$row->supplieritem_id."/>";
                    return $html;
                })
                ->addColumn('cost', function($row){
                    return $html = "&#8369;&nbsp;".number_format((float)$row->cost, 2, '.', ',');
                })
                ->addColumn('totalCost', function($row){
                    return $html = "&#8369;&nbsp;".number_format((float)$row->totalCost, 2, '.', ',');
                })
                ->addColumn('actions', function($row){
                    $html = "<td style = 'display: block; margin: auto; text-align:center'>";
                    $html = '<button type = "button" data-id = '.$row->supplieritem_id.' class = "btn  btn-flat btn-outline btn-primary btn-sm edit"><i class = "fas fa-xs fa-edit"></i>&nbsp;</button>&nbsp;';
                    $html .= '<button type = "button" data-id = '.$row->supplieritem_id.' class = "btn  btn-flat btn-outline btn-secondary btn-sm view"><i class = "fas fa-xs fa-eye"></i>&nbsp;</button>&nbsp;';
                    $html .= "</td>";
                    return $html;
                }) 
                ->rawColumns(['type','checkboxes','actions', 'cost', 'totalCost'])
                ->make(true);
    }
    public function get_allItems()
    {
        $sql = DB::select('SELECT supplier_items.id as supplieritem_id, items.*, itemcategories.*, suppliers.*, supplier_items.*
                        FROM items, suppliers, supplier_items, itemcategories
                        WHERE itemcategories.id = items.itemcategory_id 
                        AND items.id = supplier_items.item_id
                        AND suppliers.id = supplier_items.supplier_id');
        return $sql;
    }
    public function get_allSupplierItems()
    {
        $sql = DB::select('SELECT movements.id as movement_id, items.*, itemcategories.*, suppliers.*, supplier_items.*, movements.*
                        FROM items, suppliers, supplier_items, itemcategories, movements
                        WHERE itemcategories.id = items.itemcategory_id 
                        AND items.id = supplier_items.item_id
                        AND suppliers.id = supplier_items.supplier_id
                        AND movements.supplieritem_id = supplier_items.id');
        return response()->json($sql);
    }
    public function get_allItemOnly()
    {
        $data = Item::select('item')->distinct()->get();
        return response()->json($data);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function saveItem(Request $request)
    {
        return response()->json($request->all());
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages; $status="";
        $validatedData = [
            'item'=>'required',
            'unit'=>'required',
            'brand'=>'required',
            'itemcategory_id'=>'required',
            'supplier'=>'required',
            'requisition'=>'required',
            'quantity'=>'required',
            'cost'=>'required',
            'stock'=>'required',
            'totalCost'=>'required',
            'serialnumber'=>'nullable|string',
            'modelnumber'=>'nullable|string',
            'remarks'=>'nullable|string|min:6',
            'no_ofYears'=>'nullable|min:1',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048|unique:items,image',
        ];

        $validator = Validator::make($request->all(), $validatedData);
        if($validator->fails())
        {
            $messages = $validator->messages();
        }   
        else
        {
            $item = Item::where([
                'item'=>$request->item,
                'brand'=>$request->brand,
                'itemcategory_id'=>$request->itemcategory_id,
            ])->first();
            
            $image_name = "";
            $image = $request->file('image');
            if($image !== null)
            {
                // $new_name = rand() . '.' . $image->getClientOriginalExtension();
                $image_name = $image->getClientOriginalName();
                $image->move(public_path('upload_images'), $image_name);
            }
            if(is_null($item))
            {
                $item = Item::create([
                    'item'=>strtoupper($request->item),
                    'unit'=>$request->unit,
                    'brand'=>strtoupper($request->brand),
                    'itemcategory_id'=>$request->itemcategory_id,
                    'image'=>$image_name,
                ]);
            }
            else
            {
                $toUpdate = [];
                if(is_null($image))
                {
                    $toUpdate = [
                        'item'=>strtoupper($request->item),
                        'unit'=>$request->unit,
                        'brand'=>strtoupper($request->brand),
                        'itemcategory_id'=>$request->itemcategory_id,
                    ];
                }
                else
                {
                    $toUpdate = [
                        'item'=>strtoupper($request->item),
                        'unit'=>$request->unit,
                        'brand'=>strtoupper($request->brand),
                        'itemcategory_id'=>$request->itemcategory_id,
                        'image'=>$image_name,
                    ];
                }

                $u_item = DB::table('items')
                        ->where('id',$item->id)
                        ->update($toUpdate);
            }

            $supplieritem = SupplierItem::where([
                'item_id'=>$item->id,
                'supplier_id'=>$request->supplier,
            ])->first();
            if(is_null($supplieritem))
            {
                $supplieritem = new SupplierItem;
                $supplieritem->supplier_id = $request->supplier;
                $supplieritem->item_id = $item->id;
                $supplieritem->serialnumber = $request->serialnumber;
                $supplieritem->modelnumber = $request->modelnumber;
                $supplieritem->stock = $request->stock;
                $supplieritem->no_ofYears = $request->no_ofYears;
                $supplieritem->save();
            }
            else
            {
                $supplieritem = SupplierItem::find($supplieritem->id);
                $supplieritem->supplier_id = $request->supplier;
                $supplieritem->item_id = $item->id;
                $supplieritem->serialnumber = $request->serialnumber;
                $supplieritem->modelnumber = $request->modelnumber;
                $supplieritem->stock = $request->stock;
                $supplieritem->no_ofYears = $request->no_ofYears;
                $supplieritem->update();
            }
            $movement_id = "";
            $type = $request->requisition == 1 ? 2 : 2;
            if($request->item_id !== null)
            {
                $dataToUpdate = [
                    'date'=>$request->date,
                    'supplieritem_id'=>$supplieritem->id,
                    'lastAction'=>Auth::user()->fullname,
                    'quantity'=>$request->quantity,
                    'cost'=>$request->cost,
                    'totalCost'=>$request->totalCost,
                    'status'=>1,
                    'remarks'=>$request->remarks,
                    'updated_at'=>Carbon::now()->toDateTimeString(),
                ];

                $m = DB::table('movements')
                        ->where('id', $request->movement_id)
                        ->update($dataToUpdate);

                $movement_id = $request->movement_id;
            } 
            else
            {
                $movement_id = DB::table('movements')->insertGetID([
                    'supplieritem_id'=>$supplieritem->id,
                    'date'=>$request->date,
                    'lastAction'=>Auth::user()->fullname,
                    'quantity'=>$request->quantity,
                    'cost'=>$request->cost,
                    'totalCost'=>$request->totalCost,
                    'status'=>1,
                    'type'=>$type,
                    'remarks'=>$request->remarks,
                    'datePurchased'=>Carbon::now(),
                    'created_at'=>Carbon::now()->toDateTimeString() ,
                ]);
            }

            if($request->requisition !== "")
            {
                RequestingItems::updateOrCreate(['id'=>$request->requisitionItem_id], [
                    'user_id'=>$request->requisition,
                    'movement_id'=>$movement_id,
                    'qty'=>0,
                ]); 
            }
            $messages = "Item has been successfully saved!";
            $status = true;
        }

        return response()->json([
            'status'=>$status,
            'messages'=>$messages,
        ]);
    }
    public function get_allUnits()
    {
        return response()->json(Item::select('unit')->distinct()->get());
    }
    public function get_allBrands()
    {
        return response()->json(Item::select('brand')->distinct()->get());
    }
    /**
     * Display the specified resource.
     */
    public function show(item $item)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($item_id)
    {
        $sql = DB::select('SELECT TIMESTAMPDIFF(YEAR, date(supplier_items.created_at), CURDATE())  AS age, date(movements.created_at) as transactedOn, suppliers.contact_number as supp_contactNo, suppliers.id as supplier_id, items.*, itemcategories.*, suppliers.*, supplier_items.*, movements.*,movements.id as movement_id, itemcategories.id as itemcategory_id, items.id as item_id, supplier_items.id as supplieritem_id
                        FROM items, suppliers, supplier_items, movements, itemcategories
                        WHERE itemcategories.id = items.itemcategory_id 
                        AND items.id = supplier_items.item_id
                        AND suppliers.id = supplier_items.supplier_id
                        AND supplier_items.id = movements.supplieritem_id
                        AND supplier_items.id = '.$item_id.'');
        
        $requestItem = DB::select('select users.*, users.id as purchaser_id, positions.*, departments.*, requesting_items.*, requesting_items.id as requestingitem_id
                                from positions, departments, users, requesting_items, movements
                                where departments.id = users.department_id
                                and positions.id = users.position_id
                                and movements.id = requesting_items.movement_id
                                and users.id = requesting_items.user_id
                                and movements.id = "'.$sql[0]->movement_id.'"');
        $data = [
            'item'=>$sql,
            'requestItem'=>$requestItem,
        ];
        return response()->json($data);
    }   

    public function purchaserEdit($item_id)
    {
        $sql = DB::select('SELECT  date(movements.created_at) as transactedOn, suppliers.contact_number as supp_contactNo, suppliers.id as supplier_id, items.*, itemcategories.*, suppliers.*, supplier_items.*, movements.*,movements.id as movement_id, itemcategories.id as itemcategory_id, items.id as item_id, supplier_items.id as supplieritem_id
                        FROM items, suppliers, supplier_items, movements, itemcategories
                        WHERE itemcategories.id = items.itemcategory_id 
                        AND items.id = supplier_items.item_id
                        AND suppliers.id = supplier_items.supplier_id
                        AND supplier_items.id = movements.supplieritem_id
                        AND supplier_items.id = '.$item_id.'');
        
        $requestItem = DB::select('select users.*, users.id as purchaser_id, positions.*, departments.*, requesting_items.*, requesting_items.id as requestingitem_id
                                from positions, departments, users, requesting_items, movements
                                where departments.id = users.department_id
                                and positions.id = users.position_id
                                and movements.id = requesting_items.movement_id
                                and users.id = requesting_items.user_id
                                and movements.id = "'.$sql[0]->movement_id.'"');
        $data = [
            'item'=>$sql,
            'requestItem'=>$requestItem,
        ];
        return response()->json($data);
    }   

    public function get_RequestedItems()
    {
        $user_id = Auth::user()->id;

        $requestItem = DB::select('select requesting_items.status as req_status, items.*, supplier_items.*, suppliers.*, movements.*, users.*, users.id as purchaser_id, positions.*, departments.*, requesting_items.*, requesting_items.id as requestingitem_id, requesting_items.created_at as dateTransact
                                from positions, departments, users, requesting_items, movements, items, supplier_items, suppliers
                                where departments.id = users.department_id
                                and positions.id = users.position_id
                                and users.id = requesting_items.user_id
                                and items.id = supplier_items.item_id
                                and suppliers.id = supplier_items.supplier_id
                                and supplier_items.id = movements.supplieritem_id
                                and movements.id = requesting_items.movement_id
                                and users.id = requesting_items.user_id
                                and users.id = '.$user_id.'');

        return $requestItem;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(item $item)
    {
        $status=false; $message;
        if($item !== null)  
        {
            $item->delete();
            $status = true;
            $message = "Item has been successfully removed";
        }
        else $message = "Cannot find id or cannot be removed.";
       
        return response()->json([
            'status'=>$status,
            'message'=>$message,
        ]);
    }
    public function save_cart(Request $request)
    {
        $selectedItems = $request->selecteditems;
        for($i = 0; $i<count($selectedItems); $i++)
        {
            $supplieritem = SupplierItem::find($selectedItems[$i]['supplieritem_id']);
            $supplieritem->stock = $supplieritem->stock-$selectedItems[$i]['itemQty'];
            $supplieritem->update();
            RequestingItems::create([
                'movement_id'=>$selectedItems[$i]['movement_id'],
                'user_id'=>Auth::user()->id,
                'qty'=>$selectedItems[$i]['itemQty'],
                'notification'=>1,
                'status'=>1,
            ]);
        }

        return response()->json([
            'status'=>true,
            'message'=>'You items has been successfully pr ocessed!'
        ]);
    }
}
