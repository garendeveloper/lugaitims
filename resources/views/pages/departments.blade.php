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
                                        Manage Departments/Requesting Office and Requestor/Purchaser
                                    </div>
                                    <div class="col-sm-2 pull-left">
                                        <div >
                                            <button id = "open_departmentModal" type = "button" class = "btn btn-primary btn-sm">
                                                <i class = "fas fa-plus"></i>
                                                Create New Department
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
                                            <th>Department Name</th>
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
    <div class="modal fade" id="department-modal"   tabindex="-1" role="dialog" aria-labelledby="department-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="department-modalLabel">Form Modal</h5>
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

    <!-- Purchaser Modal -->
    <div class="modal fade" id="purchaser-modal"   tabindex="-1" role="dialog" aria-labelledby="department-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document" >
            <div class="modal-content">
                <style>
                    form, input, input.placeholder{
                        font-size: 12px;
                    }
                    input[type=text], input[type=tel],input[type=email],table,tr,th,td{
                        font-size: 12px;
                    }
                    
                </style>
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="purchaser-modalLabel">Form Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    
                </div>
                <div class="modal-body">
                    <h6 >Department: &nbsp;&nbsp;<u id="purchaser-modalDept"><b></b></u></h6>
                    <ul id = "error-messages" style = "color: red"> 

                    </ul>

                    <!-- Modal Body - Your Form Goes Here -->
                    <form id = "purchaser-form" method = "post" action="">
                        <input autocomplete="off" type="hidden" name = "_token" value = "{{ csrf_token() }}">
                        <input type="hidden" name = "_departmentID" value = "">
                        <input autocomplete="off" type="hidden" name = "purchaser_id" id = "purchaser_id" value = "">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="department">Full Name</label>
                                        <input autocomplete="off" onkeydown="return /[a-zA-Z ]/i.test(event.key)"   onkeyup="$(this).removeClass('is-invalid'); $('#fullname-msg').html('');" type="text" name = "fullname" id="fullname" placeholder="Enter your Fullname" class="form-control">
                                        <span class = "v-error" style = "color:red;" id = "fullname-msg"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="position">Position</label>
                                        <input autocomplete="off" list = "positions" onkeyup="$(this).removeClass('is-invalid'); $('#position-msg').html('');" type="text" name = "position" id="position" placeholder="Enter your Position" class="form-control">
                                        <datalist id = "positions">

                                        </datalist>
                                        <span class = "v-error" style = "color:red;" id = "position-msg"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#email-msg').html('');" type="email" name = "email" id="email" placeholder="Enter your Email" class="form-control">
                                        <span class = "v-error" style = "color:red;" id = "email-msg"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="contact_number">Contact Number (+63)</label>
                                        <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#contact_number-msg').html('');" type="tel" maxlength = "10" pattern = "^(9|\+639)\d{9}$" name = "contact_number" id="contact_number" placeholder="Contact Number" class="form-control">
                                        <span class = "v-error" style = "color:red;" id = "contact_number-msg"></span>
                                    </div>  
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-secondary btn-flat"><i class="fas fa-user-plus"></i>&nbsp; </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="mb-12">
                        <div class="table-responsive">
                            <table class = "table table-bordered table-stripped" style = "width: 100%" id = "tbl_purchasers">
                                <thead class = "table table-primary">
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Position</th>
                                        <th>Email</th>
                                        <th>Username</th>
                                        <th>Contact No.</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
            $("#s_departments").addClass("active");
            document.title = "LSHS Departments";
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
                RefreshTable('#table', '{!! route("datatables.departments") !!}');
            }
            function show_datatable()
            {
                $('#table').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: true,
                    responsive: true,
                    ajax: '{!! route("datatables.departments") !!}',
                    columnDefs: [{
                        className: "text-center", // Add 'text-center' class to the targeted column
                        targets: [1] // Replace 'columnIndex' with the index of your targeted column (starting from 0)
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
                        { data: 'department_name', name: 'department_name' },
                        { data: 'actions', name: 'actions' },
                    ],
                });
            }

            $("#open_departmentModal").on('click', function(e){
                e.preventDefault();
                $("#department-modalLabel").text('Create New Department')
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
                                $("#department-modal").modal('hide');
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
                $("#department-modal").modal({
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
                        $("#department-modalLabel").text('Edit department');    
                        show_allValue(data);
                        showModal();
                    },
                    error: function(data)
                    {
                        alert("Server Error.");
                    }
                })
            })

            //Purchaser Module
            $("#table tbody").on('click', '.createPurchaser', function(){
                var department_id = $(this).data('id');
                $("#tbl_purchasers").DataTable().destroy();
                show_purchaserDataTable(department_id);
                resetPurchaserForm();
                show_allPositions();
                $("#purchaser-modalLabel").text('Create New Purchaser');   
                show_departmentTitle(department_id);
                showPurchaserModal();  
            })
            function show_departmentTitle(department_id)
            {
                $.ajax({
                    type: 'get',
                    url: "/departments/" + department_id + "/edit",
                    dataType: 'json',
                    success: function(data)
                    {
                      $("#purchaser-modalDept").text(data.department_name);
                      $("input[name='_departmentID']").val(department_id);
                      document.title = data.department_name+" PURCHASERS";
                    },
                    error: function(data)
                    {
                        alert("Server Error.");
                    }
                })
            }
            $("#tbl_purchasers tbody ").on('click', '.edit', function(){
                var id = $(this).data('id');
                $.ajax({
                    type: 'get',
                    url: "/users/" + id + "/edit",
                    dataType: 'json',
                    success: function(data)
                    {
                        $("#purchaser_id").val(data[0].purchaser_id);
                        $("#fullname").val(data[0].fullname);
                        $("#position").val(data[0].position);
                        $("#email").val(data[0].email);
                        $("#contact_number").val(data[0].contact_number);
                    },
                    error: function(data)
                    {
                        alert("Server Error.");
                    }
                })
            })
            function show_allPositions()
            {
                $.ajax({
                    type: 'get',
                    url: '{{ route("positions.get_allData") }}',
                    dataType: 'json',
                    success: function(data)
                    {
                        var option = "";
                        for(var i = 0; i<data.length; i++)
                        {
                            option += "<option value = "+data[i].position+"></option>";  
                        }
                        $("#positions").html(option);
                    },
                    error: function(data)
                    {
                        alert("Server Error.");
                    }
                })
            }
            function AutoReloadPurchaserTable(department_id) 
            {
                RefreshTable('#tbl_purchasers', '/datatables/users/'+department_id);
            }
            function show_purchaserDataTable(department_id)
            {
                $('#tbl_purchasers').DataTable({
                    ajax:{
                        url: '/datatables/users/'+department_id,
                        type: 'get',
                        dataType: 'json',
                    },
                    processing: true,
                    serverSide: true,
                    searching: true,
                    responsive: true,
                    columnDefs: [{
                        className: "text-center", // Add 'text-center' class to the targeted column
                        targets: [3,4,5] // Replace 'columnIndex' with the index of your targeted column (starting from 0)
                    }],
                    dom: 'lBfrtip',
                    buttons: [
                        'length',
                        {
                            extend: 'copy',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-primary btn-sm',
                        },  
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-secondary btn-sm',
                            orientation: 'portrait',
                            pageSize: 'LEGAL',
                        },  
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-success btn-sm',
                        },  
                    ],
                    columns: [
                        { data: 'fullname', name: 'fullname'},
                        { data: 'position', name: 'position'},
                        { data: 'email', name: 'email'},
                        { data: 'username', name: 'username'},
                        { data: 'contact_number', name: 'contact_number'},
                        { data: 'actions', name: 'actions'},
                    ],
                });
            }
            $("#purchaser-form").on('submit', function(e){
                e.preventDefault();
                if(confirm("Are you sure you want to save this purchaser?"))
                {
                    var formData = serializeForm($(this).serializeArray());
                    console.log(formData)
                    $.ajax({
                        url: '{{ route("users.store") }}',
                        type: 'post',
                        data: formData,
                        dataType: 'json',
                        success: function(resp)
                        {
                            if(resp.status)
                            {
                                AutoReloadPurchaserTable(formData['_departmentID']);
                                alert(resp.messages);
                                resetPurchaserForm();
                            }
                            else
                            {
                                $.each(resp.messages, function(key,value) {
                                   if(key == "fullname")
                                   {
                                     $("#fullname").addClass('is-invalid');
                                     $("#fullname-msg").html(value);
                                   }
                                   if(key == "position")
                                   {
                                     $("#position").addClass('is-invalid');
                                     $("#position-msg").html(value);
                                   }
                                   if(key == "email")
                                   {
                                     $("#email").addClass('is-invalid');
                                     $("#email-msg").html(value);
                                   }
                                   if(key == "contact_number")
                                   {
                                     $("#contact_number").addClass('is-invalid');
                                     $("#contact_number-msg").html(value);
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
            function resetPurchaserForm()
            {
                $("#purchaser-form")[0].reset();
                $("#purchaser_id").val("");
                $("input").removeClass('is-invalid');
                $(".v-error").html("");
            }
            function showPurchaserModal()
            {
                $("#purchaser-modal").modal({
                    backdrop: 'static',
                    keyboard: false
                });
            }
        });
    </script>