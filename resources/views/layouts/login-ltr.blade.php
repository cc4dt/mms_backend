<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{csrf_token()}}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name', 'HAM') }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="{{ asset('js/app.js') }}" defer></script>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <!-- Font Awesome -->
  
<link rel="stylesheet" href="{{asset('LTR/plugins/datatables/dataTables.bootstrap4.css')}}">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('LTR/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('LTR/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('LTR/dist/css/adminlte.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('LTR/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('LTR/plugins/toastr/toastr.min.css')}}">
   <link href="{{ asset('Inline-Valideater/jquerysctipttop_ltr.css')}}" rel="stylesheet" type="text/css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('LTR/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ asset('LTR/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{ asset('LTR/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('LTR/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('LTR/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{ asset('LTR/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="{{ asset('LTR/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">
  <link rel="stylesheet" href="{{ asset('LTR/plugins/datepicker/datepicker3.css')}}">
  <link rel="stylesheet" href="{{ asset('LTR/plugins/summernote/summernote-bs4.css')}}">
</head>
<body class="hold-transition login-page">

  <div class="col-md-4">
<div class="card card-info">
  <div class="card-header">
    <a href="/home"><b>Login </b></a>
  </div>
  <!-- /.login-logo -->
  
    <div class="card-body ">
    
      
     
      <p class="login-box-msg">  </p>

      @yield('content') 

      <br>     
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.card -->

<!-- jQuery -->
<script src="{{asset('LTR/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('LTR/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('LTR/dist/js/adminlte.min.js')}}"></script>

</body>
</html>
