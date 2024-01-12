<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Models\ItemCategory;
class PrintController extends Controller
{
    public function inspectionReport($item_id)
    {
        return view('pages.inspection');
    }
    public function filterReport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'itemtype'=>'required',
            'datefrom'=>'required',
            '_supplier'=>'required',
        ]);
        $status = 0; $message = ""; $url = "";
        if($validator->fails())
            $message = $validator->messages();
        else
        {
            $datefrom = date('Y-m-d', strtotime($request->datefrom));
            $data = $this->report_data($request->_supplier, $datefrom, $request->itemtype);
         
            if(empty($data)) 
            {
                $message = "No transaction on this date.";
                $status = 2;
            }
            else
            {
                $array = [
                    'datefrom'=>$datefrom,
                    'itemtype'=>$request->itemtype,
                    '_supplier'=>$request->_supplier,
                ];
                $array = serialize($array);
                $url = "/print/filter/report/page/".$array."";
                $status = 1;
            }
        }
        return response()->json([
            'status'=>$status,
            'messages'=>$message,
            'url'=>$url,
        ]);
    }
    public function itemprofile($supplieritem_id)
    {
        $sql = DB::select('SELECT TIMESTAMPDIFF(YEAR,supplier_items.date, CURDATE())  AS age, suppliers.contact_number as supp_contactNo, suppliers.id as supplier_id, items.*, itemcategories.*, suppliers.*, supplier_items.*, itemcategories.id as itemcategory_id, items.id as item_id, supplier_items.id as supplieritem_id
        FROM items, suppliers, supplier_items, itemcategories
        WHERE itemcategories.id = supplier_items.category_id 
        AND items.id = supplier_items.item_id
        AND suppliers.id = supplier_items.supplier_id
        AND supplier_items.id = '.$supplieritem_id.'');

        return view('reports.itemprofile', compact('sql'));
    }
    public function filterPage(Request $request, $data)
    {
        $unserializeArray = unserialize($data);
        $data = $this->report_data($unserializeArray['_supplier'], $unserializeArray['datefrom'], $unserializeArray['itemtype']);
        $userinfo = DB::select('select users.*, users.id as purchaser_id, positions.*, departments.*
                                from positions, departments, users
                                where departments.id = users.department_id
                                and positions.id = users.position_id
                                and users.id = '.$data[0]->user_id.'');
        return view('pages.requisition', compact('data', 'userinfo'));
    }
    public function report_data($supplier, $datefrom, $itemtype)
    {
        $sql = DB::select('SELECT suppliers.*, items.*, movements.*, users.*, departments.*, supplier_items.*
                        FROM suppliers, items, supplier_items, movements, users, departments
                        WHERE suppliers.id = supplier_items.supplier_id
                        AND items.id = supplier_items.item_id
                        AND supplier_items.id = movements.supplieritem_id
                        AND movements.user_id = users.id
                        AND departments.id = users.department_id
                        AND users.id = '.$supplier.' AND DATE(movements.created_at) = "'.$datefrom.'" AND movements.type = '.$itemtype.'');
        return $sql;
    } 
    public function get_report($month, $year, $category)
    {
        $m = $month[0];
        $sql = $this->get_monthlyFromDB($month, $year, $category);
      
        if($m === "W" AND $year !== "")
            $sql = $this->get_weeklyFromDB($year, $category, $month);
        else
        {
            if($month == "Q1" || $month == "Q2" || $month == "Q3" || $month == "Q4")
            {
                $month = $month[1];
                $sql = $this->get_quarterlyFromDB($month, $year, $category);
            }
            if($month === "N" AND $year !== "")
                $sql = $this->get_yearlyFromDB($year, $category);
        }
        return response()->json($sql);
    }
    public function get_reportPrint($month, $year, $category)
    {
        $m = $month[0]; $q = $month;
        $data = $this->get_monthlyFromDB($month, $year, $category);
        if($m === "W" AND $year !== "")
            $data = $this->get_weeklyFromDB($year, $category, $month);
        else
        {
            if($month == "Q1" || $month == "Q2" || $month == "Q3" || $month == "Q4")
            {
                if($month == "Q1") $month = 1;
                if($month == "Q2") $month = 2;
                if($month == "Q3") $month = 3;
                if($month == "Q4") $month = 4;
                $data = $this->get_quarterlyFromDB($month, $year, $category);
                $month = $q;
            }   
                
            if($month === "N" AND $year !== "")
                $data = $this->get_yearlyFromDB($year, $category);
            if($month == 1) $month = "JANUARY";
            if($month == 2) $month = "FEBRUARY";
            if($month == 3) $month = "MARCH";
            if($month == 4) $month = "APRIL";
            if($month == 5) $month = "MAY";
            if($month == 6) $month = "JUNE";
            if($month == 7) $month = "JULY";
            if($month == 8) $month = "AUGUST";
            if($month == 9) $month = "SEPTEMBER";
            if($month == 10) $month = "OCTOBER";
            if($month == 11) $month = "NOVEMBER";
            if($month == 12) $month = "DECEMBER";
        }
         
        $category = ItemCategory::where('id', $category)->get();
        return view('reports.monthlyreport', compact('data', 'month', 'year', 'category'));
    }
    public function get_monthlyFromDB($month, $year, $category)
    {
        $sql = DB::select('SELECT distinct date(movements.created_at) as dateRequest,movements.*, itemcategories.*, items.*, users.*, departments.*, supplier_items.*, suppliers.*
                                FROM suppliers, items, itemcategories, supplier_items, movements, users, departments
                                WHERE suppliers.id = supplier_items.supplier_id
                                AND itemcategories.id = supplier_items.category_id
                                AND items.id = supplier_items.item_id
                                AND supplier_items.id = movements.supplieritem_id
                                AND departments.id = users.department_id
                                AND movements.user_id = users.id
                                AND MONTH(movements.created_at) = "'.$month.'" AND YEAR(movements.created_at) =  "'.$year.'" AND itemcategories.id = '.$category.' AND supplier_items.status != 0');
        return $sql;
    }
    public function get_yearlyFromDB($year, $category)
    {
        $sql = DB::select('SELECT distinct date(movements.created_at) as dateRequest, movements.*, itemcategories.*, items.*, users.*, departments.*, supplier_items.*, suppliers.*
                        FROM suppliers, items, itemcategories, supplier_items, movements, users, departments
                        WHERE suppliers.id = supplier_items.supplier_id
                        AND itemcategories.id = supplier_items.category_id
                        AND items.id = supplier_items.item_id
                        AND supplier_items.id = movements.supplieritem_id
                        AND departments.id = users.department_id
                        AND movements.user_id = users.id
                        AND YEAR(movements.created_at) =  "'.$year.'" AND itemcategories.id = '.$category.' AND supplier_items.status != 0');
        return $sql;
    }
    public function get_quarterlyFromDB($quarter, $year, $category)
    {
        $sql = DB::select('SELECT distinct date(movements.created_at) as dateRequest,movements.*, itemcategories.*, items.*, users.*, departments.*, supplier_items.*, suppliers.*
                                FROM suppliers, items, itemcategories, supplier_items, movements, users, departments
                                WHERE suppliers.id = supplier_items.supplier_id
                                AND itemcategories.id = supplier_items.category_id
                                AND items.id = supplier_items.item_id
                                AND supplier_items.id = movements.supplieritem_id
                                AND movements.user_id = users.id
                                AND departments.id = users.department_id
                                AND QUARTER(movements.created_at) = "'.$quarter.'" AND YEAR(movements.created_at) =  "'.$year.'" AND itemcategories.id = '.$category.' AND supplier_items.status = 1');
        return $sql;
    }
    public function get_weeklyFromDB($year, $category, $month)
    {
        $week = $month[1];
        if(strlen($month) > 2)
        {
            $week = $month[1]."".$month[2];
        }
        $sql = DB::select('SELECT distinct date(movements.created_at) as dateRequest,movements.*, itemcategories.*, items.*, users.*, departments.*, supplier_items.*, suppliers.*
                                FROM suppliers, items, itemcategories, supplier_items, movements, users, departments
                                WHERE suppliers.id = supplier_items.supplier_id
                                AND itemcategories.id = supplier_items.category_id
                                AND items.id = supplier_items.item_id
                                AND supplier_items.id = movements.supplieritem_id
                                AND departments.id = users.department_id
                                AND movements.user_id = users.id
                                AND WEEK(movements.created_at) = '.$week.' AND YEAR(movements.created_at) =  '.$year.' AND itemcategories.id = '.$category.' AND supplier_items.status != 0');
        return $sql;
    }
    public function monthlyreport_page()
    {
        return view('pages.monthlyreport');
    }
}
