<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
 

    <style>


    /* Adjusted styles for positioning and padding of the digital clock */
    .digital-clock {
        font-family: 'Digital', sans-serif;
        font-weight: bold;
        font-size: 36px;
        color: white;
        margin-right: 20px; /* Added margin to move the clock to the left */
        padding: 10px; /* Added padding for spacing */
    }
    </style>
</head>
<body>
    <!-- <nav class="sb-topnav navbar navbar-expand" style="background-color: #2C4B5F;">
       
        <a class="navbar-brand ps-3" href="#" style="color: white; font-family: 'Digital', sans-serif; font-weight: bold; letter-spacing: 2px;">LSHS-IMS</a>
        <button class="btn btn-sm btn-danger order-2 order-lg-0 me-4 me-lg-0" id="logout" >
            <i class="fas fa-sign-out-alt" style="color: white;"></i> Logout
        </button>
        &nbsp;
        <button class="btn btn-sm btn-secondary order-2 order-lg-0 me-4 me-lg-0" id="btn_myRequestItems" >
            <i class="fas fa-exchange-alt" style="color: white;"></i> My Transactions
        </button>
        <a class="btn btn-sm btn-secondary order-2 order-lg-0 me-4 me-lg-0" href = "{{ route('users.userprofile') }}" >
            <i class="fas fa-user" style="color: white;"></i> My Profile
        </a>
        <a class="btn btn-sm btn-secondary order-2 order-lg-0 me-4 me-lg-0" href = "{{ route('purchaser.home') }}" >
            <i class="fas fa-user" style="color: white;"></i> Home
        </a>
        <div class="digital-clock ml-auto">
        <div id="time" style="text-align: right;"></div>
        </div>
    </nav> -->
    <style>
            .topnav {
                overflow: hidden;
                background-color: #333;
            }
            .topnav a {
                float: left;
                color: white;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
                font-size: 17px;
            }
            .topnav a:hover {
                background-color: #ddd;
                color: black;
            }
            .topnav a.active {
                background-color: #2C4B5F;
                color: white;
            }
            .topnav-right {
                float: right;
            }
            .topnav-right .logout:hover{
                background-color: darkred;
                color: white;
            }
            main{
                padding: 16px;
                margin-top: 10px;
                height: 1500px; /* Used in this example to enable scrolling */
            }
            .wrapper {
                display: flex;
                justify-content: space-around;
            }

            .box {
                flex: 0 0 40%;
                text-align: center;
                display: flex;
                flex-direction: column;
                align-items: center;
             border: 1px dashed red;
            }

            button { margin-top: auto; }
    </style>
    <div class="topnav" id="navbar_top">
        <a id = "home" href="{{ route('purchaser.home') }}">Home</a>
        <a href="#" id="btn_myRequestItems">Transactions</a>
        <a href="#" id="btn_myCart">My Requested Items <span class = "badge badge-primary" id = "req_notif" style = "font-size: 10px"></span></a>
        <div class="topnav-right">
            <a id = "btn_profile" href="{{ route('users.userprofile') }}">Profile</a>
            <a id = "logout" href="" class = "logout">Logout</a>
        </div>
    </div>

    <div class="modal fade" id="myRequestedItems-modal"   tabindex="-1" role="dialog" aria-labelledby="myRequestedItems-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document" >
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="myRequestedItems-modalLabel">Form Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="tbl_myRequestedItems" class = "table table-bordered table-stripped cell-border" style = "width: 100%">
                                    <thead>
                                        <tr>
                                            <th>DATE ACQUIRED</th>
                                            <th>ITEM</th>
                                            <th>QUANTITY</th>
                                            <th>DATE RELEASED</th>
                                            <th>STATUS</th>
                                            <th>REASON OF CANCEL</th>
                                        </tr>
                                    </thead>
                                    <tbody><tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myCart-modal"   tabindex="-1" role="dialog" aria-labelledby="myCart-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document" >
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="myCart-modalLabel">Form Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">

                            <table  id = "tbl_purchases" class = "table-bordered table-hovered">
                                <thead>
                                    <tr>
                                        <th>IMAGE</th>
                                        <th>ITEM</th>
                                        <th>STOCK</th>
                                        <th>QTY</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                            <button style = 'display: none' type="button" class = "btn btn-sm btn-success btn-block btn-submit"><i class = "fas fa-save"></i>&nbsp;Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $("#logout").on('click', function(){
                $(this).addClass('active');
                confirm("Do you wish to logout?") ? window.location.href = "{{ route('user.logout') }}" : '';
            })
            show_allRequestedItems();
            function show_allRequestedItems()
            {
                $("#tbl_myRequestedItems").DataTable({
                    processing: true,
                    serverSide: true,
                    searching: true,
                    responsive: true,
                    ajax: '{!! route("purchaser.get_myRequestedItems") !!}',
                    columnDefs:[{
                        className: 'text-center',
                        targets: [0, 2, 3, 4],
                    }],
                    columns: [
                        { data: 'dateTransact', name: 'dateTransact' },
                        { data: 'item', name: 'item' },
                        { data: 'qty', name: 'qty' },
                        { data: 'dateReleased', name: 'dateReleased' },
                        { data: 'status', name: 'status' },
                        { data: 'reasonforCancel', name: 'reasonforCancel' },
                    ],
                });
            }
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
            function AutoReloadTransaction() 
            {
                RefreshTable('#tbl_myRequestedItems', '{!! route("purchaser.get_myRequestedItems") !!}');
            }
            $("#btn_myRequestItems").click(function(){
                AutoReloadTransaction();
                $(".topnav a").removeClass('active');
                $(this).addClass('active');
                $("#myRequestedItems-modalLabel").html('<i class = "fas fa-exchange-alt enlarge-icon" ></i>&nbsp;&nbsp; MY TRANSACTION');  
                $("#myRequestedItems-modal").modal({
                    'backdrop':'static',
                    'keyboard':false,
                })
            })
            $("#btn_myCart").click(function(){
                $(".topnav a").removeClass('active');
                $(this).addClass('active');
                $("#myCart-modalLabel").html('<i class = "fas fa-exchange-alt enlarge-icon" ></i>&nbsp;&nbsp; MY REQUESTED ITEMS');  
                $("#myCart-modal").modal({
                    'keyboard': false,
                    'backdrop': 'static',
                })
            })
        })
    </script>
</body>
</html>
