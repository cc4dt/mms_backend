
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="csrf-token" content="{{csrf_token()}}">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>{{ config('app.name', 'HAM') }}</title>
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
  <link href="{{ asset('Inline-Valideater/jquerysctipttop_ltr.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('Inline-Valideater/js/jquery.valideater-0.2.2_en.js')}}"></script> 

<script>
$("#ConfirmPassword").change(function () {
    var oldpassword = document.getElementById("oldpassword").value;
    var NewPassword = document.getElementById("NewPassword").value;
    var ConfirmPassword = document.getElementById("ConfirmPassword").value;
   
    if (NewPassword != ConfirmPassword) {
      toastr.error("Password Mis Matches"); 
        
        document.getElementById("ConfirmPassword").value = "";
    }

     if (oldpassword == '') {
      toastr.error("Old Password is Required"); 
      
      }


         if (NewPassword == '') {
      toastr.error("New Password is Required"); 
      
      }
});
</script>
  <script type="text/javascript">
        function PrintDiv() {
            var contents = document.getElementById("modal-body").innerHTML;
            var frame1 = document.createElement('iframe');
            frame1.name = "frame1";
            frame1.style.position = "absolute";
            frame1.style.top = "-1000000px";
            document.body.appendChild(frame1);
            var frameDoc = (frame1.contentWindow) ? frame1.contentWindow : (frame1.contentDocument.document) ? frame1.contentDocument.document : frame1.contentDocument;
            frameDoc.document.open();
            frameDoc.document.write('<html><head><title>HSM ERP</title>');
            frameDoc.document.write('</head><body>');
            frameDoc.document.write(contents);
            frameDoc.document.write('</body></html>');
            frameDoc.document.close();
            setTimeout(function () {
                window.frames["frame1"].focus();
                window.frames["frame1"].print();
                document.body.removeChild(frame1);
            }, 500);
            return false;
        }
   

     function PrintDiv2() {
            var contents = document.getElementById("modal-body").innerHTML;
            var frame1 = document.createElement('iframe');
            frame1.name = "frame1";
            frame1.style.position = "absolute";
            frame1.style.top = "-1000000px";
            document.body.appendChild(frame1);
            var frameDoc = (frame1.contentWindow) ? frame1.contentWindow : (frame1.contentDocument.document) ? frame1.contentDocument.document : frame1.contentDocument;
            frameDoc.document.open();
            frameDoc.document.write('<html><head><title>Orignal Copy</title>');
            frameDoc.document.write('</head><body>');
            frameDoc.document.write(contents);
            frameDoc.document.write('</body><footer style=" position: fixed;  bottom: 0; "><font face="arial" size="2"><strong><br> Orignal Copy </strong></font></footer></html>');
            frameDoc.document.close();
            setTimeout(function () {
                window.frames["frame1"].focus();
                window.frames["frame1"].print();
                document.body.removeChild(frame1);
            }, 500);
            return false;

            
        }

         function PrintDiv3() {
            var contents = document.getElementById("modal-body").innerHTML;
            var frame1 = document.createElement('iframe');
            frame1.name = "frame1";
            frame1.style.position = "absolute";
            frame1.style.top = "-1000000px";
            document.body.appendChild(frame1);
            var frameDoc = (frame1.contentWindow) ? frame1.contentWindow : (frame1.contentDocument.document) ? frame1.contentDocument.document : frame1.contentDocument;
            frameDoc.document.open();
            frameDoc.document.write('<html><head><title>Client Copy</title>');
            frameDoc.document.write('</head><body>');
            frameDoc.document.write(contents);
            frameDoc.document.write('</body><footer style=" position: fixed;  bottom: 0; "><font face="arial" size="2"><strong><br> Client Copy </strong></font></footer></html>');
            frameDoc.document.close();
            setTimeout(function () {
                window.frames["frame1"].focus();
                window.frames["frame1"].print();
                document.body.removeChild(frame1);
            }, 500);
            return false;

            
        }

    function PrintDiv4() {
            var contents = document.getElementById("modal-body").innerHTML;
            var frame1 = document.createElement('iframe');
            frame1.name = "frame1";
            frame1.style.position = "absolute";
            frame1.style.top = "-1000000px";
            document.body.appendChild(frame1);
            var frameDoc = (frame1.contentWindow) ? frame1.contentWindow : (frame1.contentDocument.document) ? frame1.contentDocument.document : frame1.contentDocument;
            frameDoc.document.open();
            frameDoc.document.write('<html><head><title>HAM Copy</title>');
            frameDoc.document.write('</head><body>');
            frameDoc.document.write(contents);
            frameDoc.document.write('</body><footer style=" position: fixed;  bottom: 0; "><table border="0" width="100%"><tr><td align="center"><font face="arial" size="2"><strong> HAM Copy </strong></font></td></tr></table></footer></html>');
            frameDoc.document.close();
            setTimeout(function () {
                window.frames["frame1"].focus();
                window.frames["frame1"].print();
                document.body.removeChild(frame1);
            }, 500);
            return false;

            
        }

