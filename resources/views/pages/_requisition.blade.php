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
                                        Manage Requisition of Item
                                    </div>
                                    <div class="col-sm-2 pull-left">
                                        <div >
                                            <button id = "open_departmentModal" type = "button" class = "btn btn-primary btn-sm">
                                                <i class = "fas fa-plus"></i>
                                                Create New Requisition of Item
                                            </button>
                                        </div>
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
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Category</th>
                                            <th>Requestor</th>
                                            <th>Status</th>
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
                <form id = "department-form" method = "post" action="">
                    <input autocomplete="off" type="hidden" name = "_token" value = "{{ csrf_token() }}">
                    <input autocomplete="off" type="hidden" name = "dept_id" id = "dept_id" value = "">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="department">Department</label>
                            <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#department-msg').html('');" type="text" name = "department_name" class="form-control" id="department_name" placeholder="Enter your department">
                            <span class = "v-error" style = "color:red;" id = "department-msg"></span>
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
    @include('navigation/footer')
    <script  type="text/javascript">
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token':$("input[name=_token").val()
                }
            })
            $("#s_reqs").addClass("active");
            document.title = "LNHS Departments";
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
            function AutoReload() 
            {
                RefreshTable('#table', '{!! route("datatables.requesitions") !!}');
            }
            function show_datatable()
            {
                $('#table').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: true,
                    responsive: true,
                    ajax: '{!! route("datatables.requesitions") !!}',
                    columnDefs: [{
                        className: "text-center", // Add 'text-center' class to the targeted column
                        targets: [1, 2, 4, 5] // Replace 'columnIndex' with the index of your targeted column (starting from 0)
                    }],
                    dom: 'lBfrtip',
                    buttons: [
                        'length',
                        {
                            extend: 'copy',
                            exportOptions: {
                                columns: [0] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-primary btn-sm',
                        },  
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: [0] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-secondary btn-sm',
                            orientation: 'portrait',
                            pageSize: 'LEGAL',
                        },  
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: [0] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-success btn-sm',
                        },  
                    ],
                    initComplete: function () {
                        this.api().buttons().container().appendTo('#export_buttons');
                    },
                    columns: [
                        { data: 'item', name: 'item' },
                        { data: 'qty', name: 'qty' },
                        { data: 'category', name: 'category' },
                        { data: 'fullname', name: 'fullname' },
                        { data: 'status', name: 'status' },
                        { data: 'action', name: 'action' },
                    ],
                });
            }

            $("#open_departmentModal").on('click', function(e){
                e.preventDefault();
                $("#req-modalLabel").text('Create New Department')
                resetInputFields();
                showModal();
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
                $("#department-form")[0].reset();
                $("#dept_id").val("");
                $(".v-error").html("");
                $("input").removeClass('is-invalid');
                $("select").removeClass('is-invalid');
            }           
            $("#department-form").on('submit', function(e){
                e.preventDefault();
                if(confirm("Are you sure you want to add this department?"))
                {
                    var formData = serializeForm($(this).serializeArray());
                    console.log(formData)
                    $.ajax({
                        url: '{{ route("departments.store") }}',
                        type: 'post',
                        data: formData,
                        dataType: 'json',
                        success: function(resp)
                        {
                            if(resp.status)
                            {
                                AutoReload();
                                resetInputFields();
                                $("#req-modal").modal('hide');
                                alert(resp.messages);
                            }
                            else
                            {
                                $.each(resp.messages, function(key,value) {
                                   if(key == "department_name")
                                   {
                                     $("#department_name").addClass('is-invalid');
                                     $("#department-msg").html(value);
                                   }
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
            function showModal()
            {
                $("#req-modal").modal({
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
                        $("#req-modalLabel").text('Edit department');    
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