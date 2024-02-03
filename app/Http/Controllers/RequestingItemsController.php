<?php

namespace App\Http\Controllers;

use App\Models\RequestingItems;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;
use Carbon\Carbon;
use App\Models\Movements;
class RequestingItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.requestingItems');
    }
    public function requesteditems_report($dateRequest, $user_id)
    {
        $data = DB::select('select distinct movements.status as req_status, items.*, supplier_items.*, suppliers.*, movements.*, users.*, users.id as purchaser_id, positions.*, departments.*
                                from positions, departments, users, movements, items, supplier_items, suppliers
                                where departments.id = users.department_id
                                and positions.id = users.position_id
                                and items.id = supplier_items.item_id
                                and suppliers.id = supplier_items.supplier_id
                                and supplier_items.id = movements.supplieritem_id
                                and movements.user_id = users.id
                                and movements.user_id = '.$user_id.' and date(movements.created_at) = "'.$dateRequest.'" and movements.type = 3 order by movements.created_at desc ');
        return view('reports.requestingitems', compact('data'));
    }
    public function datatable()
    {
        return Datatables::of($this->get())
                ->addColumn('action', function($data){
                    $html = "";
                    if($data['notification'] == 1)
                    $html = "<button class = 'btn btn-warning btn-sm btn-flat view' data-user_id = ".$data['purchaser_id']." data-date = ".$data['dateRequest']." /><i class = 'fas fa-eye'>".$data['notification']."</i>";
                    if($data['notification'] == 0)
                    $html = "<button class = 'btn btn-primary btn-sm btn-flat view' data-user_id = ".$data['purchaser_id']." data-date = ".$data['dateRequest']." /><i class = 'fas fa-eye'>".$data['notification']."</i>";
                    
                    return $html;
                })
                ->addColumn('dateRequest', function($data){
                    return date('m-d-Y', strtotime($data['dateRequest']));
                })
                ->rawColumns(['action', 'status', 'dateRequest'])
                ->make(true);
    }
    public function realtime_notification()
    {
        $notif = Movements::where('notification', 1)->count();
        $lowstock = DB::select("SELECT supplier_items.id as lowstocks, items.*, supplier_items.* from supplier_items, items where items.id = supplier_items.item_id and supplier_items.stock <=5 order by supplier_items.updated_at desc");
        $years = DB::select("SELECT TIMESTAMPDIFF(YEAR, supplier_items.date, CURDATE())  AS age, id, no_ofYears FROM supplier_items");
        foreach($years as $y)
        {
            if($y->age > 0)
            {
                if($y->age >= $y->no_ofYears)
                { 
                    DB::table('supplier_items')->where('id', $y->id)->update(array('status'=>0));
                    $exists = Movements::where('supplieritem_id')->exists();
                    DB::table('movements')->where('supplieritem_id', $y->id)->update(array('dateWasted'=>Carbon::now()));
                }
            }
        }
        $data = ['notif'=>$notif, 'lowstock'=>count($lowstock), 'lowstocks'=>$lowstock];
        return response()->json($data);
    }
    public function resetNotification(Request $request)
    {
        $result = DB::select('select * from movements where date(created_at) = "'.date('Y-m-d', strtotime($request->dateRequest)).'" and notification = 1 and user_id = '.$request->user_id.'');
        foreach($result as $res)
        {
             $r = DB::table('movements')->where([
                    'id'=>$res->id,
                 ])->update(['notification'=>0]);
        }
        return response()->json([
            'data'=>$result,
            'status'=>true,
        ]);
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }
    public function show(RequestingItems $requestingItems)
    {
        //
    }   
    public function get_requestingItemsData()
    {
        $sql = DB::select('select distinct date(movements.created_at) as dateRequest, user_id from movements order by date(movements.created_at) desc');
        return $sql;
    }
    public function get_allUserInfo($user_id)
    {
        $sql = DB::select('select users.*, users.id as purchaser_id, positions.*, departments.*
                        from positions, departments, users
                        where departments.id = users.department_id
                        and positions.id = users.position_id
                        and users.id = '.$user_id.'');
        return $sql;
    }
    public function get()
    {
        $data = [];
        foreach($this->get_requestingItemsData() as $req)
        {
            $result = DB::select('select * from movements where date(movements.created_at) = "'.$req->dateRequest.'" and user_id = '.$req->user_id.'');
            $notification = 0;
            foreach($result as $notif)
            {
                if($notif->notification == 1) $notification = 1;
            }
            $userinfo = $this->get_allUserInfo($req->user_id);
            $data[] = [
              'purchaser_id'=>$req->user_id,
              'dateRequest'=>$req->dateRequest,
              'fullname'=>$userinfo[0]->fullname,
              'notification'=>$notification,
              'department_name'=>$userinfo[0]->department_name,
            ];
        }
        return $data;
    }
    public function get_purchaserRequest(Request $request, $user_id)
    {
        $data = DB::select('select distinct movements.id as movement_id, movements.status as req_status, items.*, supplier_items.*, suppliers.*, movements.*, users.*, users.id as purchaser_id, positions.*, departments.*, movements.created_at as dateTransact
                                from positions, departments, movements, users, items, supplier_items, suppliers
                                where departments.id = users.department_id
                                and positions.id = users.position_id
                                and items.id = supplier_items.item_id
                                and suppliers.id = supplier_items.supplier_id
                                and supplier_items.id = movements.supplieritem_id
                                and users.id = movements.user_id
                                and movements.user_id = '.$user_id.' and date(movements.created_at) = "'.$request->dateRequest.'" order by movements.created_at desc');
        return response()->json($data);
    }
    public function get_current()
    {
        $data = DB::select('select distinct users.*, users.id as purchaser_id, movements.id as req_id, date(movements.created_at) as date, departments.*
                            from users, movements, departments
                            where users.id = movements.user_id
                            and departments.id = users.department_id
                            order by movements.created_at asc');

        return $data;
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RequestingItems $requestingItems)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RequestingItems $requestingItems)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestingItems $requestingItems)
    {
        //
    }
}