$('#modal-change').on('show.bs.modal',function(event){
  
var button =$(event.relatedTarget)

var modal=$(this)


})

</script>

</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{'jj'}}" class="nav-link">Home</a>      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">


<!-- Messages Dropdown Menu -->
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">

        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-users"></i>
          <span class="badge badge-danger navbar-badge"></span>        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <center>
        <div class="image">
          <img src="{{ asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" width="110" height="100" alt="User Image">
        </div>
       
          <a href="#" class="d-block"></a>
       
     </center>

     <table border="0" width="100%" align="center">
      <tr><td colspan="2" align="center">{{ Auth::user()->name ?? '' }}</td></tr>
      <tr><td align="center" width="60%"> <a href="#" class="dropdown-item dropdown-footer" data-toggle="modal" data-target="#modal-change"> 
                          <image src="{{ asset('dist/img/change.png')}}" width="20" height="20"> Chane My Password  
                          </a>    </td><td align="center" width="40%"> <a href="#" class="dropdown-item dropdown-footer" data-toggle="modal" data-target="#modal-logout"> 
                      <image src="{{ asset('dist/img/exit.png')}}" width="20" height="20">     Logout  
                          </a>   </td></tr>
     
   </table>
        
           
           <div class="dropdown-divider"></div>  

            </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      
      <!-- Notifications Dropdown Menu -->




      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">

        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{ asset('dist/img/user1-128x128.jpg')}}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{ asset('dist/img/user8-128x128.jpg')}}" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{ asset('dist/img/user3-128x128.jpg')}}" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
            class="fas fa-th-large"></i></a>      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="home" class="brand-link">
      <img src="{{ asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light"><font color="black">.</font></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->UserName ?? '' }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
           
          </li>
@if(isset(Auth::user()->IsAdmin))
          @if(Auth::user()->IsAdmin==1)
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-plus-square"></i>
              <p>
                Settings
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
           
              <li class="nav-item">
                <a href="{{ route('User.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Users</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="{{ route('Clients.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Clients</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="{{ route('Blocks.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Blocks</p>
                </a>
              </li>

                <li class="nav-item">
                <a href="{{ route('Locations.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Locations</p>
                </a>
              </li>


 <li class="nav-item">
                <a href="{{ route('Wells.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Wells</p>
                </a>
              </li>

              
                <li class="nav-item">
                <a href="{{ route('Rig.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rig</p>
                </a>
              </li>
             

                <li class="nav-item">
                <a href="{{ route('ServiceCategory.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>ServiceCategory</p>
                </a>
              </li>


               
                <li class="nav-item">
                <a href="{{ route('Currency.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Currency</p>
                </a>
              </li>

               <li class="nav-item">
                <a href="{{ route('Contract.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Contracts</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          @endif
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
               Services
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('Client.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Breakdowns</p>
                </a>
              </li>
              
            </ul>
          </li>

          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Reports
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
<li class="nav-item">
                <a href="{{ route('Client.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tickets Archive</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('Client.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tickets Reports</p>
                </a>
              </li>
              

              
              <li class="nav-item">
                <a href="{{ route('Client.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Items Reports</p>
                </a>
              </li>
              
            </ul>
          </li>
          
          
         
          
          
        </ul>
        
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  @yield('content') 
  <!-- /.content-wrapper -->


