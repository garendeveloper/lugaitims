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
                        <h1 class="mt-4">Purchased Items</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Manage Purchased Items</li>
                        </ol>
                        <div class="card ">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <i class="fas fa-table me-1"></i>
                                        List of Purchased Items
                                    </div>
                                    <div class="col-sm-4 pull-left">
                                        <div >
                                            <button id = "open_itemModal" type = "button" class = "btn btn-primary">
                                                <i class = "fas fa-plus"></i>
                                                Create New
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 pull-right" style = "text-align: right">
                                        <div id="export_buttons">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <style>
                                    #table tbody td {
                                        word-break: break-word; word-break: break-all; white-space: normal;
                                    }
                                </style>
                                <table id="table" class = "table table-bordered table-stripped cell-border" style = "width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Unit</th>
                                            <th>Brand</th>
                                            <th>Quantity</th>
                                            <th>Cost</th>
                                            <th>Total Cost</th>
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
                <!-- <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer> -->
            </div>
        </div>

        <!-- Modal -->
    <div class="modal fade" id="item-modal"   tabindex="-1" role="dialog" aria-labelledby="item-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document" >
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-gray" style = "background-color: darkgray">
                    <h5 class="modal-title" id="item-modalLabel">Form Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <ul id = "error-messages" style = "color: red"> 

                </ul>
                <style>
                    /* td, th {
                        border: 1px solid #ccc;
                        padding: 8px;
                        text-align: left;
                    }
                    table {
                        border-collapse: collapse;
                    } */
                    .editable {
                        cursor: pointer;
                    }
                </style>
                <!-- Modal Body - Your Form Goes Here -->
                <form id = "item-form" method = "post" action="">
                    <input autocomplete="off" type="hidden" name = "_token" value = "{{ csrf_token() }}">
                    <input autocomplete="off" type="hidden" name = "pitem_id" id = "pitem_id" value = "">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="item">Supplier</label>
                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#supplier-msg').html('');" type="text" name = "supplier" class="form-control" id="supplier" placeholder="Enter the Supplier">
                                    <span class = "v-error" style = "color:red;" id = "supplier-msg"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="item">AR No.</label>
                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#arno-msg').html('');" type="text" name = "arno" class="form-control" id="arno" placeholder="Enter AR. No.">
                                    <span class = "v-error" style = "color:red;" id = "arno-msg"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="item">Address</label>
                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#address-msg').html('');" type="text" name = "address" class="form-control" id="address" placeholder="Enter Supplier Address">
                                    <span class = "v-error" style = "color:red;" id = "address-msg"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="item">Date</label>
                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#ar_date-msg').html('');" type="date" name = "ar_date" class="form-control" id="ar_date" placeholder="Enter Supplier Address">
                                    <span class = "v-error" style = "color:red;" id = "ar_date-msg"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="item">PO No.</label>
                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#pono-msg').html('');" type="text" name = "pono" class="form-control" id="pono" placeholder="">
                                    <span class = "v-error" style = "color:red;" id = "pono-msg"></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="item">Date</label>
                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#podate-msg').html('');" type="date" name = "po_date" class="form-control" id="po_date" placeholder="">
                                    <span class = "v-error" style = "color:red;" id = "podate-msg"></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="item">Invoice No.</label>
                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#invoice_no-msg').html('');" type="text" name = "invoice_no" class="form-control" id="invoice_no" placeholder="">
                                    <span class = "v-error" style = "color:red;" id = "invoice_no-msg"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="item">Requisitioning Office/Dept.</label>
                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#purchaser-msg').html('');" type="text" name = "purchaser" class="form-control" id="purchaser" placeholder="Enter the Requesitioning Office">
                                    <span class = "v-error" style = "color:red;" id = "purchaser-msg"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           <div class="col-md-12">
                                <table id="editableTable"  class="table table-bordered table-stripped">
                                    <thead style = "background-color: darkgray">
                                        <tr>
                                            <th>Item Purchased</th>
                                            <th>Quantity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="editable" contenteditable="true">John Doe</td>
                                            <td class="editable" contenteditable="true">30</td>
                                            <td style = "text-align: center"><button class="deleteRow btn-sm btn-danger btn-flat"><i class = "fas fa-trash"></i></button></td>
                                        </tr>
                                    </tbody>
                                </table>
                           </div>
                           <div class="col-md-12">
                                <button id="addRow"  type = "button" class="btn btn-secondary btn-sm btn-block btn-flat"><i class = "fas fa-plus"></i> Add Row</button>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Footer with Close Button -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class = "fas fa-times"></i>&nbsp; Close</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i>&nbsp; Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('navigation/footer')
    <script>
        $(document).ready(function() {
            // Make table cells editable
            $('#editableTable td.editable').on('focus', function() {
                $(this).data('val', $(this).text());
            }).on('blur', function() {
                const $this = $(this);
                if ($this.text() !== $this.data('val')) {
                    // Handle value change, e.g., update your data
                    console.log(`Value changed from "${$this.data('val')}" to "${$this.text()}"`);
                }
            });

            // Add a new row
            $('#addRow').on('click', function() {
                const newRow = '<tr><td class="editable" contenteditable="true"></td><td class="editable" contenteditable="true"></td><td style = "text-align: center"><button class=" btn-sm btn-danger btn-flat deleteRow" ><i class = "fas fa-trash"></i></button></td></tr>';
                $('#editableTable tbody').append(newRow);
            });

            // Delete a row
            $('#editableTable').on('click', '.deleteRow', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>
    <script  type="text/javascript">
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token':$("input[name=_token").val()
                }
            })
            $("#s_pitems").addClass("active");
            document.title = "LSHS ITEMS";
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
                RefreshTable('#table', '{!! route("datatables.items") !!}');
            }
            function getBase64Image(img) {
                var canvas = document.createElement("canvas");
                canvas.width = img.width;
                canvas.height = img.height;
                var ctx = canvas.getContext("2d");
                ctx.drawImage(img, 0, 0);
                return canvas.toDataURL("image/png");
            }
            function show_datatable()
            {
                $('#table').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: true,
                    responsive: true,
                    ajax: '{!! route("datatables.items") !!}',
                    columnDefs: [{
                        className: "text-center", // Add 'text-center' class to the targeted column
                        targets: [ 1, 3, 4, 5, 6] // Replace 'columnIndex' with the index of your targeted column (starting from 0)
                    }],
                    dom: 'lBfrtip',
                    buttons: [
                        'length',
                        {
                            extend: 'copy',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-primary',
                        },  
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-secondary',
                            orientation: 'portrait',
                            pageSize: 'LEGAL',
                        },  
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-success',
                        },  
                    ],
                    initComplete: function () {
                        this.api().buttons().container().appendTo('#export_buttons');
                    },
                    columns: [
                        { data: 'item', name: 'item' },
                        { data: 'unit', name: 'unit' },
                        { data: 'brand', name: 'brand' },
                        { data: 'quantity', name: 'quantity' },
                        { data: 'cost', name: 'cost' },
                        { data: 'totalCost', name: 'totalCost' },
                        { data: 'actions', name: 'actions' },
                    ],
                });
            }

            $("#open_itemModal").on('click', function(e){
                e.preventDefault();
                $("#item-modalLabel").text('Create New Item')
                resetInputFields();
                showModal();
            })
            $("#cost").on('keyup', function(e){
                e.preventDefault();
                var totalCost = $(this).val()*$("#quantity").val();
                $("#totalCost").val(totalCost);
            })
            $("#quantity").on('keyup', function(e){
                e.preventDefault();
                var totalCost = $(this).val()*$("#cost").val();
                $("#totalCost").val(totalCost);
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
                $("#item-form")[0].reset();
                $("#item_id").val("");
                $(".v-error").html("");
                $("input").removeClass('is-invalid');
                $("select").removeClass('is-invalid');
            }           
            $("#item-form").on('submit', function(e){
                e.preventDefault();
                if(confirm("Are you sure you want to add this item?"))
                {
                    var formData = serializeForm($(this).serializeArray());
                    console.log(formData)
                    $.ajax({
                        url: '{{ route("items.store") }}',
                        type: 'post',
                        data: formData,
                        dataType: 'json',
                        success: function(resp)
                        {
                            if(resp.status)
                            {
                                AutoReload();
                                resetInputFields();
                                $("#item-modal").modal('hide');
                                alert(resp.messages);
                            }
                            else
                            {
                                $.each(resp.messages, function(key,value) {
                                   if(key == "item")
                                   {
                                     $("#item").addClass('is-invalid');
                                     $("#item-msg").html(value);
                                   }
                                   if(key == "unit")
                                   {
                                     $("#unit").addClass('is-invalid');
                                     $("#unit-msg").html(value);
                                   }
                                   if(key == "brand")
                                   {
                                     $("#brand").addClass('is-invalid');
                                     $("#brand-msg").html(value);
                                   }
                                   if(key == "quantity")
                                   {
                                     $("#quantity").addClass('is-invalid');
                                     $("#quantity-msg").html(value);
                                   }
                                   if(key == "cost")
                                   {
                                     $("#cost").addClass('is-invalid');
                                     $("#cost-msg").html(value);
                                   }
                                   if(key == "totalCost")
                                   {
                                     $("#totalCost").addClass('is-invalid');
                                     $("#totalCost-msg").html(value);
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
                $("#item-modal").modal({
                    backdrop: 'static',
                    keyboard: false,
                })
            }
            function show_allValue(data)
            {
                $("#item_id").val(data.id);
                $("#item").val(data.item);
                $("#unit").val(data.unit);
                $("#quantity").val(data.quantity);
                $("#brand").val(data.brand);
                $("#cost").val(data.cost);
                $("#totalCost").val(data.totalCost);
            }
            $("#table tbody ").on('click', '.edit', function(){
                var item_id = $(this).data('id');
                $.ajax({
                    type: 'get',
                    url: "/items/" + item_id + "/edit",
                    dataType: 'json',
                    success: function(data)
                    {
                        $("#item-modalLabel").text('Edit Item');    
                        show_allValue(data);
                        showModal();
                    },
                    error: function(data)
                    {
                        alert("Server Error.");
                    }
                })
            })
            $("#table tbody ").on('click', '.delete', function(){
                var item_id = $(this).data('id');
                if(confirm("Do you wish to remove this item?"))
                {
                    $.ajax({
                        type: 'delete',
                        url: '/items/'+item_id,
                        dataType: 'json',
                        success: function(data)
                        {
                            alert(data.message);
                            AutoReload();
                        },
                        error: function(data)
                        {
                            alert("Server Error.");
                        }
                    })
                }
            })
        });
    </script>