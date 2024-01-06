
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('bootstrap.min.css') }}"  rel="stylesheet" >
</head>
<style>
    @media print {
        body {
            visibility: hidden;
        }
        #printarea {
            visibility: visible;
        }
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
        float:right;
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
            <div class="col-sm-2" >
                <img id = "dep" src="{{ asset('admintemplate/assets/img/shs-logo.png') }}" alt="" >
            </div>
            <div class="col-sm-8" id = "tunga" >
                <center style = "font-family: Tahoma; font-size: 18px">
                    <b style = "font-weight: 900; font-size: 25px"> REQUISITION AND ISSUE SLIP </b> <br>
                    Department of Education <br>    
                    Region X <br>
                    Division of MISAMIS ORIENTAL <br>
                </center>
            </div>
            <div class="col-sm-2" >
                <img id = "shs" src="{{ asset('admintemplate/assets/img/deped.png') }}" alt="">
            </div>
        </div>
        <br><br>
        <center>
        <p style = "color: skyblue; font-weight: 900; font-size: 40px">LUGAIT SENIOR HIGH SCHOOL</p>   
        </center> 
        <div class="row">
            <div class="col-sm-12">
                <table class = "table" rules = "all">
                    <tbody style = "font-weight: 700">
                        <tr>
                           <td>Department:</td> 
                           <td colspan="2">{{$data[0]->department_name}}</td>
                           <td>RIS No:</td>
                           <td></td>
                        </tr>
                        <tr>
                           <td style = "width: 20px">Address:</td> 
                           <td colspan="2">{{$data[0]->address}}</td>
                           <td>SAI NO: </td>
                           <td></td>
                        </tr>
                    </tbody>    
                </table>
                <br>
                <table class = "table" rules="all">
                    <tbody>
                        <tr style = "text-align: center;">
                            @if($data[0]->type == 1)
                                <td colspan = "3"><b>REQUISITION</b></td>
                                <td colspan = "2"><b>ISSUANCE</b></td>
                            @endif
                            @if($data[0]->type == 3)
                                <td colspan = "3"><b>RELEASED</b></td>
                                <td colspan = "2"><b>ISSUANCE</b></td>
                            @endif
                            @if($data[0]->type == 5)
                                <td colspan = "3"><b>CANCELLED</b></td>
                                <td colspan = "2"><b>REMARKS</b></td>
                            @endif
                        </tr>
                        <tr >
                            <td style = "width: 20px; text-align: center"><b>No.</b></td>
                            <td style = "text-align: center"><b>Unit</b></td>
                            <td class = "w-50"><b>Item Description</b></td>
                            <td style = "text-align: center"><b>Quantity</b></td>
                            
                            @if($data[0]->type == 1 || $data[0]->type == 3)
                            <td style = "text-align: center"><b>Remarks</b></td>
                            @endif
                            @if($data[0]->type == 5)
                            <td style = "text-align: center"><b>Reason</b></td>
                            @endif
                        </tr>
                        <?php $count=1;?>
                        @foreach($data as $d)
                            <tr>
                                <td style = "width: 20px; text-align: center">{{$count}}</td>
                                <td style = "text-align: center">{{$d->unit}}</td>
                                <td class = "w-50">{{$d->item}}</td>
                                <td style = "text-align: center">{{$d->qty}}</td>
                                @if($data[0]->type == 1 || $data[0]->type == 3)
                                <td style = "text-align: center">{{$d->remarks}}</td>
                                @endif
                                @if($data[0]->type == 5)
                                <td style = "text-align: center">{{$d->reasonforCancel}}</td>
                                @endif
                            </tr>
                            <?php $count++;?>
                        @endforeach
                        <tr >
                            <td style = "width: 40px"></td>
                            <td colspan = "2"><b>Requested By: </b> </td>
                            <td colspan = "2"><b>Approved By:</b> </td>
                        </tr>
                        <tr >
                            <td style = "width: 20px">Signature</td>
                            <td colspan = "2" style = "text-align: center"></td>
                            <td colspan = "2" style = "text-align: center"></td>
                        </tr>
                        <tr >
                            <td style = "width: 20px">Printed Name</td>
                            <td colspan = "2" style = "text-align: center; font-size: 18px"><b><u>{{$data[0]->fullname}}</u></b></td>
                            <td colspan = "2" style = "text-align: center; font-size: 18px"><b><u>EL M. DELA CRUZ, PhD.</u></b></td>
                        </tr>
                        <tr >
                            <td style = "width: 20px">Designation</td>
                            <td colspan = "2" style = "text-align: center;">{{ $userinfo[0]->position }}</td>
                            <td colspan = "2" style = "text-align: center">Secondary School Principal II</td>
                        </tr>
                        <tr >
                            <td style = "width: 20px">Date</td>
                            <td colspan = "2" style = "text-align: center"></td>
                            <td colspan = "2" style = "text-align: center"></td>
                        </tr>
                        <tr >
                            <td style = "width: 20px"></td>
                            <td colspan = "2"><b>Issued by:</b> </td>
                            <td colspan = "2"><b>Recieved By: </b></td> 
                        </tr>
                        <tr >
                            <td style = "width: 20px">Signature</td>
                            <td colspan = "2" style = "text-align: center"></td>
                            <td colspan = "2" style = "text-align: center"></td>
                        </tr>
                        <tr >
                            <td style = "width: 20px">Printed Name</td>
                            <td colspan = "2" style = "text-align: center; font-size: 18px"><b><u>WARLLY M. PADAYHAG</u></b></td>
                            <td colspan = "2" style = "text-align: center; font-size: 18px"><b><u>JANIT A. LLANITA</u></b></td>
                        </tr>
                        <tr >
                            <td style = "width: 20px">Designation</td>
                            <td colspan = "2" style = "text-align: center">School Property Custodian</td>
                            <td colspan = "2" style = "text-align: center">BAC Chairman/Teacher III</td>
                        </tr>
                        <tr>
                            <td style = "width: 20px">Date</td>
                            <td colspan = "2"  style = "text-align: center"></td>
                            <td colspan = "2"  style = "text-align: center"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
       
</body>
</html>
<script>
    window.onload = function () {
        window.print();
    }
</script>