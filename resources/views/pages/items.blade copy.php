
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
                                    <div class="col-sm-2">
                                        <i class="fas fa-table me-1"></i>
                                        List of Items
                                    </div>
                                    <div class="col-sm-7 pull-left">
                                        <div >
                                            <button class = "btn btn-sm btn-warning" id = "btn_manageSupplier"><i class = "fas fa-users"></i>&nbsp;&nbsp;Manage Suppliers</button>
                                            <button class = "btn btn-sm btn-secondary" id = "btn_manageCategory"><i class = "fas fa-list-alt"></i>&nbsp;&nbsp;Manage Categories</button>
                                            <button id = "open_itemModal" type = "button" class = "btn btn-primary btn-sm">
                                                <i class = "fas fa-cart-plus"></i>&nbsp;&nbsp;
                                                Create New Item
                                            </button>
                                            <button id = "btn_filterModal" type = "button" class = "btn btn-secondary btn-sm">
                                                <i class = "fas fa-file"></i>&nbsp;&nbsp;
                                                Report
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
                                <div class="table-responsive">
                                    <table id="table" class = "table table-bordered table-stripped cell-border" style = "width: 100%">
                                        <thead >
                                            <tr class = "bg-success">
                                                <th style = "text-align:center;">
                                                    <input style = "width: 20px; height: 20px;" type="checkbox" id = "itemAll"/> 
                                                </th>
                                                <th colspan = "2" style = "text-align: center">
                                                    <button type = "button" class = "btn btn-flat btn-primary btn-sm" id = "btn_reStock"><i class = "fas  fa-redo fa-xs"></i>&nbsp;Reset Stock </button>
                                                </th>
                                                <th colspan="3" style = "text-align: center">
                                                    <select name="selected_itemtype" id="selected_itemtype" class = "form-control" style = "height: 30px; font-size: 12px">
                                                        <option value="">--Select To Retype Item--</option>
                                                        <option value="2">PURCHASED</option>
                                                        <!-- <option value="3">RELEASED</option> -->
                                                        <option value="4">WASTED</option>
                                                    </select>
                                                </th>
                                                <th colspan = "9"></th>
                                            </tr>
                                            <tr>
                                                <th>Select</th>
                                                <th>Date</th>
                                                <th>Item Name</th>
                                                <th>Unit</th>
                                                <th>Brand</th>
                                                <th>Cost</th>
                                                <th>Total Cost</th>
                                                <th>Stock</th>
                                                <th>Category</th>
                                                <th>Supplier</th>
                                                <th>Type</th>
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
                </main>
                <!-- <footer class="py-4 bg-secondary mt-auto" >
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
        <div class="modal-dialog modal-lg" role="document" >
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
                <style>
                    select{
                        font-size: 12px;
                    }
                </style>
                <!-- Modal Body - Your Form Goes Here -->
                <form id = "item-form" method = "post" action="" enctype="multipart/form-data">
                    <input autocomplete="off" type="hidden" name = "_token" value = "{{ csrf_token() }}">
                    <input autocomplete="off" type="hidden" name = "item_id" id = "item_id" value = "">
                    <input autocomplete="off" type="hidden" name = "supplieritem_id" id = "supplieritem_id" value = "">
                    <input autocomplete="off" type="hidden" name = "movement_id" id = "movement_id" value = "">
                    <input autocomplete="off" type="hidden" name = "type" id = "type" value = "1">
                    <input autocomplete="off" type="hidden" name = "requisitionItem_id" id = "requisitionItem_id" value = "">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#date-msg').html('');" type="date" class="form-control" name = "date" id="date" placeholder="Enter your brand">
                                    <span class = "v-error" style = "color:red;" id = "date-msg"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group s_category">
                                    <label for="itemcategory_id">Category</label>
                                    <select name="itemcategory_id" id="itemcategory_id" class = "form-control" onchange="$(this).removeClass('is-invalid'); $('#itemcategory_id-msg').html('');">
                                        <option value="">--Please Select Here--</option>
                                    </select>
                                    <span class = "v-error" style = "color:red;" id = "itemcategory_id-msg"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="item">Supplier</label>
                                    <select name="supplier" id="supplier" class = "form-control" onchange="$(this).removeClass('is-invalid'); $('#supplier-msg').html('');">
                                        <option value="">--Please Select Here--</option>
                                    </select>
                                    <span class = "v-error" style = "color:red;" id = "supplier-msg"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="item">Designated Office</label>
                                    <select class = "form-control" name="requisition" id="requisition" onchange="$(this).removeClass('is-invalid'); $('#requisition-msg').html('');">
                                        <option value="0" >--Please Select Here--</option>
                                    </select>
                                    <span class = "v-error" style = "color:red;" id = "requisition-msg"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="item">Item</label>
                                    <input list = "item-options" autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#item-msg').html('');" type="text" name = "item" class="form-control" id="item" placeholder="Enter your item">
                                    <span class = "v-error" style = "color:red;" id = "item-msg"></span>
                                    <datalist id = "item-options">

                                    </datalist>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="unit">Unit</label>
                                    <input  onkeyup="$(this).removeClass('is-invalid'); $('#unit-msg').html('');" type="text" name = "unit" class="form-control" id="unit" placeholder="Enter your unit" list = "units" autocomplete="off">
                                    <span class = "v-error" style = "color:red;" id = "unit-msg"></span>
                                    <datalist id = "units"></datalist>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="brand">Brand </label>
                                    <input list = "brands" autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#brand-msg').html('');" type="text" class="form-control" name = "brand" id="brand" placeholder="Enter your brand">
                                    <span class = "v-error" style = "color:red;" id = "brand-msg"></span>
                                    <datalist id = "brands"></datalist>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 ">
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#quantity-msg').html('');" type="number" class="form-control"  name = "quantity" id="quantity" placeholder="Enter your quantity" min="0">
                                    <span class = "v-error" style = "color:red;" id = "quantity-msg"></span>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-group">
                                    <label for="stock">Stock</label>
                                    <input type="hidden" id = "pstock" value = "0">
                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#stock-msg').html('');" type="number" class="form-control"  name = "stock" id="stock" style = "background-color: lightgray" min="0" readonly>
                                    <span class = "v-error" style = "color:red;" id = "stock-msg"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cost">&#x20B1; Unit Cost</label>
                                    <input autocomplete="off" step=".01"  onkeyup="$(this).removeClass('is-invalid'); $('#cost-msg').html('');" type="number" class="form-control currency"  name = "cost" id="cost" placeholder="Enter your unit cost">
                                    <span class = "v-error" style = "color:red;" id = "cost-msg"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="totalCost">&#x20B1; Total Cost</label>
                                    <input autocomplete="off"   step=".01" onkeyup="$(this).removeClass('is-invalid'); $('#totalCost-msg').html('');" type="number"  value = "0.00" class="form-control currency"  name = "totalCost" id="totalCost" placeholder="Enter your unit cost" style = "background-color: red" readonly>
                                     <span class = "v-error" style = "color:red;" id = "totalCost-msg"></span>
                                </div>
                            </div> 
                        </div> 
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Image<span style="color:red"></span></label>
                                <img  style = "width: 150px; height: 150px; border: 1px solid;" src="{{ asset('upload_images/item.png') }}" alt="preview_image" id = "preview_image">
                                <span class = "span_error" style ="color:red; font-size: 12px" id = "errmsg_image"></span>
                                <input type="file" value = "" name="image" id="image" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="totalCost">Serial No:</label>
                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#serialnumber-msg').html('');" type="text" class="form-control"  name = "serialnumber" id="serialnumber" placeholder="Enter your serial number" style = "text-align: right">
                                     <span class = "v-error" style = "color:red;" id = "serialnumber-msg"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="totalCost">Model No:</label>
                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#modelnumber-msg').html('');" type="text" class="form-control"  name = "modelnumber" id="modelnumber" placeholder="Enter your model number" style = "text-align: right">
                                     <span class = "v-error" style = "color:red;" id = "modelnumber-msg"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_ofYears">No. of Years</label>
                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#no_ofYears-msg').html('');" type="text" class="form-control"  name = "no_ofYears" id="no_ofYears" placeholder="Enter no. of years">
                                     <span class = "v-error" style = "color:red;" id = "no_ofYears-msg"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#remarks-msg').html('');" type="text" class="form-control"  name = "remarks" id="remarks" placeholder="Enter your remarks">
                                     <span class = "v-error" style = "color:red;" id = "remarks-msg"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Footer with Close Button -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class = "fas fa-times"></i>&nbsp; Close</button>
                        <button type="submit" id = "btn_saveItem" class="btn btn-primary btn-sm"><i class="fas fa-check"></i>&nbsp; Submit</button>
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
                                        <label for="item">Item Category</label>
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Vat Reg</label>
                                        <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#vatReg-msg').html('');" type="text" name = "vatReg" class="form-control" id="vatReg" placeholder="Enter Vat Registered">
                                        <span class = "v-error" style = "color:red; " id = "vatReg-msg"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tin">T.I.N</label>
                                        <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#tin-msg').html('');" type="tel"   name = "tin" id="tin" placeholder="BIR T.I.N" class="form-control">
                                        <span class = "v-error" style = "color:red;" id = "tin-msg"></span>
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
                                    <th>Vat Registered</th>
                                    <th>TIN</th>
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

    <!-- Filter Modal -->
    <div class="modal fade" id="filter-modal"   tabindex="-1" role="dialog" aria-labelledby="filter-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm " role="document" >
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-primary">
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
                                        <option value="2">Released</option>
                                    </select>
                                    <span class = "v-error" style = "color:red;" id = "itemtype-msg"></span>
                                </div> 
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="datefrom">Supplier</label>
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
    
    <!-- Item Details and Transaction Modal -->
     <div class="modal fade" id="itemdetails-modal"   tabindex="-1" role="dialog" aria-labelledby="itemdetails-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="itemdetails-modalLabel">Form Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="table-responsive">
                                <table id="tbl_itemdetails" class = "table table-bordered table-stripped cell-border" style = "width: 100%">
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table id="tbl_supplierdetails" class = "table table-bordered table-stripped cell-border" style = "width: 100%">       
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('navigation/footer')
    <script>
        $(document).ready(function() {
            $(function(){
                var dtToday = new Date();

                var month = dtToday.getMonth() + 1;
                var day = dtToday.getDate();
                var year = dtToday.getFullYear();

                if(month < 10)
                    month = '0' + month.toString();
                if(day < 10)
                    day = '0' + day.toString();

                var maxDate = year + '-' + month + '-' + day;    
                $('#date').attr('max', maxDate);
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token':$("input[name=_token").val()
                }
            })
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

            // mini jQuery plugin that formats to two decimal places
            (function($) {
                $.fn.currencyFormat = function() {
                    this.each( function( i ) {
                        $(this).change( function( e ){
                            if( isNaN( parseFloat( this.value ) ) ) return;
                            this.value = parseFloat(this.value).toFixed(2);
                        });
                    });
                    return this; //for chaining
                }
            })( jQuery );

            // apply the currencyFormat behaviour to elements with 'currency' as their class
            $( function() {
                $('.currency').currencyFormat();
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
            show_allUnits();
            show_allBrands();
            show_allDesignatedOffices();
            show_allItemCategories();
            show_allSuppliers();
            show_allItems();
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
                    columnDefs: [
                        {
                            className: "text-center", // Add 'text-center' class to the targeted column
                            targets: [0, 1, 3, 7, 8, 10, 11] // Replace 'columnIndex' with the index of your targeted column (starting from 0)
                        },
                        {
                            className: "text-right", // Add 'text-center' class to the targeted column
                            targets: [ 5, 6] // Replace 'columnIndex' with the index of your targeted column (starting from 0)
                        },
                    ],
                    dom: 'lBfrtip',
                    buttons: [
                        'length',
                        {
                            extend: 'copy',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-primary btn-sm',
                        },  
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-success btn-sm',
                        },  
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-secondary btn-sm',
                            orientation: 'portrait',
                            pageSize: 'LEGAL',
                        },
                    ],
                    initComplete: function () {
                        this.api().buttons().container().appendTo('#export_buttons');
                    },
                    columns: [
                        { data: 'checkboxes', name: 'checkboxes' },
                        { data: 'date', name: 'date' },
                        { data: 'item', name: 'item' },
                        { data: 'unit', name: 'unit' },
                        { data: 'brand', name: 'brand' },
                        { data: 'cost', name: 'cost' },
                        { data: 'totalCost', name: 'totalCost' },
                        { data: 'stock', name: 'stock' },
                        { data: 'category', name: 'category' },
                        { data: 'name', name: 'name' },
                        // { data: 'department_name', name: 'department_name' },
                        // { data: 'fullname', name: 'fullname' },
                        { data: 'type', name: 'type' },
                        { data: 'actions', name: 'actions' },
                    ],
                   
                });
            }

            $("#open_itemModal").on('click', function(e){
                e.preventDefault();
                showModal();
                $("#item-modalLabel").text('Create New Item')
                resetInputFields();
            })
            $("#cost").on('keyup', function(e){
                e.preventDefault();
                var totalCost = $(this).val()*$("#quantity").val();
                $("#totalCost").val(totalCost);
            })
            $("#quantity").on('keyup', function(e){
                var quantity = parseInt($(this).val());
                if(quantity < 0)
                {
                    $(this).val(0);
                }

                var stock = parseInt($("#stock").val());
                var quantity = parseInt($(this).val());
                var pstock = parseInt($("#pstock").val());

                if(pstock != 0)
                {
                    if(!isNaN(quantity) && quantity > 0)
                    {
                        var totalCost = quantity*$("#cost").val();
                        var totalStock = ((stock + quantity));
                        $("#totalCost").val(totalCost);
                        $("#stock").val(totalStock);
                    }
                    else $("#stock").val(pstock);
                }
                else
                {
                    var totalCost = quantity*$("#cost").val();
                    $("#totalCost").val(totalCost);
                    $("#stock").val(quantity);
                }
            })
            $("#quantity").on('keydown', function(e){
                var quantity = parseInt($(this).val());
                if(quantity < 0)
                {
                    $(this).val(0);
                }
            })
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#table tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            $("#btn_reStock").click(function(e){
                var array = [];
                $("input:checkbox[name=itemCheck]:checked").each(function() { 
                    array.push($(this).val()); 
                });     
                if(array.length > 0)
                {
                    if(confirm("Do you wish to re-stock the selected items?"))
                    {
                        $.ajax({
                            type: 'get',
                            url: '{{ route("supplieritems.resetStock") }}',
                            data: {items: array},
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
                else
                {
                    alert("No item selected.")
                }
            })
            $("#selected_itemtype").on('change', function(e){
                var array = [];
                var supplieritem_ids = [];
                $("input:checkbox[name=itemCheck]:checked").each(function() { 
                    supplieritem_ids.push($(this).data('supplieritem_id'));
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
                                data: {items: array, selected_itemtype: $(this).val(), supplieritem_ids: null},
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
            
            $("#itemAll").click(function(e){
                var table = $(e.target).closest("table");
                $("td input:checkbox", table).prop('checked', this.checked)
            })
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
                $("#preview_image").attr('src', '/upload_images/item.png');
                $("#item-form")[0].reset();
                $("#item_id").val("");
                $("#supplieritem_id").val("");
                $("#movement_id").val("");
                $(".v-error").html("");
                $("input").removeClass('is-invalid');
                $("select").val("");
                $("select").removeClass('is-invalid');
                $("#stock").val("0");
            
            }           
            $("#item-form").on('submit', function(e){
                e.preventDefault();
                if(confirm("Are you sure you want to add this item?"))
                {
                    var formData = new FormData(this);
                    console.log(formData);  
                    $.ajax({
                        url: '{{ route("items.store") }}',
                        type: 'post',
                        data: formData,
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        cache:false,
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
           
            function showModal()
            {
                $("#stock").val(0);
                $("#pstock").val(0);
                $("#item-modal").modal({
                    backdrop: 'static',
                    keyboard: false,
                })
            }
            function selectElement(id, valueToSelect) {    
                let element = document.getElementById(id);
                element.value = valueToSelect;
            }
            function show_allValue(data)
            {
                selectElement("itemcategory_id", data['item'][0].itemcategory_id)
                selectElement("supplier", data['item'][0].supplier_id);
                selectElement("requisition", data['requestItem'][0].purchaser_id)

                $("#supplieritem_id").val(data['item'][0].supplieritem_id);
                $("#movement_id").val(data['item'][0].movement_id);
                $("#item_id").val(data['item'][0].item_id); 
                $("#requisitionItem_id").val(data['requestItem'][0].requestingitem_id); 

                if(data['item'][0].image != null)
                    $("#preview_image").attr('src', '/upload_images/'+data['item'][0].image);
                else
                    $("#preview_image").attr('src', '/upload_images/item.png');

                $("#item").val(data['item'][0].item);
                $("#date").val(data['item'][0].date);
                $("#unit").val(data['item'][0].unit);
                $("#stock").val(data['item'][0].stock);
                $("#pstock").val(data['item'][0].stock)
                $("#quantity").val(data['item'][0].quantity);
                $("#brand").val(data['item'][0].brand);
                $("#cost").val(data['item'][0].cost);
                $("#serialnumber").val(data['item'][0].serialnumber);
                $("#modelnumber").val(data['item'][0].modelnumber);
                $("#totalCost").val(data['item'][0].totalCost);
                $("#remarks").val(data['item'][0].remarks);
                $("#no_ofYears").val(data['item'][0].no_ofYears);
            }
            $("#table tbody ").on('click', '.edit', function(){
                show_allDesignatedOffices();
                show_allItemCategories();
                show_allSuppliers();
                show_allUnits();
                show_allItems();
                var item_id = $(this).data('id');
                $.ajax({
                    type: 'get',
                    url: "/items/" + item_id + "/edit",
                    dataType: 'json',
                    success: function(data)
                    {        
                        $("#item-modalLabel").text('Edit Item');  
                        showModal();  
                        show_allValue(data);
                    },
                    error: function(data)
                    {
                        alert("Server Error.");
                    }
                })
            })
            $("#table tbody ").on('click', '.view', function(){
                var item_id = $(this).data('id');
                $.ajax({
                    type: 'get',
                    url: "/items/" + item_id + "/edit",
                    dataType: 'json',
                    success: function(data)
                    {
                        $("#itemdetails-modalLabel").text('Item Details and Transaction');  
                    
                        $("#item").val(data['item'][0].item);
                        $("#unit").val(data['item'][0].unit);
                        $("#stock").val(data['item'][0].stock);
                        $("#pstock").val(data['item'][0].stock)
                        $("#quantity").val(data['item'][0].quantity);
                        $("#brand").val(data['item'][0].brand);
                        $("#cost").val(data['item'][0].cost);
                        $("#totalCost").val(data['item'][0].totalCost);

                        var content = "<tbody >";
                        content += "<tr style = 'background-color: #2C4B5F; color: white'>";
                        content += "<td colspan = '2'>Item Details</td>";
                        content += "</tr>";
                        content += "<tr >";
                        content += "<td>Date of Transaction</td>";
                        content += "<td>"+data['item'][0].transactedOn+"</td>";
                        content += "</tr>";
                        content += "<tr>";
                        content += "<td>Item</td>";
                        content += "<td>"+data['item'][0].item+"</td>";
                        content += "</tr>";
                        content += "<tr>";
                        content += "<td>Unit</td>";
                        content += "<td>"+data['item'][0].unit+"</td>";
                        content += "</tr>";
                        content += "<tr>";
                        content += "<td>Quantity</td>";
                        content += "<td>"+data['item'][0].quantity+"</td>";
                        content += "</tr>";
                        content += "<tr>";
                        content += "<td>Brand</td>";
                        content += "<td>"+data['item'][0].brand+"</td>";
                        content += "</tr>";
                        content += "<tr>";
                        content += "<td>Cost</td>";
                        content += "<td>"+data['item'][0].cost+"</td>";
                        content += "</tr>";
                        content += "<tr>";
                        content += "<td>Total Cost</td>";
                        content += "<td>"+data['item'][0].totalCost+"</td>";
                        content += "</tr>";
                        content += "<tr>";
                        content += "<td>Date Acquired</td>";
                        content += "<td>"+data['item'][0].date+"</td>";
                        content += "</tr>";
                        content += "<tr>";
                        content += "<tr>";
                        content += "<td>Serial Number</td>";
                        content += "<td>"+data['item'][0].serialnumber+"</td>";
                        content += "</tr>";
                        content += "<tr>";
                        content += "<td>Model Number</td>";
                        content += "<td>"+data['item'][0].modelnumber+"</td>";
                        content += "</tr>";
                        content += "<tr>";
                        content += "<tr>";
                        content += "<td>Years Validity</td>";
                        content += "<td>"+data['item'][0].no_ofYears+"</td>";
                        content += "</tr>";
                        content += "<tr>";
                        content += "<td>Years Existence</td>";
                        content += "<td>"+data['item'][0].age+"</td>";
                        content += "</tr>";
                        content += "<tr>";
                        content += "<td>Date Released</td>";
                        content += "<td>"+data['item'][0].dateReleased +"</td>";
                        content += "</tr>";
                        content += "<tr>";
                        content += "<td>Date Purchased</td>";
                        content += "<td>"+data['item'][0].datePurchased +"</td>";
                        content += "</tr>";
                        content += "<tr>";
                        content += "<td>Remarks</td>";
                        content += "<td>"+data['item'][0].remarks+"</td>";
                        content += "</tr>";
                        content += "</tbody>";

                        $("#tbl_itemdetails tbody").html(content);

                        var content2 = "<tbody >";
                        content2 += "<tr style = 'background-color: #2C4B5F; color: white'>";
                        content2 += "<td colspan = '2'>Supplier Details</td>";
                        content2 += "</tr>";
                        content2 += "<tr >";
                        content2 += "<td>Supplier Name</td>";
                        content2 += "<td>"+data['item'][0].name+"</td>";
                        content2 += "</tr>";
                        content2 += "<tr>";
                        content2 += "<td>Supplier Address</td>";
                        content2 += "<td>"+data['item'][0].address+"</td>";
                        content2 += "</tr>";
                        content2 += "<tr>";
                        content2 += "<td>Contact Number</td>";
                        content2 += "<td>"+data['item'][0].supp_contactNo+"</td>";
                        content2 += "</tr>";
                        content2 += "<tr>";
                        content2 += "<td colspan = '2'></td>";
                        content2 += "</tr>";
                        content2 += "<tr style = 'background-color: #2C4B5F; color: white'>";
                        content2 += "<td colspan = '2'>Purchaser Details</td>";
                        content2 += "</tr>";
                        content2 += "<tr >";
                        content2 += "<td>Purchaser Name</td>";
                        content2 += "<td>"+data['requestItem'][0].fullname+"</td>";
                        content2 += "</tr>";
                        content2 += "<tr >";
                        content2 += "<td>Position</td>";
                        content2 += "<td>"+data['requestItem'][0].position+"</td>";
                        content2 += "</tr>";
                        content2 += "<tr >";
                        content2 += "<td>Contact Number</td>";
                        content2 += "<td>"+data['requestItem'][0].contact_number+"</td>";
                        content2 += "</tr>";
                        content2 += "<tr >";
                        content2 += "<td>Department</td>";
                        content2 += "<td>"+data['requestItem'][0].department_name+"</td>";
                        content2 += "</tr>";
                        content2 += "<tr>";
                        content2 += "<td colspan = '2'></td>";
                        content2 += "</tr>";
                        content2 += "<tr style = 'background-color: lightgreen'>";
                        content2 += "<td>Updated By</td>";
                        content2 += "<td>"+data['item'][0].lastAction+"</td>";
                        content2 += "</tr>";

                        content2 += "<tr>";
                        content2 += "<td colspan = '2'></td>";
                        content2 += "</tr>";
              
                        if(data['item'][0].image != null)
                        {
                            content2 += "<tr align='center'>";
                            content2 += "<td colspan = '2'><img src = '/upload_images/"+data['item'][0].image+"' style = 'height: 180px; width: 180px;'></img></td>";
                            content2 += "</tr>";
                        }
                        else 
                        {
                            content2 += "<tr align='center'>";
                            content2 += "<td colspan = '2'><img src = '/upload_images/item.png' style = 'height: 180px; width: 180px;'></img></td>";
                            content2 += "</tr>";
                          
                        }
                        content2 += "</tbody>";
                        $("#tbl_supplierdetails tbody").html(content2);

                        $("#itemdetails-modal").modal({
                            backdrop: 'static',
                            keyboard: false,
                        })
                    },
                    error: function(data)
                    {
                        alert("Server Error.");
                    }
                })
            })
            

            let block_image = null;
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#preview_image').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#image").change(function(e){
                block_image = e.target.files[0];
                readURL(this);
            });

            function show_allUnits()
            {
                $.ajax({
                    type: 'get',
                    url: "{{route('items.units')}}",
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
            function show_allBrands()
            {
                $.ajax({
                    type: 'get',
                    url: "{{route('items.brands')}}",
                    dataType: 'json',
                    success: function(data)
                    {
                        var option = "";
                        for(var i = 0; i<data.length; i++)
                        {
                            option += "<option value = "+data[i].brand+"></option>";
                        }
                        $("#brands").html(option);
                    },
                    error: function(data)
                    {
                        alert("Server Error.");
                    }
                })
            }
            function show_allItems()
            {
                $.ajax({
                    type: 'get',
                    url: "{{ route('items.get_allItemOnly') }}",
                    dataType: 'json',
                    success: function(data)
                    {
                        var option = "";
                        for(var i = 0; i<data.length; i++)
                        {
                            option += "<option value = "+data[i].item+"></option>";
                        }
                        $("#item-options").html(option);
                    },
                    error: function(data)
                    {
                        alert("Server Error.");
                    }
                })
            }

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
            
            function show_allDesignatedOffices()
            {
                $.ajax({
                    type: 'get',
                    url: "{{ route('users.allRequisitions') }}",
                    dataType: 'json',
                    success: function(data)
                    {
                        var option = "<optgroup>";
                        option += "<option value = ''>--Please Select Here --</option>";
                        for(var i = 0; i<data.length; i++)
                        {
                            option += "<option value = "+data[i].purchaser_id+">"+data[i].department_name+" "+data[i].fullname+"</option>";
                        }
                        option += "</optgroup>";
                        $("#requisition").html(option);
                    },
                    error: function(data)
                    {
                        alert("Server Error.");
                    }
                })
            }
            function show_allItemCategories()
            {
                $.ajax({
                    type: 'get',
                    url: "{{ route('itemcategories.get_allDataByJson') }}",
                    dataType: 'json',
                    success: function(data)
                    {
                        var option = "<optgroup>";
                        option += "<option value = ''>--Please Select Here --</option>";
                        for(var i = 0; i<data.length; i++)
                        {
                            if(data[i].status == 1)
                            {
                                option += "<option value = "+data[i].id+">"+data[i].category+"</option>";
                            }
                        }
                        option += "</optgroup>";
                        $("#itemcategory_id").html(option);
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
                        { data: 'vatReg', name: 'vatReg' },
                        { data: 'tin', name: 'tin' },
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
                                    $("#"+key).addClass('is-invalid');
                                    $("#"+key+"-msg").html(value);
                                    // if(key == "name")
                                    // {
                                    //     $("#name").addClass('is-invalid');
                                    //     $("#name-msg").html(value);
                                    // }
                                    // if(key == "contact_number")
                                    // {
                                    //     $("#contact_number").addClass('is-invalid');
                                    //     $("#contact_number-msg").html(value);
                                    // }
                                    // if(key == "address")
                                    // {
                                    //     $("#address").addClass('is-invalid');
                                    //     $("#address-msg").html(value);
                                    // }
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
                        $("#vatReg").val(data.vatReg);
                        $("#tin").val(data.tin);
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

            //Filter Module
            $("#btn_filterModal").click(function(e){
                $("#filter-modal").find('.modal-title').text('Filter Report');
                $("#filter-modal").modal({
                    backdrop: 'static',
                    keyboard: false,
                });
            })

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
        });
    </script>