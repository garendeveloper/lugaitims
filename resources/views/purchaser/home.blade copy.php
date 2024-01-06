@include('navigation/header')
    <body class="sb-nav-fixed">
       @include('navigation/purchaser_nav')
       <style>
        .shoppingarea{
            margin-top: 20px;
        }
        #tbl_items td img{
            height: 150px;
            width: 150px;
        }
        #tbl_items thead, #tbl_purchases thead{
            background-color: #2C4B5F;
            height: 50px;
            color: white;
            text-align: center;
            text-transform: uppercase;
        }
        .card-header{
            background-color: #2C4B5F;
            color: white;
        }
        #tbl_myRequestedItems thead{
            background-color: #2C4B5F;
            color: white;
        }
        #tbl_items td .item-description{
            font-size: 20px;    
            text-align: center;
        }
        #tbl_items td.fit{
            white-space: nowrap;
            width: 1%;
            text-align: center;
        }
        #tbl_items{
            border-collapse: collapse;
            width: 100%;
        }
        td{
            word-break: break-all;
        }
        .enlarge-icon{
            font-size: 24px;
        }
        #tbl_items [type=checkbox]{
            width: 50px;
            height: 50px;
        }
        #itemQty{
            width: 100px;
        }
        .input-group{
            margin-bottom: 10px;
        }

       #tbl_purchases td.fit{
            white-space: nowrap;
            width: 1%;
        }
        #tbl_purchases{
            border-collapse: collapse;
            width: 100%;
        }
       </style>
        <main>
            <div class="row shoppingarea" >
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>AVAILABLE ITEMS</h4>
                        </div>
                        <div class="card-body">
                            <div class="input-group col-md-12">
                                <input class="form-control py-2 border-right-0 border" id = "item-search" type="search" value=""    >
                                <span class="input-group-append">
                                <button class="btn btn-outline-secondary border-left-0 border" type="button">
                                        <i class="fa fa-search"></i>
                                </button>
                                </span>
                            </div> 
                            <div class="table-responsive">
                                <table class = "table-stripped" id = "tbl_items">
                                    <thead>
                                        <tr>
                                            <th>IMAGE</th>
                                            <th>ITEM DESCRIPTION</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
    <script type = "text/javascript">
         $(document).ready(function(e){
            show_allItems();
            var req_notif = 0;
            $("#home").addClass('active');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token':$("input[name=_token").val()
                }
            })
            $("#item-search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#tbl_items tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            if(req_notif == 0) $("#req_notif").html();
            function show_allItems()
            {
                $.ajax({
                    type: 'get',
                    url: '{{ route("purchaser.supplierItems") }}',
                    dataType: 'json',
                    success: function(data)
                    {
                        var row = "";
                        if(data.length > 0)
                        {
                            row = "";
                            for(var i = 0; i<data.length; i++)
                            {
                                if(data[i].status == 1)
                                {
                                    row += "<tr>";
                                    if(data[i].image != null)
                                    {
                                        row += "<td class = 'fit'><img src = '/upload_images/"+data[i].image+"'/></td>";
                                    }
                                    else
                                    {
                                        row += "<td class = 'fit'><img src = '{{ asset('upload_images/item.png') }}' /></td>";
                                    }
                                    row += "<td class = 'fit'>"+
                                                "<div class = 'item-description'>"+
                                                    "<li>Item: "+data[i].item+"</li>"+
                                                    "<li>Brand: "+data[i].brand+"</li>"+
                                                    "<li>Stock: "+data[i].stock+"</li>"+
                                                "<div></td>";
                                    if(data[i].stock > 0)   
                                    {
                                        row += "<td class = 'fit'><button  data-id = "+data[i].supplieritem_id+" class = 'btn btn-primary btn-lg' id = 'btn_addTo' ><i class = 'fas fa-cart-plus'></i></button></td>";
                                    }
                                    else
                                    {
                                        row += "<td class = 'fit'><button  data-id = "+data[i].supplieritem_id+" class = 'btn btn-primary btn-lg disabled' id = 'btn_addTo' ><i class = 'fas fa-cart-plus' ></i></button></td>";
                                    }
                                    row += "<tr>";
                                }
                            }
                        }
                        else
                        {
                            row = "<td colspan = '3' align='center'>NO AVAILABLE ITEMS FOR THE MOMENT.</td>"; 
                        }
                        $("#tbl_items tbody").html(row);
                    },
                    error: function(response)
                    {
                        alert("Something went wrong in fetching of items!");
                    }
                })
            }
           
            $("#tbl_items tbody").on('click', '#btn_addTo', function(e){
                e.preventDefault();
                var item_id = $(this).data('id');
                $.ajax({
                    type: 'get',
                    url: "/items/" + item_id + "/purchaserEdit",
                    dataType: 'json',
                    success: function(data)
                    {     
                        var row = "<tr class = 'supplier_item' data-id ="+data['item'][0].supplieritem_id+"  >";
                        if(data['item'][0].image != null)
                             row += "<td align='center' style = 'width: 1px'><img src = '/upload_images/"+data['item'][0].image+"' style = 'width: 100px; height: 100px'/></td>";
                        else
                            row += "<td align='center' style = 'width: 1px'><img src = '{{ asset('upload_images/item.png') }}' style = 'width: 100px; height: 100px'/></td>";

                        row += "<td>"+data['item'][0].item+"</td>";
                        row += "<td class = 'fit'><input class = 'form-control' type = 'number' min='0' name = 'itemQty' data-stock="+data['item'][0].stock+" id = 'itemQty' max="+data['item'][0].stock+"  min = '00' required></input></td>";
                        row += "<td class ='fit' align='center'><button class = 'btn btn-danger btn-sm' data-id = "+item_id+" id = 'btn_removeTo'><i class = 'fas fa-times'></i></button></td>";
                        row += "</tr>";
                        $("#tbl_purchases tbody").append(row);
                    }
                })
                req_notif += 1;
                $("#req_notif").html(req_notif);
                $(this).addClass('disabled');
                var tbl = $('#tbl_purchases tbody')
                if(tbl.children().length > -1)
                {
                    $(".btn-submit").show();
                }
                else{
                    $(".btn-submit").hide();
                }
            })
            $(".btn-submit").on('click', function(){
                if(confirm("Are you sure you want to submit the selected items?"))
                {
                    var selecteditems = [];
                    $("#tbl_purchases tbody .supplier_item ").each(function(){
                        var data = {};
                        var itemQty = $(this).closest('tr').find('#itemQty').val();
                        var supplieritem_id = $(this).data('id');
                        var movement_id = $(this).data('movement_id');

                        if(itemQty != "")
                        {
                            data.itemQty = itemQty;
                            data.supplieritem_id = supplieritem_id;
                            data.movement_id = movement_id;
                            selecteditems.push(data);
                        }
                        else return $(this).closest('tr').find('#itemQty').addClass('is-invalid');
                    })
                    if(selecteditems.length > 0)
                    {
                        $.ajax({
                            type: 'get',
                            url: '/purchaser/item/save_cart',
                            data: {selecteditems:selecteditems},
                            dataType: 'json',
                            success: function(response)
                            {
                                if(response.status){
                                    $("#req_notif").html("");
                                    alert(response.message);
                                    show_allItems();
                                    $("#tbl_purchases tbody tr").remove();
                                    $(".btn-submit").hide();
                                }
                                else
                                {
                                    alert(response.message);
                                }
                            }
                        })
                    }
                }
            })
         
            $("#tbl_purchases tbody").on('keyup', '#itemQty', function(e){
               var qty = $(this).val();
               var stock = $(this).data('stock');
               if(stock < qty)
               {
                 alert("Quantity must not be greater than stock");
                 $(this).val(0);
               }
               if(qty < 0 || qty == "0-" || qty == "0--" || qty == "-")
               {
                 alert("Invalid Quantity");
                 $(this).val(0);
               }
            })
            $("#tbl_purchases tbody").on('keydown', '#itemQty', function(e){
               var qty = $(this).val();
               if(qty < 0 || qty === "0-" || qty === "0--" || qty === "-" || qty === "--")
               {
                 alert("Invalid Quantity");
                 $(this).val(0);
               }
            })
            $("#tbl_purchases tbody").on('click', '#btn_removeTo', function(e){
                e.preventDefault();
                $(this).closest('tr').remove();
                req_notif -= 1;
                $("#req_notif").html(req_notif);
                var id = $(this).data('id');
                $("#tbl_items #btn_addTo").each(function(){
                    var item_id = $(this).data('id');
                    if(item_id == id){
                        $(this).removeClass('disabled');
                    }
                })
                var tbl = $('#tbl_purchases tbody')
                if(tbl.children().length == 0)
                {   
                    $(".btn-submit").hide();
                }
            })
        })
    </script>