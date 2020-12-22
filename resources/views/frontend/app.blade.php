<!DOCTYPE html>
<html>
<head>
	<title>Unica - University Template</title>
	<meta charset="UTF-8">
	<meta name="description" content="Unica University Template">
	<meta name="keywords" content="event, unica, creative, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Favicon -->   
	<link href="img/favicon.ico" rel="shortcut icon"/>

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i" rel="stylesheet">

  @include('frontend.partials.css')

 <style>
    .is-invalid {
        border: 1px solid red;
    }

    .invalid-feedback {
        color: red;
    }
    .swal2-popup{
        width: 24em!important;
        font-size: 1.2em !important;
    }
    .swal2-styled.swal2-confirm {

        font-size: 1.0625em;
    }
 
    .small-image{
        width: 100px;
        height: 50px;
        border: 1px solid #000;
    }
    .skin-blue .sidebar-menu .treeview-menu>li>router-link {
        color: #8aa4af;
    }
    .router-link-active{
        color: #fff !important;
    }
    .text-danger{
        color: red !important;
    }
    span.badge-danger {
        background: red;
    }
    span.badge-success {
        background: green;
    }
    span.badge-warning {
        background: #f39c12;
        color: #000 !important;
    }
    span.badge-primary {
        background: #3c8dbc;
    }
    .table td {
        border: 1px solid #ddd;

    }
    .table th {
        background-color: #ddd;

    }
    .login{
        display: none; !important;
    }
    .table-image{
        width: 100px;height: 95px
    }
    .barcode{
        margin-bottom: 0px;
    }
    .barcode-number{
        margin-left: 40px;
    }
    .two-percent{
        width: 2% !important;
    }
    .three-percent{
        width: 3% !important;
    }
    .action-btn {
    width: 70px !important;
    margin-bottom: 2px !important;
}
li.dropdown a {
    color: #fff !important;
}
li.dropdown a:hover {
    color: #000 !important;
}
.invoice-header{
    text-align: center;
    display: none;
}
.invoice-header .address {
    margin-top: 6px;
}
.invoice-header .address p {
    margin: 0 0px;
    font-weight: bolder;

}
.invoice-body{
    margin-bottom: 30px;
}
.invoice-body p{
    margin: 0 0px;
}
.toasted.toasted-primary.success {
    width: 400px;
    height: 55px;
    font-size: 18px;
}


.toasted.toasted-primary.error {
    width: 400px;
    height: 55px;
    font-size: 18px;
    font-weight: bolder;
}

 </style>

</head>
<body class="hold-transition skin-blue sidebar-mini" >
<div id="app" class="wrapper">

       <router-view> </router-view>
       <vue-progress-bar></vue-progress-bar>

</div>
<!-- ./wrapper -->

 @include('frontend.partials.js')
<script src="{{ asset('/js/app.js') }}"> </script>
</body>
</html>

