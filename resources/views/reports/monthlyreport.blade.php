
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('bootstrap.min.css') }}" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
@if(count($data) <= 0)
    <script>
        alert("No report of this transaction");
        window.location.href = "{{ route('admin.monthlyreport') }}";
    </script>
@endif
<style>
    @media print {
        body {
            visibility: hidden;
        }
        #printarea {
            visibility: visible;
        }
        @page {size: landscape}
    }
     #dep {  
        width: 150px;
        height: 150px;   
        float: left; 
        /* padding-right: 80px; */ 
    } 
    #shs {  
        width: 150px;
        height: 150px;   
        float: right; 
    } 
    table, thead, tr, th{
        border: 1px solid black;
    }
    table{
        border-top: double;
        border-bottom: double;
        border-right: blank;
        width: 100%;
        font-size: 18px;
    }
   td{
        
        word-wrap: break-word;
    }
</style>
<body>
    <div class="" id = "printarea">
        <div class="row">
            <div class="col-sm-2">
                <img id = "dep" src="{{ asset('admintemplate/assets/img/shs-logo.png') }}" alt="">
            </div>
            <div class="col-sm-10">
                <center style = "font-family: Tahoma;; font-weight: bold;">
                                {{ $category[0]->category }} REPORT OF PROPERTIES<br>
                                LUGAIT SENIOR HIGH SCHOOL<br>
                                DISTRICT OF LUGAIT 
                    <br>
                    <p style = "color: skyblue; font-weight: 900; font-size: 30px">
                        @if($month[0] == "W")
                            <?php $month = ltrim($month, 'W');?>
                            AS OF THE {{$month}} WEEK OF {{ $year }}
                        @endif
                        @if($month == "N")
                            FOR THE YEAR OF {{ $year }}
                        @endif
                        @if($month[0] == "Q")
                            <?php $month = ltrim($month, 'Q');?>
                            FOR THE  {{ $month }} QUARTER OF {{ $year }}
                        @endif
                        @if($month >= 1 AND $month !== "N" AND $month[0] !== "W")
                            FOR THE MONTH OF {{ $month }} {{ $year }}
                        @endif
                    </p> 
                </center>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class = "table" rules="all">
                    <thead style = "text-tansform: uppercase">
                        <tr>
                            <th>ARTICLE</th>
                            <th>DESCRIPTION (SPECIFICATIONS/SERIAL NUMBER AND ETC)</th>
                            <th>DATE OF ACQUISITION</th>
                            <th>QUANTIY</th>
                            <th>UNIT OF MEASURE</th>
                            <th>UNIT VALUE</th>
                            <th>TOTAL COST/VALUE</th>
                            <th>SOURCE OF FUND (MOOE OR SEF/LGU)</th>
                            <th>TYPE OF SEMI-EXPANDABLE PROPERTIES</th>
                            <th>FUND CLUSTER (UACS CODE)</th>
                            <th>NAME OF SCHOOL</th>
                            <th>NAME OF ACCOUNTABLE OFFICER</th>
                            <th>WITH IAR, ICS AND DR? (Y/N)</th>
                            <th>REMARKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($data) > 0)
                            <?php $count=1;?>
                            @foreach($data as $d)
                                <tr>
                                    <td style = " text-align: center">N/A</td>
                                    <td>{{$d->item}}</td>
                                    <td>{{$d->dateRequest}}</td>
                                    <td style = " text-align: center">{{$d->quantity}}</td>
                                    <td style = " text-align: center">{{$d->unit}}</td>
                                    <td style = " text-align: right">&#8369;&nbsp;{{number_format((float)$d->cost, 2, '.', ',')}}</td>
                                    <td style = " text-align: right">&#8369;&nbsp;{{number_format((float)$d->totalCost, 2, '.', ',')}}</td>
                                    <td style = " text-align: center">N/A</td>
                                    <td style = " text-align: center">{{$d->category}}</td>
                                    <td style = " text-align: center">N/A</td>
                                    <td>{{$d->department_name}}</td>
                                    <td style = " text-align: center">{{$d->fullname}}</td>
                                    <td style = " text-align: center">N/A</td>
                                    <td style = " text-align: center">{{$d->remarks}}</td>
                                </tr>
                                <?php $count++;?>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr align="center">
                            <td colspan = "14">{{ count($data) }} Items in Total</td>
                        </tr>
                    </tfoot>
                </table> <br><br>
                <div class="row">
                    <div class="col-md-6">
                       Prepared By: <br><br>
                       {{ Auth::user()->fullname }} <br>
                        School Property Custodian <br>
                    </div><br><br>
                    <div class="col-md-6" >
                        Noted By: <br><br>
                        EL M. DELA CRUZ, PhD. <br>
                        School-In-Charge <br>
                    </div>
                </div><br>
            </div>
        </div>
</body>
</html>
<script>
    window.onload = function () {
        window.print();
    }
</script>