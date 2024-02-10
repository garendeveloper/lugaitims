@include('navigation/header')
    <body class="sb-nav-fixed">
       @include('navigation/navigation')
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                @include('navigation/sidebar')
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-6">
                    <h1></h1>
                        <div class="card ">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <i class="fas fa-table me-1"></i>
                                        Daily Listing of Requested Items 
                                    </div>
                                    <div class="col-sm-4">
                                        <button id = "open_departmentModal" type = "button" class = "btn btn-secondary btn-sm">
                                            <i class = "fas fa-plus"></i>
                                            Create New Requisition of Item
                                        </button>
                                        <button id = "btn_filterModal" type = "button" class = "btn btn-secondary btn-sm">
                                            <i class = "fas fa-file"></i>&nbsp;&nbsp;
                                            Report
                                        </button>
                                    </div>
                                    <div class="col-sm-4 pull-right" style = "text-align: right">
                                        <div id="export_buttons">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <style>
                                    #table td {
                                        word-break: break-word; word-break: break-all; white-space: normal;
                                    }
                                </style>
                                <table id="table" class = "table table-bordered table-stripped cell-border" style = "width: 100%">
                                    <thead style = "text-tansform: uppercase">
                                        <tr >
                                            <!-- <th>Checkboxes</th> -->
                                            <th>DATE REQUEST</th>
                                            <th>REQUESTOR</th>
                                            <th>DEPARTMENT</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <!-- Modal -->
    <div class="modal fade" id="modal"   tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document" >
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Form Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <ul id = "error-messages" style = "color: red"> 

                </ul>
                
                <!-- Modal Body - Your Form Goes Here -->
                <form id = "form" method = "post" action="">
                    <input type="hidden" id="_userid" value = "">
                    <input type="hidden" id="_date" value = "">
                    <input autocomplete="off" type="hidden" name = "_token" value = "{{ csrf_token() }}">
                    <input autocomplete="off" type="hidden" name = "dept_id" id = "dept_id" value = "">
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table id = "tbl_request_items" class = "table table-bordered">
                                <thead>
                                    <tr>
                                        <th style = "text-align:center;">
                                            <input style = "width: 20px; height: 20px;" type="checkbox" id = "itemAll"/> 
                                        </th>
                                        <th>
                                            <select name="selected_itemtype" id="selected_itemtype" class = "form-control" style = "height: 40px; ">
                                                <option value="">--TRANSACTION--</option>
                                                <option value="7">RELEASED</option>
                                                <!-- <option value="3">FULLY RELEASED</option> -->
                                                <option value="5">CANCEL</option>
                                            </select>
                                        </th>
                                        <th colspan = "6">
                                            <input type="text" class = "form-control" placeholder = "SEARCH ITEM HERE" id = "search">
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>ACTION</th>
                                        <th>DATE TRANSACT</th>
                                        <th>ITEM</th>
                                        <th>QUANTITY</th>
                                        <th>BRAND</th>
                                        <th>NO. ITEMS RELEASED</th>
                                        <th>STATUS</th>
                                        <th>REASON OF CANCEL</th>
                                    </tr>
                                </thead>
                                <tbody id = "tblrequest_items_tbody"><tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Modal Footer with Close Button -->
                    <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm btn-block btn-submitPartial" style = "display:none"><i class = "fas fa-save"></i>&nbsp; Submit</button> 
                        <a class = "btn btn-primary btn-block btn-sm" id = "btn_releaseReport" ><i class = "fas fa-print"></i>&nbsp; Release Ticket</a>
                        <!-- <button type="button" class="btn btn-success btn-sm btn-block btn-approved" data-dismiss="modal"><i class = "fas fa-cart"></i>&nbsp; Delivered</button>
                        <button type="button" class="btn btn-danger btn-sm btn-block btn-cancel" data-dismiss="modal"><i class = "fas fa-times"></i>&nbsp; Cancel</button> -->
                        <button type="button" class="btn btn-danger  btn-block btn-sm" data-dismiss="modal"><i class = "fas fa-times"></i>&nbsp; Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

      <!-- Modal -->
      <div class="modal fade" id="req-modal"   tabindex="-1" role="dialog" aria-labelledby="req-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="req-modalLabel">Form Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <ul id = "error-messages" style = "color: red"> 

                </ul>
                
                <!-- Modal Body - Your Form Goes Here -->
                <form id = "request-form" method = "post" action="">
                    <input autocomplete="off" type="hidden" name = "_token" value = "{{ csrf_token() }}">
                    <input autocomplete="off" type="hidden" name = "movement_id" id = "movement_id" value = "">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="department">Supplier Item</label>
                            <select class = "form-control" name="supplieritem" id="supplieritem">
                                
                            </select>
                            <span class = "v-error" style = "color:red;" id = "department-msg"></span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="qty">Quantity</label>
                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#department-msg').html('');" type="text" name = "qty" class="form-control" id="qty" placeholder="Enter the quantity">
                                    <span class = "v-error" style = "color:red;" id = "qty-msg"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="requestor">Requestor</label>
                                    <select class = "form-control" name="requestor" id="requestor">
                                
                                </select>
                                    <span class = "v-error" style = "color:red;" id = "requestor-msg"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Footer with Close Button -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class = "fas fa-times"></i>&nbsp; Close</button>
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-check"></i>&nbsp; Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <!-- Filter Modal -->
    <div class="modal fade" id="filter-modal"   tabindex="-1" role="dialog" aria-labelledby="filter-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg " role="document" >
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="filter-modalLabel">Form Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id = "filter-form">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="datefrom">Item Type</label>
                                    <select name="itemtype" id="itemtype" style = "text-transform: uppercase" class = "form-control" onchange="$(this).removeClass('is-invalid'); $('#itemtype-msg').html('');">
                                        <option value="">--Select Item Type Here--</option>
                                        <option value="1">Requisition</option>
                                        <option value="3">Released</option>
                                        <option value="5">Cancelled</option>
                                    </select>
                                    <span class = "v-error" style = "color:red;" id = "itemtype-msg"></span>
                                </div> 
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="datefrom">Requestor</label>
                                    <select name="_supplier" id="_supplier" class = "form-control" onchange="$(this).removeClass('is-invalid'); $('#_supplier-msg').html('');">
                                       
                                    </select>
                                    <span class = "v-error" style = "color:red;" id = "_supplier-msg"></span>
                                </div> 
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="datefrom">Date</label>
                                    <input autocomplete="off" oninput="$(this).removeClass('is-invalid'); $('#datefrom-msg').html('');" type="date" maxlength = "10"  name = "datefrom" id="datefrom"  class="form-control">
                                    <span class = "v-error" style = "color:red;" id = "datefrom-msg"></span>
                                </div> 
                            </div>
                            <div class="col-md-12">
                                <button class = "btn btn-secondary btn-block btn-sm" type = "submit"><i class = "fas fa-print"></i>&nbsp;Print Report</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('navigation/footer')
    <script>
        function reset_notif(dateRequest, user_id)
        {
            $.ajax({
                type: 'get',
                url: "{{ route('requestingitems.resetNotif') }}",
                data: {
                    dateRequest: dateRequest,
                    user_id: user_id,
                },
                dataType: 'json',
                success:function(data)
                {
                    if(data.status)
                    {
                        $("#notif").hide();
                        $("#notif").html("");
                    }
                },
                error: function()
                {
                    alert("System cannot process request.")
                }
            })
        }
         //Filter Module
         $("#btn_filterModal").click(function(e){
            $("#filter-modal").find('.modal-title').text('Filter Report');
            $("#filter-modal").modal({
                backdrop: 'static',
                keyboard: false,
            });
        })
        function show_allSuppliers()
        {
            $.ajax({
                type: 'get',
                url: "{{ route('suppliers.allSuppliers') }}",
                dataType: 'json',
                success: function(data)
                {
                    var option = "<optgroup>";
                    option += "<option value = ''>--Please Select Here --</option>";
                    for(var i = 0; i<data.length; i++)
                    {
                        option += "<option value = "+data[i].id+">"+data[i].name+"</option>";
                    }
                    option += "</optgroup>";
                    $("#supplier").html(option);
                    $("#_supplier").html(option);
                },
                error: function(data)
                {
                    alert("Server Error.");
                }
            })
        }
       
    </script>
    <script  type="text/javascript">
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token':$("input[name=_token").val()
                }
            })
            show_allSupplierItems();
            show_allUsers();
            $("#filter-form").submit(function(e){
                e.preventDefault();
                
                var data = $(this).serializeArray();
                $.ajax({
                    type: 'get',
                    url: '{{ route("print.filter") }}',
                    data: serializeForm(data),
                    dataType: 'json',
                    success: function(response)
                    {
                        if(response.status == 1)
                        {
                            window.open(response.url, "_blank");
                        }
                        else if(response.status == 2) alert(response.messages);
                        else
                        {
                            $.each(response.messages, function(key, value){
                                $("#"+key).addClass('is-invalid');
                                $("#"+key+"-msg").html(value);
                            })
                        }
                    },
                    error: function(resp)
                    {
                        alert("Server Error.");
                    }
                })
            })
            function show_allSupplierItems()
            {
                $.ajax({
                    type: 'get',
                    url: '/datatable/items/get_allItems',
                    dataType: 'json',
                    success: function(data)
                    {
                        var option = "<option>--Please select an item here--</option>";
                        for(var i = 0; i<data.length; i++)
                        {
                            option += "<option value = "+data[i].supplieritem_id+">"+data[i].item+" | "+data[i].brand+" | "+data[i].stock+" - "+data[i].name+"</option>";
                        }
                        $("#supplieritem").html(option);
                    }
                })
            }
            function show_allUsers()
            {
                $.ajax({
                    url: '{{ route("users.get_allUsers") }}',
                    method: 'get',
                    dataType: 'json',
                    success: function(data)
                    {
                        var option = "<option>--Please select a requestor here--</option>";
                        for(var i = 0; i<data.length; i++)
                        {
                            option += "<option value = "+data[i].user_id+">"+data[i].fullname+" - "+data[i].department_name+"</option>";
                        }
                        $("#requestor").html(option);
                        $("#_supplier").html(option);
                    }
                })
            }
            
            $("#open_departmentModal").on('click', function(e){
                e.preventDefault();
                $("#req-modalLabel").text('Create New Request')
                resetInputFields1();
                showModal1();
            })
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#table tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            function resetInputFields1()
            {
                $("#request-form")[0].reset();
                $("#dept_id").val("");
                $(".v-error").html("");
                $("input").removeClass('is-invalid');
                $("select").removeClass('is-invalid');
            }           
            $("#request-form").on('submit', function(e){
                e.preventDefault();
                if(confirm("Are you sure you want to add this department?"))
                {
                    var formData = serializeForm($(this).serializeArray());
                    $.ajax({
                        url: '{{ route("requisitions.store") }}',
                        type: 'post',
                        data: formData,
                        dataType: 'json',
                        success: function(resp)
                        {
                            if(resp.status)
                            {
                                AutoReload();
                                resetInputFields1();
                                $("#req-modal").modal('hide');
                                alert(resp.messages);
                            }
                            else
                            {
                                $.each(resp.messages, function(key,value) {
                                   $("#"+key).addClass('is-invalid');
                                   $("#"+key+"-msg").html(value);
                                });
                            }
                        },
                        error: function(message)
                        {
                            alert("Server Error");
                        }
                    })
                }
            })
            function showModal1()
            {
                $("#req-modal").modal({
                    backdrop: 'static',
                    keyboard: false,
                })
            }
            function show_allValue1(data)
            {
                $("#movement_id").val(data[0].id);
                $("#supplieritem").val(data[0].supplieritem_id);
                $("#qty").val(data[0].qty);
                $("#requestor").val(data[0].user_id);
            }
            $("#itemAll").click(function(e){
                var table = $(e.target).closest("table");
                $("td input:checkbox", table).prop('checked', this.checked)
            })
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#tbl_request_items tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            $("#btn_releaseReport").click(function(e){
                var dateRequest = $("#_date").val();
                var user_id = $("#_userid").val();
                window.open("/admin/requesting/report/"+dateRequest+"/"+user_id, "_blank");
            })
            $("#s_ritems").addClass("active");
            document.title = "LSHS Requested Items";
            show_datatable();
            function RefreshTable(tableId, urlData) {
                $.getJSON(urlData, null, function(json) {
                    table = $(tableId).dataTable();
                    oSettings = table.fnSettings();

                    table.fnClearTable(this);

                    for (var i = 0; i < json.data.length; i++) {
                        table.oApi._fnAddData(oSettings, json.data[i]);
                    }

                    oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
                    table.fnDraw();
                });
            }
            var releasedItems = [];
            $(".btn-submitPartial").click(function(){
                $("input:checkbox[name=itemCheck]:checked").each(function() {
                    var data = {};
                    var totalReleased = $(this).closest('tr').find('input[name="totalReleased"]').val();
                    
                    if(totalReleased !== "")
                    {
                        data.totalReleased = totalReleased;
                        data.qty = $(this).closest('tr').find('input[name="totalReleased"]').data('qty');
                        data.type = $(this).closest('tr').find('input[name="totalReleased"]').data('type');
                        data.supplieritem_id = $(this).closest('tr').find('input[name="totalReleased"]').data('supplieritem_id');
                        data.movement_id = $(this).closest('tr').find('input[name="totalReleased"]').data('movement_id');
                        releasedItems.push(data);
                    }
                    else return $(this).closest('tr').find('.totalReleased').addClass('is-invalid');
                })
                if(releasedItems.length > 0 )
                {
                    $.ajax({
                        type: 'get',
                        url: '/admin/request/savePartial',
                        data: {releasedItems: releasedItems},
                        dataType: 'json',
                        success: function(response)
                        {
                            var userid = $("#_userid").val();
                            var dateRequest = $("#_date").val();
                            if(response.status){
                                AutoReload();
                                show_allRequestss(dateRequest, userid);
                                $("#itemAll").prop('checked', false);
                                $("#selected_itemtype").val("");
                                alert(response.message);
                                releasedItems = [];
                                $(".btn-submitPartial").hide();
                            }
                            else
                            {
                                alert(response.message);
                            }
                        }
                    })
                }
            })
            $("#selected_itemtype").on('change', function(e){
                
                var array = [];
                var supplieritem_ids = [];
                var qty = [];
                var types = [];
                var req_id = [];
                $("input:checkbox[name=itemCheck]:checked").each(function() { 
                    supplieritem_ids.push($(this).data('supplieritem_id'));
                    types.push($(this).data('type'));
                    qty.push($(this).data('qty'));
                    array.push($(this).val()); 
                    req_id.push($(this).data('req_id'));
                }); 
                if(array.length > 0)
                {
                    if($(this).val() !== "")
                    {
                        if($(this).val() === "7")
                        {
                            $("input:checkbox[name=itemCheck]:checked").each(function() { 
                                $(this).closest('tr').find('input[name="totalReleased"]').attr('disabled', false);
                                $(".btn-submitPartial").show();
                            }); 
                            $("input:checkbox[name=itemCheck]:not(:checked)").each(function(){
                                $(this).closest('tr').find('input[name="totalReleased"]').attr('disabled', true);
                                $(this).attr('disabled', true);
                            })
                        }
                        else
                        {
                            $("input:checkbox[name=itemCheck]:checked").each(function() { 
                                $(this).closest('tr').find('input[name="totalReleased"]').val();
                                $(".btn-submitPartial").hide();
                            }); 
                            if(confirm("Do you wish to retype the selected items?"))
                            {
                                var reasonforcancel = "";
                                if($(this).val() === "5")
                                {
                                    do{
                                        reasonforcancel = prompt("Enter a reason:");
                                    }
                                    while(reasonforcancel == null || reasonforcancel == "" );
                                } 
                                $.ajax({
                                    type: 'get',
                                    url: '{{ route("supplieritems.reTypeItem") }}',
                                    data: {
                                        items: array, 
                                        selected_itemtype: $(this).val(), 
                                        supplieritem_ids: supplieritem_ids, 
                                        qty: qty, 
                                        types: types,
                                        req_id: req_id,
                                        reasonforcancel: reasonforcancel,
                                    },
                                    dataType: 'json',
                                    success: function(response)
                                    {
                                        var userid = $("#_userid").val();
                                        var dateRequest = $("#_date").val();
                                        if(response.status) {
                                            $("#itemAll").prop('checked', false);
                                            $("#selected_itemtype").val("");
                                            alert(response.message);
                                            AutoReload();
                                            show_allRequestss(dateRequest, userid);
                                        }
                                    },
                                    error: function(res)
                                    {
                                        alert("Something went wrong in updating of records.");
                                    }
                                })
                            }
                        }
                    }
                    else 
                    {
                        alert("Please select a type!");
                        $('input[name="totalReleased"]').attr('disabled', true);
                        $("input:checkbox[name=itemCheck]:not(:checked)").each(function(){
                            $(this).attr('disabled', false);
                        })
                        $("input:checkbox[name=itemCheck]:checked").each(function() { 
                            $(this).closest('tr').find('input[name="totalReleased"]').val();
                            $(".btn-submitPartial").hide();
                            $(this).prop('checked', false);
                        }); 
                    }
                }
                else
                {
                    $("#selected_itemtype").val("");
                    alert("No item selected.");
                }
            })
            function AutoReload() 
            {
                RefreshTable('#table', '{!! route("datatables.requestingitems") !!}');
            }
            function show_datatable()
            {
                $('#table').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: true,
                    responsive: true,
                    ajax: '{!! route("datatables.requestingitems") !!}',
                    columnDefs: [{
                        className: "text-center", 
                        targets: [0, 3] 
                    }],
                    order: [[0, 'desc']],
                    dom: 'lBfrtip',
                    buttons: [
                        'length',
                        {
                            extend: 'copy',
                            exportOptions: {
                                columns: [0, 1, 2] 
                            },
                            className: 'btn btn-primary btn-sm',
                        },  
                        {
                            title: 'Requested Items',
                            extend: 'print',
                            exportOptions: {
                                columns: [0, 1, 2]
                            },
                            className: 'btn btn-secondary btn-sm',
                            orientation: 'portrait',
                            pageSize: 'LEGAL',
                        },  
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: [0, 1, 2] 
                            },
                            className: 'btn btn-success btn-sm',
                        },  
                    ],
                    initComplete: function () {
                        this.api().buttons().container().appendTo('#export_buttons');
                    },
                    columns: [
                        { data: 'dateRequest', name: 'dateRequest' },
                        { data: 'fullname', name: 'fullname' },
                        { data: 'department_name', name: 'department_name' },
                        { data: 'action', name: 'action' },
                    ],
                });
            }
            $("#table tbody").on('click', '.view', function(){
                var user_id = $(this).data('user_id');
                var dateRequest = $(this).data('date');
                $("#_userid").val(user_id);
                $("#_date").val(dateRequest);
                reset_notif(dateRequest, user_id);
                AutoReload();
                show_allRequestss(dateRequest, user_id);
                showModal();
            })
            $("#tblrequest_items_tbody").on('keyup', '#totalReleased', function(e){
               var qty = $(this).val();
               var stock = $(this).data('qty');
               if(stock < qty)
               {
                 alert("Total released must not be greater than requested quantity");
                 $(this).val(0);
               }
               if(qty < 0 || qty == "0-" || qty == "0--" || qty == "-")
               {
                 alert("Invalid Total Released");
                 $(this).val(0);
               }
            })
            $("#tblrequest_items_tbody").on('keydown', '#totalReleased', function(e){
               var qty = $(this).val();
               if(qty < 0 || qty === "0-" || qty === "0--" || qty === "-" || qty === "--")
               {
                 alert("Invalid Total Released");
                 $(this).val(0);
               }
            })
            function show_allRequestss(dateRequest, user_id)
            {
                $.ajax({
                    type: 'get',
                    url: '/requesting/items/get/user/request/'+user_id+'',
                    data: {
                        dateRequest: dateRequest,
                    },
                    dataType: 'json',
                    success: function(datas)
                    {
                        var row  = "";
                        $(".modal-title").text("REQUESTED BY "+datas[0].fullname + " ON "+dateRequest);
                        var length = datas.length;
                        var j = 0;
                        while(j < length)
                        {
                            row += "<tr>";
                            if(datas[j].type == 3 || datas[j].type == 5)
                            row += "<td style = 'text-align: center'><input data-qty = "+datas[j].qty+" data-type = "+datas[j].type+" data-supplieritem_id= "+datas[j].supplieritem_id+"  class = 'checkboxes' style = 'width: 20px; height: 20px;' type = 'checkbox' value = "+datas[j].movement_id+"  name = 'itemCheck1' id = 'itemCheck1' checked disabled readonly/></td>";
                            else 
                            row += "<td style = 'text-align: center'><input data-qty = "+datas[j].qty+" data-type = "+datas[j].type+" data-supplieritem_id= "+datas[j].supplieritem_id+"  class = 'checkboxes' style = 'width: 20px; height: 20px;' type = 'checkbox' value = "+datas[j].movement_id+"  name = 'itemCheck' id = 'itemCheck'/></td>";
                            row += "<td>"+datas[j].dateTransact+"</td>";
                            row += "<td>"+datas[j].item+"</td>";
                            row += "<td style = 'text-align: center'>"+datas[j].qty+"</td>";
                            row += "<td>"+datas[j].brand+"</td>";
                            row += "<td class = 'fit'><input class = 'form-control totalReleased' type = 'number' min='0'  name = 'totalReleased' id = 'totalReleased' required  data-qty = "+datas[j].qty+" data-type = "+datas[j].type+" data-supplieritem_id= "+datas[j].supplieritem_id+"  value = "+datas[j].totalReleased+" data-movement_id = "+datas[j].movement_id+" max="+datas[j].qty+" disabled></input></td>";
                            var status = "<span class = 'badge badge-danger'>CANCELLED</span>";
                            var reasonforcancel = "-";
                            if(datas[j].type == 1) status = "<span class = 'badge badge-primary'>REQUESTING</span>";
                            if(datas[j].type == 3) status = "<span class = 'badge badge-success'>FULLY RELEASED</span>";
                            if(datas[j].type == 7) status = "<span class = 'badge badge-warning'>PARTIALLY RELEASED</span>";
                            if(datas[j].type == 5) reasonforcancel = datas[j].reasonforCancel == null ? "-" : datas[j].reasonforCancel;
                            row += "<td style = 'text-align: center'>"+status+"</td>";
                            row += "<td style = 'text-align: center'>"+reasonforcancel+"</td>";
                            row += "</tr>";
                            j++;
                            
                        }
                        $("#tblrequest_items_tbody").html(row);
                        
                    },
                    error: function(resp)
                    {
                        alert("Error...");
                    }
                })
            }
            function serializeForm(serializeArray)
            {
                var formDataArray = serializeArray;

                var formDataObject = {};
                $.each(formDataArray, function(index, field) {
                    if (formDataObject[field.name]) {
                        if (!Array.isArray(formDataObject[field.name])) {
                        formDataObject[field.name] = [formDataObject[field.name]];
                        }
                        formDataObject[field.name].push(field.value);
                    } else {
                        formDataObject[field.name] = field.value;
                    }
                });
                return formDataObject;
            }
            function resetInputFields()
            {
                $("#form")[0].reset();
                $("#dept_id").val("");
                $(".v-error").html("");
                $("input").removeClass('is-invalid');
                $("select").removeClass('is-invalid');
            }     
            function showModal()
            {
                $("#modal").modal({
                    backdrop: 'static',
                    keyboard: false,
                })
            }
            function show_allValue(data)
            {
                $("#dept_id").val(data.id);
                $("#department_name").val(data.department_name);
            }
            $("#table tbody ").on('click', '.edit', function(){
                var department_id = $(this).data('id');
                $.ajax({
                    type: 'get',
                    url: "/departments/" + department_id + "/edit",
                    dataType: 'json',
                    success: function(data)
                    {
                        $("#modalLabel").text('Edit department');    
                        show_allValue(data);
                        showModal();
                    },
                    error: function(data)
                    {
                        alert("Server Error.");
                    }
                })
            })
        });
    </script>