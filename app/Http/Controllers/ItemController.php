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
use Response;

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
                    $html = "<input class = 'checkboxes' style = 'width: 20px; height: 20px;' type = 'checkbox' name = 'itemCheck' id = 'itemCheck' data-supplieritem_id=".$row->supplieritem_id." value = '".$row->supplieritem_id."' />";
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
                        WHERE itemcategories.id = supplier_items.category_id 
                        AND items.id = supplier_items.item_id
                        AND suppliers.id = supplier_items.supplier_id');
        return $sql;
    }
    public function get_allSupplierItems()
    {
        $sql = DB::select('SELECT supplier_items.id as supplieritem_id, items.*, itemcategories.*, suppliers.*, supplier_items.*
                        FROM items, suppliers, supplier_items, itemcategories
                        WHERE itemcategories.id = supplier_items.category_id 
                        AND items.id = supplier_items.item_id
                        AND suppliers.id = supplier_items.supplier_id
                        AND supplier_items.status = 1');
        return response()->json($sql);
    }
    public function get_allUsersByJson()
    {
        $sql = DB::select('select users.*, users.id as user_id, positions.*, departments.*
                            from positions, departments, users
                            where departments.id = users.department_id
                            and positions.id = users.position_id');
       return Response::json($sql);
    }
    public function supplier_allItems()
    {
        $sql = DB::select('SELECT supplier_items.id as supplieritem_id, items.*, itemcategories.*, suppliers.*, supplier_items.*
                        FROM items, suppliers, supplier_items, itemcategories
                        WHERE itemcategories.id = supplier_items.category_id 
                        AND items.id = supplier_items.item_id
                        AND suppliers.id = supplier_items.supplier_id
                        AND supplier_items.status = 1');
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
            ])->first();
         

            $image_name = "";
            $image = $request->file('image');
            $temp = "";
            $item_id = "";
            if($image !== null)
            {
                $image_name = $image->getClientOriginalName();
                $image->move(public_path('upload_images'), $image_name);
            }
            if(!empty($request->item_id))
            {
                $toUpdate = [];
                if(is_null($image))
                {
                    $toUpdate = [
                        'item'=>strtoupper($request->item),
                        'unit'=>strtoupper($request->unit),
                        'brand'=>strtoupper($request->brand),
                    ];
                }
                else
                {
                    $toUpdate = [
                        'item'=>strtoupper($request->item),
                        'unit'=>strtoupper($request->unit),
                        'brand'=>strtoupper($request->brand),
                        'image'=>$image_name,
                    ];
                }

                $u_item = DB::table('items')
                        ->where('id',$request->item_id)
                        ->update($toUpdate);
                $item_id = $request->item_id;

            }
            else
            {
                if($item === null)
                {
                    $item = new Item;
                    $item->item = strtoupper($request->item);
                    $item->unit = strtoupper($request->unit);
                    $item->brand= strtoupper($request->brand);
                    $item->image= $image_name;
                    $item->save();
                    $item_id = $item->id;
                }
                else {
                    $item_id = $item->id;
                    $temp = 1;
                    $status = false;
                    $messages = "The item already exists!";
                }
            }
           
               
            $isExists = SupplierItem::where([
                'item_id'=>$item_id,
                'category_id'=>$request->itemcategory_id,
                'supplier_id'=>$request->supplier,
            ])->exists();
            
            if($isExists)
            {
                $item_id = $item->id;
                $temp = 2;
                $status = false;
                $messages = "The item already exists!";
            }
            $supplieritem = SupplierItem::updateOrCreate(['id'=>$request->supplieritem_id], [
                'supplier_id' => $request->supplier,
                'item_id' => $item_id,
                'serialnumber' => $request->serialnumber,
                'modelnumber' => $request->modelnumber,
                'stock' => $request->stock,
                'no_ofYears' => $request->no_ofYears,
                'category_id' => $request->itemcategory_id, 
                'quantity' => $request->quantity, 
                'cost' => $request->cost,
                'totalCost' => $request->totalCost, 
                'remarks' => $request->remarks,
                'status'=>1,
            ]);
            if($temp == 1) 
            {
                $status = false;
                $messages = ['item'=>$messages,'brand'=>$messages];
            }
            if($temp == 2) 
            {
                $status = false;
                $messages = ['item'=>$messages,
                            'brand'=>$messages,
                            'itemcategory_id'=>$messages,
                            'supplier'=>$messages];
            }
            else 
            {
                $messages = "Item has been successfully saved!";
                $status = true;
            }
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
        $sql = DB::select('SELECT TIMESTAMPDIFF(YEAR, date(supplier_items.created_at), CURDATE())  AS age, suppliers.contact_number as supp_contactNo, suppliers.id as supplier_id, items.*, itemcategories.*, suppliers.*, supplier_items.*, itemcategories.id as itemcategory_id, items.id as item_id, supplier_items.id as supplieritem_id
                        FROM items, suppliers, supplier_items, itemcategories
                        WHERE itemcategories.id = supplier_items.category_id 
                        AND items.id = supplier_items.item_id
                        AND suppliers.id = supplier_items.supplier_id
                        AND supplier_items.id = '.$item_id.'');

        return response()->json($sql);
    }   

    public function purchaserEdit($item_id)
    {
        $sql = DB::select('SELECT  date(supplier_items.created_at) as transactedOn, suppliers.contact_number as supp_contactNo, suppliers.id as supplier_id, items.*, itemcategories.*, suppliers.*, supplier_items.*, itemcategories.id as itemcategory_id, items.id as item_id, supplier_items.id as supplieritem_id
                        FROM items, suppliers, supplier_items, itemcategories
                        WHERE itemcategories.id = supplier_items.category_id 
                        AND items.id = supplier_items.item_id
                        AND suppliers.id = supplier_items.supplier_id
                        AND supplier_items.id = '.$item_id.'');
        
        // $requestItem = DB::select('select users.*, users.id as purchaser_id, positions.*, departments.*, requesting_items.*, requesting_items.id as requestingitem_id
        //                         from positions, departments, users, requesting_items, movements
        //                         where departments.id = users.department_id
        //                         and positions.id = users.position_id
        //                         and movements.id = requesting_items.movement_id
        //                         and users.id = requesting_items.user_id
        //                         and movements.id = "'.$sql[0]->movement_id.'"');
        $data = [
            'item'=>$sql,
            // 'requestItem'=>$requestItem,
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
            
            Movements::create([
                'supplieritem_id'=>$selectedItems[$i]['supplieritem_id'],
                'user_id'=>Auth::user()->id,
                'qty'=>$selectedItems[$i]['itemQty'],
                'notification'=>1,
                'status'=>1,
            ]);
        }

        return response()->json([
            'status'=>true,
            'message'=>'Your items has been successfully processed!'
        ]);
    }
}
