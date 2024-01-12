
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
    table, thead, tr, th{
        border: 1px solid black;
    }
    table{
        width: 100%;
        font-size: 18px;
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
    <div class="row">
        
        <div class="col-md-8">
            <table id="tbl_itemdetails" class = "table table-bordered table-stripped " style = "width: 100%">
                
                <tbody   >

                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <table id = "tbl_image" class = "table table-bordered table-stripped " style = "width: 100%">
                <thead>
                    <tr>
                        <th>IMAGE</th>
                        <th>
                            @if($sql[0]->image == "")
                            <img src = "/upload_images/item.png" style = 'height: 180px; width: 180px;'></img>
                            @endif
                        </th>
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
