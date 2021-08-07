@extends('layouts.dashboard-ltr')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </secton>

 <div class="card">
        <div class="card-header">
            <h3 class="card-title">Manage Users</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                        <a href="#" class="dropdown-item">Action</a>

                    </div>
                </div>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>


        <!-- /.card-header -->
        <div class="card-body">
<div class="col-md-3"> 
            <button type="button" class="btn   btn-primary btn-sm " data-toggle="modal" data-target="#modal-save">
                Add New
            </button>
       </div>








</div><!-- end card body -->
</div>
</div><!-- end wrapper -->


<!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2020 <a href="#">DODY - ERP</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.1
    </div>
  </footer>

      <div class="modal fade" id="modal-logout">
        <div class="modal-dialog">
          <div class="modal-content bg-danger">
            <div class="modal-header">
              <h4 class="modal-title">log out system</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>are you sure you wont to exit ?</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default btn-outline-light" data-dismiss="modal">No</button>
             <a href=""> </a>



  <a  href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <button type="button" class="btn btn-success btn-outline-light">Yes</button>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>



            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
<!-- ./wrapper -->




<script src="{{ asset('LTR/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('LTR/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('LTR/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.jssss')}}"></script>
<script src="{{ asset('LTR/dist/js/adminlte.js')}}"></script>
<script src="{{ asset('LTR/dist/js/demo.js')}}"></script>
<script src="{{ asset('LTR/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{ asset('LTR/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{ asset('LTR/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<script src="{{ asset('LTR/plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
<script src="{{ asset('LTR/plugins/chart.js/Chart.min.js')}}"></script>
<script src="{{ asset('LTR/dist/js/pages/dashboard2.js')}}"></script>
<script src="{{ asset('LTR/plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{ asset('LTR/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{ asset('LTR/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{ asset('LTR/plugins/toastr/toastr.min.js')}}"></script>
<script src="{{ asset('LTR/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>


<script>


    @if(count($errors) > 0)
        @foreach($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach

    @endif


      @if(Session::get('result'))
        
            toastr.success("{{ Session::get('result') }}");
       
    @endif
</script>

<script type="text/javascript">

$('#modal-edit').on('show.bs.modal',function(event){
  
var button =$(event.relatedTarget)
var name_val=button.data('name')
var username_val=button.data('username')
var password_val=button.data('password')
var email_val=button.data('email')
var phone_val=button.data('phone')
var id_val=button.data('id')
var isactive_val=button.data('isactive')
var isadmin_val=button.data('isadmin')
var issave_val=button.data('issave')
var isupdate_val=button.data('isupdate')
var isdelete_val=button.data('isdelete')
var isreport_val=button.data('isreport')
var modal=$(this)



modal.find('.modal-body #name').val(name_val)
modal.find('.modal-body #Phone').val(phone_val)
modal.find('.modal-body #username').val(username_val)
modal.find('.modal-body #password').val(password_val)
modal.find('.modal-body #email').val(email_val)
modal.find('.modal-body #id').val(id_val)
modal.find('.modal-body #IsAdmin').prop('checked', isadmin_val);
modal.find('.modal-body #IsActive').prop('checked',isactive_val)
modal.find('.modal-body #IsSave').prop('checked',issave_val)
modal.find('.modal-body #IsUpdate').prop('checked',isupdate_val)
modal.find('.modal-body #IsDelete').prop('checked',isdelete_val)
modal.find('.modal-body #IsReport').prop('checked',isreport_val)

})




$('#modal-delete').on('show.bs.modal',function(event){
  
var button =$(event.relatedTarget)
var name_val=button.data('name')

var id_val=button.data('id')

var modal=$(this)



modal.find('.modal-title #id').val(id_val)

modal.find('.modal-body').text('Are you soure you want to delete user   :[ '+name_val+ ']')

})
</script>



<script type="text/javascript">
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });



  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    $('.swalDefaultSuccess').click(function() {
      Toast.fire({
        type: 'success',
        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.swalDefaultInfo').click(function() {
      Toast.fire({
        type: 'info',
        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.swalDefaultError').click(function() {
      Toast.fire({
        type: 'error',
        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.swalDefaultWarning').click(function() {
      Toast.fire({
        type: 'warning',
        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.swalDefaultQuestion').click(function() {
      Toast.fire({
        type: 'question',
        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });

    $('.toastrDefaultSuccess').click(function() {
      toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultInfo').click(function() {
      toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultError').click(function() {
      toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultWarning').click(function() {
      toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });

    $('.toastsDefaultDefault').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultTopLeft').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        position: 'topLeft',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultBottomRight').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        position: 'bottomRight',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultBottomLeft').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        position: 'bottomLeft',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultAutohide').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        autohide: true,
        delay: 750,
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultNotFixed').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        fixed: false,
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultFull').click(function() {
      $(document).Toasts('create', {
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        icon: 'fas fa-envelope fa-lg',
      })
    });
    $('.toastsDefaultFullImage').click(function() {
      $(document).Toasts('create', {
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        image: '../../dist/img/user3-128x128.jpg',
        imageAlt: 'User Picture',
      })
    });
    $('.toastsDefaultSuccess').click(function() {
      $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Toast Title',
        subtitle: 'Subtitle',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultInfo').click(function() {
      $(document).Toasts('create', {
        class: 'bg-info', 
        title: 'Toast Title',
        subtitle: 'Subtitle',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultWarning').click(function() {
      $(document).Toasts('create', {
        class: 'bg-warning', 
        title: 'Toast Title',
        subtitle: 'Subtitle',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultDanger').click(function() {
      $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Toast Title',
        subtitle: 'Subtitle',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultMaroon').click(function() {
      $(document).Toasts('create', {
        class: 'bg-maroon', 
        title: 'Toast Title',
        subtitle: 'Subtitle',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
  });

</script>

  <script src="{{ asset('Inline-Valideater/js/jquery.valideater-0.2.2_en.js')}}"></script> 
  <script>
  $('form').valideater();
</script>
</body>
</html>

@endsection
