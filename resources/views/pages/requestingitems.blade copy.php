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
                        <div class="card ">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <i class="fas fa-table me-1"></i>
                                        List of Requested Items
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
                                    <thead>
                                        <tr class = "bg-warning">
                                            <th style = "text-align:center;">
                                                <input style = "width: 20px; height: 20px;" type="checkbox" id = "itemAll"/> 
                                            </th>
                                            <th colspan="2">
                                                <select name="selected_itemtype" id="selected_itemtype" class = "form-control" style = "height: 30px; font-size: 12px">
                                                    <option value="">--Select To Retype Item--</option>
                                                    <option value="2">RELEASED</option>
                                                    <option value="5">CANCEL</option>
                                                </select>
                                            </th>
                                            <th colspan = "11"></th>
                                        </tr>
                                        <tr>
                                            <th>Checkboxes</th>
                                            <th>Date</th>
                                            <th>Requestor</th>
                                            <th>Department</th>
                                            <th>Actions</th>
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
        <div class="modal-dialog modal-lg" role="document" >
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
                    <input autocomplete="off" type="hidden" name = "_token" value = "{{ csrf_token() }}">
                    <input autocomplete="off" type="hidden" name = "dept_id" id = "dept_id" value = "">
                    <div class="modal-body">
                        <table id = "tbl_request" class = "table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <!-- Modal Footer with Close Button -->
                    <div class="modal-footer">
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
        reset_notif();
        function reset_notif()
        {
            $.ajax({
                type: 'get',
                url: "{{ route('requestingitems.resetNotif') }}",
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
                $("input:checkbox[name=itemCheck]:checked").each(function() { 
                    array.push($(this).val()); 
                }); 
                if(array.length > 0)
                {
                    if($(this).val() !== "")
                    {
                        if(confirm("Do you wish to retype the selected items?"))
                        {
                            $.ajax({
                                type: 'get',
                                url: '{{ route("supplieritems.reTypeItem") }}',
                                data: {items: array, selected_itemtype: $(this).val()},
                                dataType: 'json',
                                success: function(response)
                                {
                                    if(response.status) {
                                        AutoReload();
                                        $("#itemAll").prop('checked', false);
                                        alert(response.message);
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
                        targets: [1, 2] // Replace 'columnIndex' with the index of your targeted column (starting from 0)
                    }],
                    dom: 'lBfrtip',
                    buttons: [
                        'length',
                        {
                            extend: 'copy',
                            exportOptions: {
                                columns: [1, 2, 3] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-primary btn-sm',
                        },  
                        {
                            title: 'Requested Items',
                            extend: 'print',
                            exportOptions: {
                                columns: [1, 2, 3] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-secondary btn-sm',
                            orientation: 'portrait',
                            pageSize: 'LEGAL',
                        },  
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: [1, 2, 3] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-success btn-sm',
                        },  
                    ],
                    initComplete: function () {
                        this.api().buttons().container().appendTo('#export_buttons');
                    },
                    columns: [
                        { data: 'date', name: 'date' },
                        { data: 'fullname', name: 'fullname' },
                        { data: 'department_name', name: 'department_name' },
                        { data: 'action', name: 'actions' },
                    ],
                });
            }
            $("#table tbody").on('click', '.view', function(){
                var req_id = $(this).data('id');
                $.ajax({
                    type: 'get',
                    url: '/requesting/items/get/user/request/'+req_id+'',
                    dataType: 'json',
                    success: function(response)
                    {
                        var row = "<tr>";
                            row += "<td>Item</td>";
                            row += "<td>"+response[0].item+"</td>";
                            row += "</tr>";
                            row += "<tr>";
                            row += "<td>Brand</td>";
                            row += "<td>"+response[0].brand+"</td>";
                            row += "</tr>";
                            row += "<tr>";
                            row += "<td>Quantity</td>";
                            row += "<td>"+response[0].qty+"</td>";
                            row += "</tr>";
                            row += "<tr>";
                            row += "<td>Unit</td>";
                            row += "<td>"+response[0].unit+"</td>";
                            row += "</tr>";
                            row += "<tr>";
                            row += "<td>Supplier</td>";
                            row += "<td>"+response[0].name+"</td>";
                            row += "</tr>";
                            row += "<tr>";
                            row += "<td>Model Number.</td>";
                            row += "<td>"+response[0].modelnumber+"</td>";
                            row += "</tr>";
                            row += "<tr>";
                            row += "<td>Serial Number</td>";
                            row += "<td>"+response[0].serialnumber+"</td>";
                            row += "</tr>";
                            row += "<tr>";
                            row += "<td>Requesting Office</td>";
                            row += "<td>"+response[0].fullname + " / "+response[0].position+"</td>";
                            row += "</tr>";
                            row += "<tr>";
                            row += "<td>Department Name</td>";
                            row += "<td>"+response[0].department_name+"</td>";
                            row += "</tr>";
                        $("#tbl_request tbody").html(row);
                        showModal();
                    },
                    error: function(resp)
                    {
                        alert("Error...");
                    }
                })
               
            })
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#table tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            function serializeForm(serializeArray)
            {
                    // Serialize the form data into an array
                var formDataArray = serializeArray;

                // Convert the array to an object
                var formDataObject = {};
                $.each(formDataArray, function(index, field) {
                    // Check if the field name already exists in the object
                    if (formDataObject[field.name]) {
                        // If it does, convert the value to an array (if not already) and push the new value
                        if (!Array.isArray(formDataObject[field.name])) {
                        formDataObject[field.name] = [formDataObject[field.name]];
                        }
                        formDataObject[field.name].push(field.value);
                    } else {
                        // If it doesn't exist, set the value as-is
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
                $(".modal-title").text('Item Description');
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