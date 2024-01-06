<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8" />
 <meta http-equiv="X-UA-Compatible" content="IE=edge" />
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
 <meta name="description" content="" />
 <meta name="author" content="" />
 <meta name="csrf-token" content="{{ csrf_token() }}">
 <link rel="icon" type="image/png" href="admintemplate/assets/img/round.png">
 <title>IMS</title>
 <link rel="stylesheet" href="{{ asset('bootstrap.min.css') }}"  rel="stylesheet" >
 <link href="{{ asset('admintemplate/css/styles.css')}}" rel="stylesheet" />
 <link href="{{ asset('chart.js/Chart.css')}}" rel="stylesheet" />
 <link href="{{ asset('chart.js/Chart.min.css')}}" rel="stylesheet" />


 <!-- <link href="{{ asset('admintemplate/css/datatables-buttons.min.css')}}" rel="stylesheet" /> -->
 <!-- scripts -->
 <!-- <script src="{{ asset('admintemplate/js/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script> -->
 <link href="{{ asset('admintemplate/css/jquery-ui.css')}}" rel="stylesheet" />
 <script src="{{ asset('admintemplate/js/jquery.js') }}"></script>

 @include('scripts/clock')
 <!-- <script src="{{ asset('admintemplate/js/jquery-ajax.min.js') }}"></script> -->
  <!-- <script src="{{ asset('jquery.slim.min.js') }}"></script>  -->
 <script src="{{ asset('admintemplate/js/jquery.datatables.min.js') }}" crossorigin="anonymous"></script>
 <link href="{{ asset('admintemplate/css/datatables.min.css')}}" rel="stylesheet" />
 <script src="{{ asset('admintemplate/js/datatables-buttons.min.js') }}" crossorigin="anonymous"></script>
 <script src="{{ asset('admintemplate/js/jszip.min.js') }}" crossorigin="anonymous"></script>
 <script src="{{ asset('admintemplate/js/pdfmake.min.js') }}" crossorigin="anonymous"></script>
 <script src="{{ asset('admintemplate/js/vsf_fonts.js') }}" crossorigin="anonymous"></script>
 <script src="{{ asset('admintemplate/js/buttons.html5.min.js') }}" crossorigin="anonymous"></script>
 <script src="{{ asset('admintemplate/js/buttons.print.min.js') }}" crossorigin="anonymous"></script>
 <script src="{{ asset('admintemplate/js/all.js') }}" crossorigin="anonymous"></script>
 <script src="{{ asset('admintemplate/js/scripts.js') }} "></script>
 <script src="{{ asset('admintemplate/js/bootstrap.min.js') }} "></script>
 <script src="{{ asset('admintemplate/js/jquery-ui.js') }}"></script>
 <script src="{{ asset('chart.js/Chart.min.js') }}"></script>
 <script src="{{ asset('chart.js/Chart.js') }}"></script>
 <style>
   .sb-nav-fixed #layoutSidenav #layoutSidenav_nav .sb-sidenav {
    padding-top: 40px;
    background-color: #2C4B5F;
    color: white;
  }
  .card-header{
    background-color: #08a4a7;
    color: white;
  }
  table thead{
    background-color: #08a4a7;
    color: white;
  }
  .sb-sidenav .sb-sidenav-menu .nav .nav-link {
    display: flex;
    align-items: center;
    padding-top: 0.75rem;
    padding-bottom: 0.75rem;
    position: relative;
    color: black;
  }
  body{
    font-family: 'Tahoma';
  }
  input[type=number]{
    text-align: right;
  }
  input,textarea{
    text-transform: uppercase;
  }
  input[type=email]{
    text-transform: none; 
  }
  /* #table td,tr,th {
   font-size: 12px;word-break: break-word; word-break: break-all; white-space: normal;
  }
  input,input[type=text],label, span,input[type=number],input[type=tel],#address,optgroup,select{
   font-size: 12px;
  }
  select{
   font-size: 12px;
  } */
  h1.mt-4{
   font-size: 20px;
  }
  .modal-header{
    background-color: #08a4a7;
    color: white;
  }
  .ui-autocomplete {
    z-index: 10000;
    position: absolute;
  }
 </style>
</head>
