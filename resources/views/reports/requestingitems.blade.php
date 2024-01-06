
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
        alert("No released items for this transaction");
        window.location.href = "http://127.0.0.1:8000/requestingitems";
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
        float: center; 
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
                <img id = "dep" src="{{ asset('admintemplate/assets/img/shs-logo.png') }}" style = "width: 150px; height: 150px" alt="">
            </div>
            <div class="col-sm-8">
                <center style = "font-family: Tahoma; font-size: 18px">
                    <b style = "font-weight: 900; font-size: 25px; font-family: Algerian">DEPARTMENT OF EDUCATION</b> <br>
                    LUGAIT SENIOR HIGH SCHOOL <br>
                    DISTRICT OF LUGAIT<br>
                    <br>
                    <p style = "color: skyblue; font-weight: 900; font-size: 30px">LUGAIT SENIOR HIGH SCHOOL</p> 
                    <p style = "color: skyblue; font-weight: 900; font-size: 30px">PROPERTY RELEASE FORM</p>
                </center>
            </div>
            <div class="col-sm-2">

            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class = "table" rules="all">
                    <tbody>
                        <tr style = "text-align: center;">
                            <td><b>QTY</b></td>
                            <td><b>UNIT</b></td>
                            <td><b>PROPERTY DESCRIPTION</b></td>
                            <td><b>MR NO.</b></td>
                        </tr>
                       
                        @if(count($data) > 0)
                            <?php $count=1;?>
                            @foreach($data as $d)
                                <tr>
                                    <td style = "width: 20px; text-align: center">{{$d->qty}}</td>
                                    <td style = "text-align: center">{{$d->unit}}</td>
                                    <td class = "w-50">{{$d->item}}</td>
                                    <td style = "text-align: center">N/A</td>
                                </tr>
                                <?php $count++;?>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr align="center">
                            <td colspan = "4">{{ count($data) }} Items in Total</td>
                        </tr>
                    </tfoot>
                </table><br>
                <div class="row">
                    <div class="col-sm-6" style = "width: 50%">
                        Received By: <br><br>
                        <h6> {{ $data[0]->fullname }} </h6>
                        Signature Over Printed /Name/Position/Designation <br>
                    </div><br><br>
                    <div class="col-sm-6"  style = "width: 50%">
                        Noted By: <br><br>
                        <h6>EL M. DELA CRUZ, PhD.</h6>
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