@include('navigation/header')
    <body class="sb-nav-fixed">
       @include('navigation/navigation')
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                @include('navigation/sidebar')
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <!-- <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol> -->
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <h4>Overall Total Items</h4>
                                        <div class="small text-white"><h4>{{ $data['itemCount'] }}</h4></div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="{{ route('items.index') }}">
                                            <img src="{{ asset('admintemplate/assets/img/overallitems.png') }}" alt="" style = "width: 250px; height: 250px">
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <h4>Purchased</h4>
                                        <div class="small text-white"><h4>{{ $data['no_ofPurchased'] }}</h4></div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="{{ route('items.index') }}">
                                            <img src="{{ asset('admintemplate/assets/img/purchase.png') }}" alt="" style = "width: 250px; height: 250px">
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <h4>Released</h4>
                                        <div class="small text-white"><h4>{{ $data['no_ofDelivered'] }}</h4></div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">
                                            <img src="{{ asset('admintemplate/assets/img/delivered.png') }}" alt="" style = "width: 250px; height: 250px">
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <h4>Requisition</h4>
                                        <div class="small text-white"><h4>{{ $data['no_ofRequisition'] }}</h4></div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="{{ route('requestingitems.index') }}">
                                            <img src="{{ asset('admintemplate/assets/img/requisition.png') }}" alt="" style = "width: 250px; height: 250px">
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card mb-4">
                                    <div class="card-header bg-warning" style = "color: black">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Bar Chart of Item Released Per Requesting Office
                                    </div>
                                    <div class="card-body"><canvas id="chart_purchasedItems" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="card mb-4">
                                    <div class="card-header bg-success" style = "color: black">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Bar Chart Purchased Items
                                    </div>
                                    <div class="card-body"><canvas id="chart_releasedItems" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-dark mt-auto" style="">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; IMS-LUGAIT {{ date('Y') }}</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    @include('navigation/footer')
    <script>
        $(document).ready(function(){
            $("#s_dashboard").addClass("active");
        });
    </script>
    <script>
    $(document).ready(function(){
        'use strict'
        var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold',
        }
        function argMax(array) {
            return array.map((x, i) => [x, i]).reduce((r, a) => (a[0] > r[0] ? a : r))[1];
        }
        var mode = 'index'
        var intersect = true
        var years_ofdeads = {{Js::From($years_ofPurchasedLabel)}};
        var deaths_values = {{Js::From($values_ofPurchased)}};
        var salesChart = $('#chart_purchasedItems')
        // eslint-disable-next-line no-unused-vars
        var color = deaths_values.map(x => '#007bff');
        color[argMax(deaths_values)] = 'red';
        var salesChart = new Chart(salesChart, {
        type: 'horizontalBar',
        data: {
            labels: years_ofdeads,
            datasets: [
            {
                backgroundColor: color,
                borderColor: '#007bff',
                data: deaths_values,
            },
            ]
        },
        responsive: true,
        options: {
            maintainAspectRatio: true,
            tooltips: {
            mode: mode,
            intersect: intersect
            },
            hover: {
            mode: mode,
            intersect: intersect
            },
            legend: {
            display: false,
            
            },
            title: {
                display: true, text: 'Items in Requesitioning Office'
            },
            scales: {
            yAxes: [{
                display: true,
                gridLines: {
                display: true,
                // lineWidth: '4px',
                // color: 'rgba(0, 0, 0, .2)',
                zeroLineColor: 'transparent'
                },
                scaleLabel: {
                    display: true,
                    labelString: 'Items'
                },
                ticks: $.extend({
                beginAtZero: true,

                // Include a dollar sign in the ticks
                callback: function (value) {
                    if (value >= 1000) {
                        value /= 1000
                        value += ''
                    }

                    return value
                }
                }, ticksStyle)
            }],
            xAxes: [{
                display: true,
                gridLines: {
                display: false
                },
                scaleLabel: {
                    display: true,
                    labelString: 'Requesting Office'
                },
                ticks: ticksStyle
            }]
            }
        }
        })
    })
    </script>
    <script>
    $(document).ready(function(){
        'use strict'
        var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold',
        }
        function argMax(array) {
            return array.map((x, i) => [x, i]).reduce((r, a) => (a[0] > r[0] ? a : r))[1];
        }
      
        var mode = 'index'
        var intersect = true
        var years_ofdeads = {{Js::From($years_ofReleasedLabel)}};
        var deaths_values = {{Js::From($values_ofReleased)}};
        var salesChart = $('#chart_releasedItems')
        var color = deaths_values.map(x => '#007bff');
        color[argMax(deaths_values)] = 'red';
        // eslint-disable-next-line no-unused-vars
        var salesChart = new Chart(salesChart, {
        type: 'bar',
        data: {
            labels: years_ofdeads,
            datasets: [
            {
                backgroundColor: color,
                borderColor: '#007bff',
                data: deaths_values,
            },
            ]
        },
        options: {
            maintainAspectRatio: true,
            tooltips: {
                mode: mode,
            intersect: intersect
            },
            hover: {
                mode: mode,
                intersect: intersect
            },
            legend: {
                display: false
            },
            scales: {
            yAxes: [{
                display: true,
                gridLines: {
                display: true,
                // lineWidth: '4px',
                // color: 'rgba(0, 0, 0, .2)',
                zeroLineColor: 'transparent'
                },
                scaleLabel: {
                    display: true,
                    labelString: 'No. Of Items'
                },
                ticks: $.extend({
                beginAtZero: true,

                // Include a dollar sign in the ticks
                callback: function (value) {
                    if (value >= 1000) {
                        value /= 1000
                        value += ''
                    }

                    return value
                }
                }, ticksStyle)
            }],
            xAxes: [{
                display: true,
                gridLines: {
                display: false
                },
                scaleLabel: {
                    display: true,
                    labelString: 'Year'
                },
                ticks: ticksStyle
            }]
            }
        }
        })
    })
    </script>