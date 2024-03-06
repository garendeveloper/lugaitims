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
                                    <div class="col-sm-12 justify-content-center"  style = "text-align:center">
                                       REPORT OF PROPERTIES <br>
                                       LUGAIT SENIOR HIGH SCHOOL <br>
                                       DISTRICT OF LUGAIT <br>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <style>
                                    #table td, th {
                                        word-break: break-word; word-break: break-all; white-space: normal; text-align:center;
                                    }
                                </style>
                                <div class="row">
                                    <div class="col-md-3">
                                        <select name="month" id="month" class = "form-control">
                                            <option value="N">--SELECT HERE --</option>
                                            <option value="WEEKLY">--SELECT WEEKLY--</option>
                                            <option value="M"> -- SELECT BY MONTH --</option>
                                            <option value="Q"> -- SELECT BY QUARTER -- </option>
                                        </select>
                                        <p id = "afterElement"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="year" id="year" class = "form-control">
                                            <option value="">--SELECT YEAR HERE --</option>
                                            <?php $year = date('Y') ?>
                                            <?php for($i = $year; $i>=2010; $i--) {?>
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="category" id="category" class = "form-control">
                                            <option value="">--SELECT CATEGORY --</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button id = "btn-search" class = "btn btn-primary btn-block"><i class = "fas fa-search"></i>&nbsp;SEARCH</button>
                                    </div>
                                </div><br>
                                <div class="table-reponsive">
                                    <table id="tbl_report" class = "table table-bordered table-stripped cell-border">
                                        <thead style = "text-tansform: uppercase">
                                            <tr>
                                                <th>ARTICLE</th>
                                                <th>DESCRIPTION (SPECIFICATIONS/SERIAL NUMBER AND ETC)</th>
                                                <th>DATE OF ACQUISITION</th>
                                                <th>QUANTIY</th>
                                                <th>UNIT OF MEASURE</th>
                                                <th>UNIT VALUE</th>
                                                <th>TOTAL COST/VALUE</th>
                                                <th>SOURCE OF FUND (MOOE OR SEF/LGU)</th>
                                                <th>TYPE OF SEMI-EXPANDABLE PROPERTIES</th>
                                                <th>FUND CLUSTER (UACS CODE)</th>
                                                <th>NAME OF SCHOOL</th>
                                                <th>NAME OF ACCOUNTABLE OFFICER</th>
                                                <th>WITH IAR, ICS AND DR? (Y/N)</th>
                                                <th>REMARKS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot >
                                            <tr id = "total_res">
                                           </tr>
                                           <tr>
                                                <td colspan = "14"> 
                                                <a id = "a_print" href="" class = "btn btn-primary btn-block"><i class="fas fa-print"></i> Print</a>
                                                </td>
                                           </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

    @include('navigation/footer')
    <script>
    document.title = "LSHS Reports";
    showCategory();
    $("#s_mr").addClass('active');
    $("#tbl_report").hide();
    $("#a_print").hide();
    
    $('#month').change(function(){
        $('label').remove();
        if($('#month option:selected').val() == "WEEKLY"){
   
            var html = '<label>Select Month</label>';
            html += '<select id="week_month" class="form-control">';
            html += '<option value="1">January</option>';
            html += '<option value="2">February</option>';
            html += '<option value="3">March</option>';
            html += '<option value="4">April</option>';
            html += '<option value="5">May</option>';
            html += '<option value="6">June</option>';
            html += '<option value="7">July</option>';
            html += '<option value="8">August</option>';
            html += '<option value="9">September</option>';
            html += '<option value="10">October</option>';
            html += '<option value="11">November</option>';
            html += '<option value="12">December</option>';
            html += '</select>';
            html += '<label>Select Week</label>';
            html += '<select id="week_number" class="form-control">';
            for (var i = 1; i <= 5; i++) {
                html += '<option value="' + i + '">Week ' + i + '</option>';
            }
            html += '</select>';
            $('#afterElement').html(html);
        }
        else if($('#month option:selected').val() == "Q") {
   
            var html = '<label>Select Quarter</label>';
            html += '<select class="form-control" style="width: 300px" id="_quarter">';
            html += '<option value="Q1">1st Quarter</option>'
            html += '<option value="Q2">2nd Quarter</option>'
            html += '<option value="Q3">3rd Quarter</option>';
            html += '<option value="Q4">4th Quarter</option>';
            html += '</select>';
            $('#afterElement').html(html);
        }
        else if($('#month option:selected').val() == "M") {
   
            var html = '<label>Select Month</label>';
            html += '<select class="form-control" style="width: 300px" id="_month">';
            html += '<option value="1">JANUARY</option>'
            html += '<option value="2">FEBRUARY</option>'
            html += '<option value="3">MARCH</option>';
            html += '<option value="4">APRIL</option>';
            html += '<option value="5">MAY</option>';
            html += '<option value="6">JUNE</option>';
            html += '<option value="7">JULY</option>';
            html += '<option value="8">AUGUST</option>';
            html += '<option value="9">SEPTEMBER</option>';
            html += '<option value="10">OCTOBER</option>';
            html += '<option value="11">NOVEMBER</option>';
            html += '<option value="12">DECEMBER</option>';
            html += '</select>';
            $('#afterElement').html(html);
        }
        else{
            $("#afterElement").html("");
        }
    });

    function numberWithCommas(number) {
        var parts = number.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return parts.join(".");
    }

    $("#a_print").click(function(e){
        e.preventDefault();
        var month = $("#month").val();
        var week_number = 0;
        if(month === "WEEKLY")
        {
            month = $("#week_month").val();
            week_number = $("#week_number").val();
        }
        if(month === "M")
            month = $("#_month").val();
        var year = $("#year").val();
        var category = $("#category").val();
        window.open("/admin/monthly/report/print/"+month+"/"+year+"/"+category+"/"+week_number, "_blank");
    });

    $("#btn-search").click(function(e){
        e.preventDefault();
        var month = $("#month").val();
        var year = $("#year").val();
        var category = $("#category").val();
        var week_number = 0;
        if(month === "M")
        {
            month = $("#_month").val();
        }
        if(month === "WEEKLY")
        {
            month = $("#week_month").val();
            week_number = $("#week_number").val();
        }
        if(month === "Q")
        {
            month = $("#_quarter").val();
        }

        if(month !== "" && year !== "" && category !== "")
        {
            $("#a_print").show();
            $("#tbl_report").show();
            showReport(month, year, category, week_number);
        }
        else 
        {
            $("#tbl_report").hide();
            $("#a_print").hide();
            alert("Please select month/quarter/weekly, category, and year");
        }
    });

    function showCategory() {
        $.ajax({
            type: 'get',
            url: '{{ route("admin.get_categories") }}',
            dataType: 'json',
            success: function(data){
                var html = "<option value=''> -- SELECT CATEGORY HERE --</option>";
                if(data.length>0)
                {
                    for(var i=0; i<data.length; i++)
                    {
                        html += "<option value="+data[i].id+">"+data[i].category+"</option>";
                    }
                }
                $("#category").html(html);
            }
        });
    }

    function showReport(month, year, category, week_number) {
        $.ajax({
            type: 'get',
            url: '/admin/monthly/report/'+month+'/'+year+'/'+category+'/'+week_number,
            dataType: 'json',
            success: function(data){
                var html = "";
                var unitvalue = 0;
                var totalCost = 0;
                if(data.length>0)
                {
                    for(var i=0; i<data.length; i++)
                    {
                        html += "<tr>";
                        html += "<td align='center'>N/A</td>";
                        html += "<td>"+data[i].item+"</td>";
                        html += "<td>"+data[i].dateRequest+"</td>";
                        html += "<td align='center'>"+data[i].qty+"</td>";
                        html += "<td align='center'>"+data[i].unit+"</td>";
                        html += "<td align='right'>&#8369;&nbsp;"+ numberWithCommas(data[i].cost.toFixed(2)) +"</td>";
                        html += "<td align='right'>&#8369;&nbsp;"+ numberWithCommas((data[i].cost*data[i].qty).toFixed(2)) +"</td>";
                        html += "<td align='center'>N/A</td>";
                        html += "<td align='center'>"+data[i].category+"</td>";
                        html += "<td align='center'>N/A</td>";
                        html += "<td>"+data[i].department_name+"</td>";
                        html += "<td align='center'>"+data[i].fullname+"</td>";
                        html += "<td align='center'>N/A</td>";
                        html += "<td align='center'>"+data[i].remarks+"</td>";
                        html += "</tr>";
                        unitvalue += data[i].cost;
                        totalCost += data[i].cost*data[i].qty;
                    }
                }
                else
                {
                    $("#a_print").hide();
                    html += "<tr><td colspan='14'>Sorry no transaction on this date.</td></tr>";
                }
                var tfoot = "<td colspan='5'>TOTAL</td>";
                tfoot += "<td align='right'>&#8369;&nbsp;"+ numberWithCommas(unitvalue.toFixed(2)) +"</td>";
                tfoot += "<td align='right'>&#8369;&nbsp;"+ numberWithCommas(totalCost.toFixed(2)) +"</td>";
                $("#total_res").html(tfoot);
                $("#tbl_report tbody").html(html);
            }
        });
    }
</script>