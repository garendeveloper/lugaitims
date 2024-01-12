
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('bootstrap.min.css') }}" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<style>
      @media print {
        body {
            visibility: hidden;
        }
        .no-print{
            visibility: hidden;
        }
        #printarea {
            visibility: visible;
        }
    }
    @media print {
    .head {
        background-color: #1a4567 !important;
        print-color-adjust: exact; 
    }
}

@media print {
    .head {
        color: white !important;
    }
}
    #dep {  
        width: 100px;
        height: 100px;   
        float: left; 
        /* padding-right: 80px; */ 
    } 
    #shs {  
        width: 100px;
        height: 100px;   
        float: center; 
    } 
    /* table, thead, tr, th{
        border: 1px solid black;
    } */
    table{
        width: 100%;
        font-size: 12px;
    }
   td{
        
        word-wrap: break-word;
    }
</style>
<body>
    
<div id = "printarea">
<div class="row">
            <div class="col-sm-2">
                <img id = "dep" src="{{ asset('admintemplate/assets/img/shs-logo.png') }}" style = "width: 100px; height: 100px" alt="">
            </div>
            <div class="col-sm-8">
                <center style = "font-family: Tahoma; font-size: 14px">
                    <b style = "font-weight: 900; font-size: 14px; font-family: Algerian">DEPARTMENT OF EDUCATION</b> <br>
                    LUGAIT SENIOR HIGH SCHOOL <br>
                    DISTRICT OF LUGAIT<br>
                    <br>
                  
                </center>
            </div>
            <div class="col-sm-2">

            </div>
        </div>
        <br><br>
    <div class="row">
        
        <div class="col-md-12">
            <table rules="all" id = "tbl_image" class = "table table-bordered table-stripped " style = "width: 100%">
                <thead>
                    <tr class = "head">
                        <th>IMAGE</th>
                        <th>
                            @if($sql[0]->image == "")
                            <img src = "/upload_images/item.png" style = 'height: 180px; width: 180px;'></img>
                            @endif
                            @if($sql[0]->image != "")
                            <?php $value = $sql[0]->image;?>
                            <img src = "/upload_images/"'.$value.'"" style = 'height: 180px; width: 180px;'></img>
                            @endif
                        </th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th colspan = "2"><h3>ITEM DETAILS </h3></th>
                    </tr>
                    <tr>
                        <td>Date</td>
                        <td>{{ $sql[0]->date }}</td>
                    </tr>
                    <tr>
                        <td>Item</td>
                        <td>{{ $sql[0]->item }}</td>
                    </tr>
                    <tr>
                        <td>Unit</td>
                        <td>{{ $sql[0]->unit }}</td>
                    </tr>
                    <tr>
                        <td>Quantity</td>
                        <td>{{ $sql[0]->quantity }}</td>
                    </tr>
                    <tr>
                        <td>Brand</td>
                        <td>{{ $sql[0]->brand }}</td>
                    </tr>
                    <tr>
                        <td>Cost</td>
                        <td>{{ $sql[0]->cost }}</td>
                    </tr>
                    <tr>
                        <td>Total Cost</td>
                        <td>{{ $sql[0]->totalCost }}</td>
                    </tr>
                    <tr>
                        <td>Serial Number</td>
                        <td>{{ $sql[0]->serialnumber }}</td>
                    </tr>
                    <tr>
                        <td>Model Number</td>
                        <td>{{ $sql[0]->modelnumber }}</td>
                    </tr>
                    <tr>
                        <td>Years Validity</td>
                        <td>{{ $sql[0]->no_ofYears }}</td>
                    </tr>
                    <tr>
                        <td>Years Existence</td>
                        <td>{{ $sql[0]->age }}</td>
                    </tr>
                    <tr>
                        <td>Remarks</td>
                        <td>{{ $sql[0]->remarks }}</td>
                    </tr>
                    <tr align='center' class = "head" style = 'background-color: #08a4a7; color: white'>
                        <td colspan = '2'><i class = 'fas fa-info'></i>&nbsp; SUPPLIER AND CATEGORY </td>
                        </tr>
                        <tr>
                        <td>Supplier</td>
                        <td>{{ $sql[0]->name }}</td>
                        </tr>
                        <tr>
                        <td>Address</td>
                        <td>{{ $sql[0]->address }}</td>
                        </tr>
                        <tr>
                        <tr>
                        <td>Contact Number</td>
                        <td>{{ $sql[0]->contact_number }}</td>
                        </tr>
                        <td>Category</td>
                        <td>{{ $sql[0]->category }}</td>
                        </tr>
                </thead>
                <tbody >

                </tbody>
            </table>
        </div>

    </div>
    <div class="row no-print">
        <div class="col-md-12">
            <button class = "btn btn-primary btn-block btn-sm" id  = "btn-print"><i class = "fas fa-print"></i>&nbsp;Print</button>
            <button class = "btn btn-danger btn-block btn-sm"  data-dismiss="modal"><i class = "fas fa-times"></i>&nbsp;Close</button>
        </div>
    </div>
</div>
</body>
<script>
    window.onload = function () {
        window.print();
    }
</script>
</html>
