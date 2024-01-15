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
                                            <option value="">--SELECT HERE --</option>
                                            <option value="N"> -- SELECT FOR YEARLY --</option>
                                            <option value="WEEKLY">--SELECT WEEKLY--</option>
                                            <option value=""> -- SELECT BY MONTH --</option>
                                            <option value="1">JANUARY</option>
                                            <option value="2">FEBRUARY</option>
                                            <option value="3">MARCH</option>
                                            <option value="4">APRIL</option>
                                            <option value="5">MAY</option>
                                            <option value="6">JUNE</option>
                                            <option value="7">JULY</option>
                                            <option value="8">AUGUST</option>
                                            <option value="9">SEPTEMBER</option>
                                            <option value="10">OCTOBER</option>
                                            <option value="11">NOVEMBER</option>
                                            <option value="12">DECEMBER</option>
                                            <option value=""> -- SELECT BY QUARTER -- </option>
                                            <option value="Q1">1ST</option>
                                            <option value="Q2">2ND</option>
                                            <option value="Q3">THIRD</option>
                                            <option value="Q4">FOURTH</option>
                                        </select>
                                        <select name="" id=""></select>
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
        showCategory();
        $("#s_mr").addClass('active');
        $("#tbl_report").hide();
        $("#a_print").hide();
        $('#month').change(function(){
            if($('#month option:selected').val() == "WEEKLY"){
                $('html #month').after("<label>Enter the week<input id = 'weeknumber'></input></label>");
            }
            else{
                $('label').remove();
            }
        })
        function numberWithCommas(number) {
            var parts = number.toString().split(".");
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return parts.join(".");
        }
        $("#a_print").click(function(e){
            e.preventDefault();
            var week = $("#weeknumber").val();
            var month = $("#month").val() == "weekly" ? "W"+week : $("#month").val();
            var year = $("#year").val();
            var category = $("#category").val();
            window.open("/admin/monthly/report/print/"+month+"/"+year+"/"+category, "_blank");
        })
        $("#btn-search").click(function(e){
            e.preventDefault();
            var month = $("#month").val();
            var year = $("#year").val();
            var category = $("#category").val();
            if(month == "weekly")
                month = "W"+$("#weeknumber").val();
            if(month !== "" && year !== "" && category !== "")
            {
                $("#a_print").show();
                $("#tbl_report").show();
                showReport(month, year, category);
            }
            else 
            {
                $("#tbl_report").hide();
                $("#a_print").hide();
                alert("Please select month/quarter, category and year");
            }
        })
        function showCategory()
        {
            $.ajax({
                type: 'get',
                url: '{{ route("admin.get_categories") }}',
                dataType: 'json',
                success: function(data){
                    var html = "<option value = ''> -- SELECT CATEGORY HERE --</option>";
                    if(data.length>0)
                    {
                        for(var i=0; i<data.length; i++)
                        {
                           html += "<option value = "+data[i].id+">"+data[i].category+"</option>";
                        }
                    }
                        
                    $("#category").html(html);
                }
            })
        }
        function showReport(month, year, category)
        {
            $.ajax({
                type: 'get',
                url: '/admin/monthly/report/'+month+'/'+year+'/'+category,
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
                            html += "<td >"+data[i].dateRequest+"</td>";
                            html += "<td align='center'>"+data[i].qty+"</td>";
                            html += "<td align='center'>"+data[i].unit+"</td>";
                            html += "<td align='right'>&#8369;&nbsp;"+numberWithCommas(data[i].cost)+"</td>";
                            html += "<td align='right'>&#8369;&nbsp;"+numberWithCommas(data[i].cost*data[i].qty)+"</td>";
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
                        html += "<tr><td colspan = '14'>Sorry no transaction on this date.</td></tr>";
                    }
                    var tfoot = "<td colspan = '5'>TOTAL </td>";
                        tfoot += "<td align='right'>&#8369;&nbsp;"+numberWithCommas(unitvalue)+"</td>";
                        tfoot += "<td align='right' >&#8369;&nbsp;"+numberWithCommas(totalCost)+"</td>";
                    $("#total_res").append(tfoot);
                    $("#tbl_report tbody").html(html);
                }
            })
        }
   </script>