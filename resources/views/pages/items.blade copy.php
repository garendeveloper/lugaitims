
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
                        <h1 class="mt-4">Items</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Manage Items</li>
                        </ol>
                        <div class="card ">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <i class="fas fa-table me-1"></i>
                                        List of Items
                                    </div>
                                    <div class="col-sm-7 pull-left">
                                        <div >
                                        <button class = "btn btn-sm btn-warning" id = "btn_manageSupplier"><i class = "fas fa-users"></i>&nbsp;&nbsp;Manage Suppliers</button>
                                            <button class = "btn btn-sm btn-secondary" id = "btn_manageCategory"><i class = "fas fa-cart-plus"></i>&nbsp;&nbsp;Manage Categories</button>
                                            <button id = "open_itemModal" type = "button" class = "btn btn-primary btn-sm">
                                                <i class = "fas fa-plus"></i>&nbsp;&nbsp;
                                                Create New Item
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 pull-right" style = "text-align: right">
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
                                            <th>Item Name</th>
                                            <th>Unit</th>
                                            <th>Brand</th>
                                            <th>Category</th>
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
                <div class="modal-header">
                    <h5 class="modal-title" id="item-modalLabel">Form Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <ul id = "error-messages" style = "color: red"> 

                </ul>
                
                <!-- Modal Body - Your Form Goes Here -->
                <form id = "item-form" method = "post" action="">
                    <input autocomplete="off" type="hidden" name = "_token" value = "{{ csrf_token() }}">
                    <input autocomplete="off" type="hidden" name = "item_id" id = "item_id" value = "">
                    <div class="modal-body">
                        <!-- <div class="form-group">
                            <label for="item">Item</label>
                            <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#item-msg').html('');" type="text" name = "item" class="form-control" id="item" placeholder="Enter your item">
                            <span class = "v-error" style = "color:red;" id = "item-msg"></span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="unit">Unit</label>
                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#unit-msg').html('');" type="text" name = "unit" class="form-control" id="unit" placeholder="Enter your unit" list = "units">
                                    <span class = "v-error" style = "color:red;" id = "unit-msg"></span>
                                    <datalist id = "units"></datalist>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="brand">Brand</label>
                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#brand-msg').html('');" type="text" class="form-control" name = "brand" id="brand" placeholder="Enter your brand">
                                    <span class = "v-error" style = "color:red;" id = "brand-msg"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 ">
                                <div class="form-group">
                                    <label for="stock">Quantity</label>
                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#quantity-msg').html('');" type="number" class="form-control"  name = "quantity" id="quantity" placeholder="Enter your quantity">
                                    <span class = "v-error" style = "color:red;" id = "quantity-msg"></span>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-group">
                                    <label for="stock">Stock</label>
                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#stock-msg').html('');" type="number" class="form-control"  name = "stock" id="stock" style = "background-color: lightgray" readonly>
                                    <span class = "v-error" style = "color:red;" id = "stock-msg"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cost">Unit Cost</label>
                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#cost-msg').html('');" type="number" class="form-control"  name = "cost" id="cost" placeholder="Enter your unit cost">
                                    <span class = "v-error" style = "color:red;" id = "cost-msg"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cost">Total Cost</label>
                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#totalCost-msg').html('');" type="number"  value = "0.00" class="form-control"  name = "totalCost" id="totalCost" placeholder="Enter your unit cost" style = "background-color: red" readonly>
                                    <span class = "v-error" style = "color:red;" id = "totalCost-msg"></span>
                                </div>
                            </div> -->
                        <!-- </div> -->
                        <style>
                            table,tr,th,td {
                                border:1px solid black;
                            }
                            .stock,.quantity,.cost,.totalCost,.unit{
                                width: 100px;
                                text-align:right;
                            }
                            .item{
                                width: 250px;
                                text-transform: uppercase;
                                
                            }
                            .stock{
                                background-color: lightgreen;
                            }
                            .totalCost{
                                background-color: red;
                            }
                            .brand{
                                width: 150px;
                                text-transform: uppercase;
                            }
                          
                        </style>
                        <table id="editableTable" style="width: 100%" class = "table table-bordered">
                            <thead style = "background-color: darkgray">
                                <tr>
                                    <th>Item</th>
                                    <th>Brand</th>
                                    <th>Unit</th>
                                    <th>Stock</th>
                                    <th>Quantity</th>
                                    <th>Cost</th>
                                    <th>Total Cost</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody >
                                <style>
                                    td{
                                        height:20px;
                                    }
                                </style>     
                                <tr>
                                    <td class="editable autocomplete item" contenteditable="true"></td>
                                    <td class="editable autocomplete brand" contenteditable="true"></td>
                                    <td class="editable autocomplete unit" contenteditable="true"></td>
                                    <td class="editable autocomplete stock">7</td>
                                    <td class="editable autocomplete quantity" contenteditable="true" ></td>
                                    <td class="editable autocomplete cost" contenteditable="true" ></td>
                                    <td class="editable autocomplete totalCost" ></td>
                                    <td style = "text-align: center; width: 80px"><button class="deleteRow btn-2xs btn-danger btn-flat"><i class = "fas fa-times fa-2xs"></i></button></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" align="center">
                                        <button id = "addRow" type = "button" class=" btn-2xs btn-primary btn-block btn-flat"><i class = "fas fa-plus fa-2xs"></i></button>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- Modal Footer with Close Button -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class = "fas fa-times"></i>&nbsp; Close</button>
                        <button type="button" id = "btn_saveItem" class="btn btn-primary btn-sm"><i class="fas fa-check"></i>&nbsp; Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Category Modal -->
    <div class="modal fade" id="category-modal"   tabindex="-1" role="dialog" aria-labelledby="category-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="category-modalLabel">Form Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id = "category-form" method = "post" action="">
                        <input autocomplete="off" type="hidden" name = "_token" value = "{{ csrf_token() }}">
                        <input autocomplete="off" type="hidden" name = "category_id" id = "category_id" value = "">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="item">Item</label>
                                        <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#category-msg').html('');" type="text" name = "category" class="form-control" id="category" placeholder="Enter your category">
                                        <span class = "v-error" style = "color:red; " id = "category-msg"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for=""></label>
                                    <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table id="tbl_categories" class = "table table-bordered table-stripped cell-border" style = "width: 100%">
                            <thead class = "table table-primary">
                                <tr>
                                    <th>Category</th>
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

    <!-- Supplier Modal -->
    <div class="modal fade" id="supplier-modal"   tabindex="-1" role="dialog" aria-labelledby="supplier-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="supplier-modalLabel">Form Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id = "supplier-form" method = "post" action="">
                        <input autocomplete="off" type="hidden" name = "_token" value = "{{ csrf_token() }}">
                        <input autocomplete="off" type="hidden" name = "supplier_id" id = "supplier_id" value = "">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#name-msg').html('');" type="text" name = "name" class="form-control" id="name" placeholder="Enter Supplier Name">
                                        <span class = "v-error" style = "color:red; " id = "name-msg"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_number">Contact Number (+63)</label>
                                        <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#contact_number-msg').html('');" type="tel" maxlength = "10" pattern = "^(9|\+639)\d{9}$" name = "contact_number" id="contact_number" placeholder="Contact Number" class="form-control">
                                        <span class = "v-error" style = "color:red;" id = "contact_number-msg"></span>
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea name="address" id="address" cols="30" class = "form-control" rows="3" onkeyup="$(this).removeClass('is-invalid'); $('#address-msg').html('');"></textarea>
                                        <span class = "v-error" style = "color:red; " id = "address-msg"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for=""></label>
                                    <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table id="tbl_suppliers" class = "table table-bordered table-stripped cell-border" style = "width: 100%">
                            <thead class = "table table-primary">
                                <tr>
                                    <th>Supplier</th>
                                    <th>Address</th>
                                    <th>Contact Number</th>
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

    @include('navigation/footer')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token':$("input[name=_token").val()
                }
            })
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
            $("#btn_saveItem").click(function(){
                var tableData = [];
                $("#editableTable tbody tr").each(function(){
                    var currentRow = $(this);
                    
                    var item = currentRow.find("td:eq(0)").text();
                    var brand = currentRow.find("td:eq(1)").text();
                    var unit = currentRow.find("td:eq(2)").text();
                    var stock = currentRow.find("td:eq(3)").text();
                    var quantity = currentRow.find("td:eq(4)").text();
                    var cost = currentRow.find("td:eq(5)").text();
                    var totalCost = currentRow.find("td:eq(6)").text();

                    var obj = {};
                    obj.col1 = item;
                    obj.col2 = brand;
                    obj.col3 = unit;
                    obj.col4 = stock;
                    obj.col5 = quantity;
                    obj.col6 = cost;
                    obj.col7 = totalCost;

                    tableData.push(obj);
                })
                $.ajax({
                    type: 'post',
                    url: '{{ route("items.saveItem") }}',
                    data: tableData,
                    dataType: 'json',
                    success: function(response)
                    {
                        console.log(response);
                        // if(response.status)
                        // {
                        //     alert(response.message);
                        // }
                    },
                    error: function(response)
                    {
                        alert(response.message);
                    }
                })
            })
           
            $("#editableTable tbody").on("keypress keyup blur", '.quantity', function(event) {
                $(this).val($(this).val().replace(/[^\d].+/, ""));
                var val = $(this).text();
                var cost = $(this).closest("tr").find(".cost").text();
                var res = val*cost;
                $(this).closest("tr").find(".totalCost").text(res);
                if ((event.which < 48 || event.which > 57)) {
                    event.preventDefault();
                }
            });
            $("#editableTable tbody").on("keypress keyup blur", '.cost', function(event) {
                $(this).val($(this).val().replace(/[^\d].+/, ""));
                var val = $(this).text();
                var qty = $(this).closest("tr").find(".quantity").text();
                var res = val*qty;
                $(this).closest("tr").find(".totalCost").text(res);
                if ((event.which < 48 || event.which > 57)) {
                    event.preventDefault();
                }
            });
            $("#editableTable tbody").on("keypress keyup blur", '.totalCost', function(event) {
                $(this).val($(this).val().replace(/[^\d].+/, ""));
                if ((event.which < 48 || event.which > 57)) {
                    event.preventDefault();
                }
            });
            $("#editableTable tbody").on("keypress keyup blur", '.stock', function(event) {
                $(this).val($(this).val().replace(/[^\d].+/, ""));
                if ((event.which < 48 || event.which > 57)) {
                    event.preventDefault();
                }
            });
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
                const newRow = '<tr><td class="editable autocomplete item" contenteditable="true" ></td><td class="editable autocomplete brand" contenteditable="true"></td><td class="editable autocomplete unit" contenteditable="true"></td><td class="editable autocomplete stock"></td><td class="editable autocomplete quantity" contenteditable="true"></td><td class="editable autocomplete cost" contenteditable="true"></td><td class="editable autocomplete totalCost" ></td><td align="center"><button class="deleteRow btn-2xs btn-danger btn-flat"><i class = "fas fa-times fa-2xs"></i></button></td></tr>';
                $('#editableTable tbody').append(newRow);
            });

            // Delete a row
            $("#editableTable tbody").on('focus', '.item', function(){
                console.log("{!! route('items.get_allItemOnly') !!}");
                if($(this).autocomplete() !== undefined ){
                    $(this).autocomplete({
                        source: "{!! route('items.get_allItemOnly') !!}",
                        dataType: 'json',
                        minLength: 1, // Minimum number of characters before showing suggestions
                    });
                }
            })
           
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
            $("#s_items").addClass("active");
            document.title = "LNHS ITEMS";
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
                        targets: [ 1, 2, 3, 4] // Replace 'columnIndex' with the index of your targeted column (starting from 0)
                    }],
                    dom: 'lBfrtip',
                    buttons: [
                        'length',
                        {
                            extend: 'copy',
                            exportOptions: {
                                columns: [0, 1, 2, 3] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-primary btn-sm',
                        },  
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: [0, 1, 2, 3] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-secondary btn-sm',
                            orientation: 'portrait',
                            pageSize: 'LEGAL',
                        },  
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: [0, 1, 2, 3] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-success btn-sm',
                        },  
                    ],
                    initComplete: function () {
                        this.api().buttons().container().appendTo('#export_buttons');
                    },
                    columns: [
                        { data: 'item', name: 'item' },
                        { data: 'unit', name: 'unit' },
                        { data: 'brand', name: 'brand' },
                        { data: 'category', name: 'category' },
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
                var totalStock = $(this).val();
                var totalCost = $(this).val()*$("#cost").val();
                $("#totalCost").val(totalCost);
                $("#stock").val(totalStock);
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
                                   if(key == "itemcategory_id")
                                   {
                                     $("#itemcategory_id").addClass('is-invalid');
                                     $("#itemcategory_id-msg").html(value);
                                   }
                                   if(key == "type")
                                   {
                                     $("#type").addClass('is-invalid');
                                     $("#type-msg").html(value);
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
                show_allUnits();
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
                $("#stock").val(data.stock);
                $("#quantity").val(data.stock);
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
            function show_allUnits()
            {
                $.ajax({
                    type: 'get',
                    url: "/items/units",
                    dataType: 'json',
                    success: function(data)
                    {
                        var option = "";
                        for(var i = 0; i<data.length; i++)
                        {
                            option += "<option value = "+data[i].unit+"></option>";
                        }
                        $("#units").html(option);
                    },
                    error: function(data)
                    {
                        alert("Server Error.");
                    }
                })
            }
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

            //Manage Category
            show_datatableCategory();
            function AutoReloadCategory() 
            {
                RefreshTable('#tbl_categories', '{!! route("itemcategories.index") !!}');
            }
            function show_datatableCategory()
            {
                $('#tbl_categories').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: true,
                    responsive: true,
                    ajax: '{!! route("itemcategories.index") !!}',
                    columnDefs: [{
                        className: "text-center", // Add 'text-center' class to the targeted column
                        targets: [ 1] // Replace 'columnIndex' with the index of your targeted column (starting from 0)
                    }],
                    dom: 'lBfrtip',
                    buttons: [
                        'length',
                        {
                            extend: 'copy',
                            exportOptions: {
                                columns: [0] // Set columns 0, 2, and 3 for export
                            }, 
                            title: 'LNHS ITEM CATEGORIES',
                            className: 'btn btn-primary btn-sm',
                        },  
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: [0] // Set columns 0, 2, and 3 for export
                            },
                            title: 'LNHS ITEM CATEGORIES',
                            className: 'btn btn-secondary btn-sm',
                            orientation: 'portrait',
                            pageSize: 'LEGAL',
                        },  
                        {
                            extend: 'excel',
                            title: 'LNHS ITEM CATEGORIES',
                            exportOptions: {
                                columns: [0] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-success btn-sm',
                        },  
                    ],
                    columns: [
                        { data: 'category', name: 'category' },
                        { data: 'actions', name: 'actions' },
                    ],
                });
            }
            $("#category-form").on('submit', function(e){
                e.preventDefault();
                if(confirm("Are you sure you want to save this item category?"))
                {
                    var formData = serializeForm($(this).serializeArray());
                    
                    $.ajax({
                        url: '{{ route("itemcategories.store") }}',
                        type: 'post',
                        data: formData,
                        dataType: 'json',
                        success: function(resp)
                        {
                            if(resp.status)
                            {
                                AutoReloadCategory();
                                reset_categoryForm();
                                alert(resp.messages);
                            }
                            else
                            {
                                $.each(resp.messages, function(key,value) {
                                   if(key == "category")
                                   {
                                     $("#category").addClass('is-invalid');
                                     $("#category-msg").html(value);
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
            $("#tbl_categories").on('click', '.edit', function(){
                var id = $(this).data('id');
                $("input[name='category_id']").val(id);
                $.ajax({
                    type: 'get',
                    url: '/itemcategories/'+id,
                    dataType: 'json',
                    success: function(data)
                    {
                        $("#category").val(data.category);
                    }
                })
            })
            $("#tbl_categories").on('click', '.activate', function(){
                var id = $(this).data('id');
                if(confirm("Do you wish to activate this item category?"))
                {
                    $.ajax({
                        type: 'get',
                        url: '/itemcategories/'+id+'/edit',
                        dataType: 'json',
                        success: function(data)
                        {
                            alert(data.messages);
                            AutoReloadCategory();
                        }
                    })
                }
            })
            $("#tbl_categories").on('click', '.deactivate', function(){
                var id = $(this).data('id');
                if(confirm("Do you wish to deactivate this item category?"))
                {
                    $.ajax({
                        type: 'delete',
                        url: '/itemcategories/'+id,
                        dataType: 'json',
                        success: function(data)
                        {
                            alert(data.messages);
                            AutoReloadCategory();
                        }
                    })
                }
            })
            $("#tbl_categories").on('click', '.edit', function(){
                var id = $(this).data('id');
                $("input[name='category_id']").val(id);
                $.ajax({
                    type: 'get',
                    url: '/itemcategories/'+id,
                    dataType: 'json',
                    success: function(data)
                    {
                        $("#category").val(data.category);
                    }
                })
            })
            $("#btn_manageCategory").on('click', function(){
                $("#category-modalLabel").text("Manage Category");
                reset_categoryForm();
                show_modalCategory();
            })
            function reset_categoryForm()
            {
                $("#category-form")[0].reset();
                $("input").removeClass('is-invalid');
                $(".v-error").html("");
            }
            function show_modalCategory()
            {
                $("#category-modal").modal({
                    backdrop: 'static',
                    keyboard: false,
                });
            }
           

            //Manage Supplier
            show_datatableSupplier();
            function AutoReloadSupplier() 
            {
                RefreshTable('#tbl_suppliers', '{!! route("suppliers.index") !!}');
            }
            function show_datatableSupplier()
            {
                $('#tbl_suppliers').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: true,
                    responsive: true,
                    ajax: '{!! route("suppliers.index") !!}',
                    columnDefs: [{
                        className: "text-center", // Add 'text-center' class to the targeted column
                        targets: [2,3] // Replace 'columnIndex' with the index of your targeted column (starting from 0)
                    }],
                    dom: 'lBfrtip',
                    buttons: [
                        'length',
                        {
                            extend: 'copy',
                            exportOptions: {
                                columns: [0, 1, 2] // Set columns 0, 2, and 3 for export
                            }, 
                            title: 'LNHS SUPPLIERS',
                            className: 'btn btn-primary btn-sm',
                        },  
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: [0, 1, 2] // Set columns 0, 2, and 3 for export
                            },
                            title: 'LNHS SUPPLIERS',
                            className: 'btn btn-secondary btn-sm',
                            orientation: 'portrait',
                            pageSize: 'LEGAL',
                        },  
                        {
                            extend: 'excel',
                            title: 'LNHS SUPPLIERS',
                            exportOptions: {
                                columns: [0, 1, 2] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-success btn-sm',
                        },  
                    ],
                    columns: [
                        { data: 'name', name: 'name' },
                        { data: 'address', name: 'address' },
                        { data: 'contact_number', name: 'contact_number' },
                        { data: 'actions', name: 'actions' },
                    ],
                });
            }
            $("#supplier-form").on('submit', function(e){
                e.preventDefault();
                if(confirm("Are you sure you want to save this supplier?"))
                {
                    var formData = serializeForm($(this).serializeArray());
                    $.ajax({
                        url: '{{ route("suppliers.store") }}',
                        type: 'post',
                        data: formData,
                        dataType: 'json',
                        success: function(resp)
                        {
                            if(resp.status)
                            {
                                AutoReloadSupplier();
                                reset_supplierForm();
                                alert(resp.messages);
                            }
                            else
                            {
                                $.each(resp.messages, function(key,value) {
                                    if(key == "name")
                                    {
                                        $("#name").addClass('is-invalid');
                                        $("#name-msg").html(value);
                                    }
                                    if(key == "contact_number")
                                    {
                                        $("#contact_number").addClass('is-invalid');
                                        $("#contact_number-msg").html(value);
                                    }
                                    if(key == "address")
                                    {
                                        $("#address").addClass('is-invalid');
                                        $("#address-msg").html(value);
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
            $("#tbl_suppliers").on('click', '.edit', function(){
                var id = $(this).data('id');
                $("input[name='supplier_id']").val(id);
                $.ajax({
                    type: 'get',
                    url: '/suppliers/'+id,
                    dataType: 'json',
                    success: function(data)
                    {
                        $("input[name='name']").val(data.name);
                        $("#contact_number").val(data.contact_number);
                        $("#address").val(data.address);
                    }
                })
            })
            $("#tbl_suppliers").on('click', '.activate', function(){
                // var id = $(this).data('id');
                // if(confirm("Do you wish to activate this item category?"))
                // {
                //     $.ajax({
                //         type: 'get',
                //         url: '/itemcategories/'+id+'/edit',
                //         dataType: 'json',
                //         success: function(data)
                //         {
                //             alert(data.messages);
                //             AutoReloadCategory();
                //         }
                //     })
                // }
            })
            $("#tbl_suppliers").on('click', '.deactivate', function(){
                // var id = $(this).data('id');
                // if(confirm("Do you wish to deactivate this item category?"))
                // {
                //     $.ajax({
                //         type: 'delete',
                //         url: '/itemcategories/'+id,
                //         dataType: 'json',
                //         success: function(data)
                //         {
                //             alert(data.messages);
                //             AutoReloadCategory();
                //         }
                //     })
                // }
            })
            $("#btn_manageSupplier").on('click', function(){
                $("#supplier-modalLabel").text("Manage Suppliers");
                reset_supplierForm();
                show_modalSupplier();
            })
            function reset_supplierForm()
            {
                $("#supplier-form")[0].reset();
                $("input").removeClass('is-invalid');
                $(".v-error").html("");
                $("textarea").removeClass('is-invalid');
            }
            function show_modalSupplier()
            {
                $("#supplier-modal").modal({
                    backdrop: 'static',
                    keyboard: false,
                });
            }

            
        });
    </script>