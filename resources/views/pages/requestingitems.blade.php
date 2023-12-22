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
                                    <div class="col-sm-6">
                                        <i class="fas fa-table me-1"></i>
                                        Daily Listing of Requested Items 
                                    </div>
                                    <div class="col-sm-6 pull-right" style = "text-align: right">
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
                                                <option value="3">RELEASED</option>
                                                <option value="5">CANCEL</option>
                                            </select>
                                        </th>
                                        <th colspan = "5">
                                            <input type="text" class = "form-control" placeholder = "SEARCH ITEM HERE" id = "search">
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>ACTION</th>
                                        <th>DATE TRANSACT</th>
                                        <th>ITEM</th>
                                        <th>QUANTITY</th>
                                        <th>BRAND</th>
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
                        <a class = "btn btn-primary btn-block btn-sm" id = "btn_releaseReport" ><i class = "fas fa-print"></i>&nbsp; Release Ticket</a>
                        <!-- <button type="button" class="btn btn-success btn-sm btn-block btn-approved" data-dismiss="modal"><i class = "fas fa-cart"></i>&nbsp; Delivered</button>
                        <button type="button" class="btn btn-danger btn-sm btn-block btn-cancel" data-dismiss="modal"><i class = "fas fa-times"></i>&nbsp; Cancel</button> -->
                        <button type="button" class="btn btn-danger  btn-block btn-sm" data-dismiss="modal"><i class = "fas fa-times"></i>&nbsp; Close</button>
                    </div>
                </form>
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
    </script>
    <script  type="text/javascript">
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token':$("input[name=_token").val()
                }
            })
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
            document.title = "LNHS Requested Items";
            show_datatable();
            function RefreshTable(tableId, urlData) {
                $.getJSON(urlData, null, function(json) {
                    table = $(tableId).dataTable();
                    oSettings = table.fnSettings();

                    table.fnClearTable(this);

                    for (var i = 0; i < json.aaData.length; i++) {
                        table.oApi._fnAddData(oSettings, json.aaData[i]);
                    }

                    oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
                    table.fnDraw();
                });
            }
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
                    else alert("Please select a type!");
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
                        className: "text-center", // Add 'text-center' class to the targeted column
                        targets: [0, 3] // Replace 'columnIndex' with the index of your targeted column (starting from 0)
                    }],
                    order: [[0, 'asc']],
                    dom: 'lBfrtip',
                    buttons: [
                        'length',
                        {
                            extend: 'copy',
                            exportOptions: {
                                columns: [0, 1, 2] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-primary btn-sm',
                        },  
                        {
                            title: 'Requested Items',
                            extend: 'print',
                            exportOptions: {
                                columns: [0, 1, 2] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-secondary btn-sm',
                            orientation: 'portrait',
                            pageSize: 'LEGAL',
                        },  
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: [0, 1, 2] // Set columns 0, 2, and 3 for export
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
                            row += "<td style = 'text-align: center'><input data-qty = "+datas[j].qty+" data-type = "+datas[j].type+" data-supplieritem_id= "+datas[j].supplieritem_id+"  class = 'checkboxes' style = 'width: 20px; height: 20px;' type = 'checkbox' value = "+datas[j].movement_id+"  name = 'itemCheck' id = 'itemCheck' /></td>";
                            row += "<td>"+datas[j].dateTransact+"</td>";
                            row += "<td>"+datas[j].item+"</td>";
                            row += "<td style = 'text-align: center'>"+datas[j].qty+"</td>";
                            row += "<td>"+datas[j].brand+"</td>";
                            var status = "<span class = 'badge badge-danger'>CANCELLED</span>";
                            var reasonforcancel = "-";
                            if(datas[j].type == 1) status = "<span class = 'badge badge-primary'>REQUESTING</span>";
                            if(datas[j].type == 3) status = "<span class = 'badge badge-success'>RELEASED</span>";
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