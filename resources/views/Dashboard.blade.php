
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'HAM') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('dashboard/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dashboard/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
    <!-- Messages Dropdown Menu -->
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">

        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-user"></i>
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
          <span class="badge badge-danger navbar-badge">
          @if(Auth::user()->level_id==1)@endif
          @if(Auth::user()->level_id==2) {{ \App\Ticket::count() }} @endif
          @if(Auth::user()->level_id==3) {{ \App\Ticket::where(['teamleader_id' => Auth::user()->id])->get()->count() }} @endif
          @if(Auth::user()->level_id==4) {{ \App\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count() }} @endif
          @if(Auth::user()->level_id==5) {{ \App\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count() }} @endif
        </span>        </a>
         <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
         
             
        @for($i=1;$i<=9;$i++)  
              <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
                <div class="media-body">
                <h3 class="dropdown-item-title">
                <span class="float-right text-sm text-muted">

          @if(Auth::user()->level_id==1)
          
          @endif
          @if(Auth::user()->level_id==2) 
          {{ \App\Ticket::where(['status_id' => $i])->get()->count() }} : Tickets 
           @endif
          @if(Auth::user()->level_id==3) 
          {{ \App\Ticket::where(['status_id' => $i])->where(['teamleader_id' => Auth::user()->id])->get()->count() }} : Tickets 
          @endif
          @if(Auth::user()->level_id==4) 
          {{ \App\Ticket::where(['status_id' => $i])->where(['created_by_id' => Auth::user()->id])->get()->count() }} : Tickets 
          @endif
          @if(Auth::user()->level_id==5) 
          {{ \App\Ticket::where(['status_id' => $i])->where(['created_by_id' => Auth::user()->id])->get()->count() }} : Tickets 
          @endif
                  
            </span>                </h3>
                <p class="text-sm">{{ \App\TicketStatus::find($i)->name }}</p>
            </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          
          @endfor





        
          <a href="#" class="dropdown-item dropdown-footer">See All</a>        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-bell"></i>
          <span class="badge badge-warning navbar-badge">
           
          @if(Auth::user()->level_id==1)
          
          @endif
          @if(Auth::user()->level_id==2) 
          {{ \App\Ticket::count() }}
           @endif
          @if(Auth::user()->level_id==3) 
          {{ \App\Ticket::where(['status_id' => 6])->where(['teamleader_id' => Auth::user()->id])->get()->count() }}
          @endif
          @if(Auth::user()->level_id==4) 
          {{ \App\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count() }}
          @endif
          @if(Auth::user()->level_id==5) 
          {{ \App\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count() }}
          @endif
          
          </span>        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">
            
         

          @if(Auth::user()->level_id==1)
          
          @endif
          @if(Auth::user()->level_id==2) 
          {{ \App\Ticket::where(['status_id' => 1])->where(['teamleader_id' => Auth::user()->id])->get()->count() }} New Tickets
           @endif
          @if(Auth::user()->level_id==3) 
          {{ \App\Ticket::where(['status_id' => 6])->where(['teamleader_id' => Auth::user()->id])->get()->count() }} New Tickets
          @endif
          @if(Auth::user()->level_id==4) 
          {{ \App\Ticket::where(['status_id' => 1])->where(['created_by_id' => Auth::user()->id])->get()->count() }} New Tickets
          @endif
          @if(Auth::user()->level_id==5) 
          {{ \App\Ticket::where(['status_id' => 1])->where(['created_by_id' => Auth::user()->id])->get()->count() }} New Tickets
          @endif
        
        </span>
          <div class="dropdown-divider"></div>
        
          @if(isset($shownew))
 @foreach($shownew as $data)


          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i>  {{$data->station_en ?? ''}}
            <span class="float-right text-muted text-sm">{{ $show->breakdown_en ?? '' }}</span>          </a>
          <div class="dropdown-divider"></div>
          @endforeach
 @endif

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
    <a href="index3.html" class="brand-link">
      <img src="{{asset('dist/img/AdminLTELogo.png')}}"
           alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">HAM</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <center>
        <div class="image">
          <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
          <br>
          <br>
         <font color="white"> {{ Auth::user()->name ?? '' }}</font>
        </div>
        </center>
    
        
        
           <div class="dropdown-divider"></div>  

      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          
              <li class="nav-item">
                <a href="
                
          @if(Auth::user()->level_id==1)
          
          @endif
          @if(Auth::user()->level_id==2) 
          {{ route('Supervisor.index') }} 
           @endif
          @if(Auth::user()->level_id==3) 
          {{ route('Teamleader.index') }} 
          @endif
          @if(Auth::user()->level_id==4) 
          {{ route('Dealer.index') }} 
          @endif
          @if(Auth::user()->level_id==5) 
          {{ route('Client.index') }} 
          @endif
                
                " class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Breakdowns</p>
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
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> Dashboard / {{ \App\User::LEVELS[Auth::user()->level_id] }}s </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{}}">Home</a></li>
              <li class="breadcrumb-item active"> Dashboards</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div class="row">
      <div class="col-md-5">
          <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Breakdowns</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
                
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Tickets Status</th>
                      <th>Number</th>
                    </tr>
                    </thead>
                    <tbody>
                  <?php
                    $colorarr[1]="badge badge-success";
                    $colorarr[2]="badge badge-danger";
                    $colorarr[3]="badge badge-info";
                    $colorarr[4]="badge badge-warning";
                    $colorarr[5]="badge badge-defaulte";
                    $colorarr[6]="badge badge-primary";
                    $colorarr[7]="badge badge-success";
                    $colorarr[8]="badge badge-danger";
                    $colorarr[9]="badge badge-info";
                   ?>
                    @for($i=1;$i<=9;$i++)
                    <tr>
                    <td>{{ $i}} </td>
                      
                      <td><span class="{{$colorarr[$i]}}">  {{ \App\TicketStatus::find($i)->name}} </span></td>
                      <td>
                        <div class="sparkbar" data-color="#00a65a" data-height="20">   
           @if(Auth::user()->level_id==1)
          
          @endif
          @if(Auth::user()->level_id==2) 
          {{ \App\Ticket::where(['status_id' => $i])->get()->count() }}
           @endif
          @if(Auth::user()->level_id==3) 
          {{ \App\Ticket::where(['status_id' => $i])->where(['teamleader_id' => Auth::user()->id])->get()->count() }}
          @endif
          @if(Auth::user()->level_id==4) 
          {{ \App\Ticket::where(['status_id' => $i])->where(['created_by_id' => Auth::user()->id])->get()->count() }} 
          @endif
          @if(Auth::user()->level_id==5) 
          {{ \App\Ticket::where(['status_id' => $i])->where(['created_by_id' => Auth::user()->id])->get()->count() }}
          @endif</div>
                      </td>
                    </tr>
                   @endfor

                   <tr>
                      <th ><br><br><br><br><br></th>
                      <th></th>
                      <th></th>
                    </tr>

                   
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
      
      
       <div class="col-md-4">
       
        <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Equipments Frequency</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- PIE CHART -->
           
            <!-- /.card -->

        <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Tickets Status</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <div class="card card-info">
              <div class="card-header">
                  <h3 class="card-title">SLA</h3>
                  <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                      </button>
                  </div>
              </div>
              <div class="card-body">
                  <canvas id="pieChartSLA" min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
                <!-- /.card-body -->
            </div>
            <!-- LINE CHART -->
            <div class="card card-info" style="display:none">
              <div class="card-header">
                <h3 class="card-title">Line Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
       </div>
       
       
        <div class="col-md-3">
        
        
        
        
        
        
        
        
        
        
        <!-- =========================================================== -->
        <?php
                    $colorarr[1]="bg-success";
                    $colorarr[2]="bg-danger";
                    $colorarr[3]="bg-info";
                    $colorarr[4]="bg-warning";
                    $colorarr[5]="bg-primary";
                    $colorarr[6]="bg-success";
                    $colorarr[7]="bg-warning";
                    $colorarr[8]="bg-danger";
                    $colorarr[9]="bg-info";
                   ?>
                    @for($i=1;$i<=5;$i++)
                  
                 
       
         
            <div class="info-box {{ $colorarr[$i] }}">
              <span class="info-box-icon"><i class="far fa-bookmark"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{ \App\TicketStatus::find($i)->name}}</span>
                <span class="info-box-number"> 
                  
                @if(Auth::user()->level_id==1)
          
          @endif
          @if(Auth::user()->level_id==2) 
          {{ \App\Ticket::where(['status_id' => $i])->get()->count() }}
          
          Tickets From  
           {{ \App\Ticket::get()->count() }}  
           @endif
          @if(Auth::user()->level_id==3) 
          {{ \App\Ticket::where(['status_id' => $i])->where(['teamleader_id' => Auth::user()->id])->get()->count() }} 
          Tickets From 
          {{ \App\Ticket::where(['teamleader_id' => Auth::user()->id])->get()->count() }}
          @endif
          @if(Auth::user()->level_id==4) 
          {{ \App\Ticket::where(['status_id' => $i])->where(['created_by_id' => Auth::user()->id])->get()->count() }} 
          Tickets From 
          {{ \App\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count() }} 
          @endif
          @if(Auth::user()->level_id==5) 
          {{ \App\Ticket::where(['status_id' => $i])->where(['created_by_id' => Auth::user()->id])->get()->count() }}
          Tickets Form
          {{ \App\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count() }}
          @endif
        </span>

                <div class="progress">
                  <div class="progress-bar" style="width:  @if(Auth::user()->level_id==1)
          
          @endif
          @if(Auth::user()->level_id==2 and (\App\Ticket::count())/(\App\Ticket::get()->count())>0) 
          {{ round(((
            (\App\Ticket::where(['status_id' => $i])->get()->count())/(\App\Ticket::get()->count())
            /
            (\App\Ticket::count())/(\App\Ticket::get()->count())
            )*100),2)
         }}%
           @endif
          @if(Auth::user()->level_id==3 and (\App\Ticket::where(['teamleader_id' => Auth::user()->id])->get()->count())>0) 
          {{ round(((
            (\App\Ticket::where(['status_id' => $i])->where(['teamleader_id' => Auth::user()->id])->get()->count())
            /
            (\App\Ticket::where(['teamleader_id' => Auth::user()->id])->get()->count())
            )*100),2)
           }}%
          @endif
          @if(Auth::user()->level_id==4 and (\App\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count())>0) 
          {{ round(((
            (\App\Ticket::where(['status_id' => $i])->where(['created_by_id' => Auth::user()->id])->get()->count())
            /
            (\App\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count())
            )*100),2)
          
          }}%
          @endif
          @if(Auth::user()->level_id==5 and (\App\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count())>0) 
          {{ round(
            ((\App\Ticket::where(['status_id' => $i])->where(['created_by_id' => Auth::user()->id])->get()->count())
            /
            (\App\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count())
            )*100,2)
          }}%
          @endif"></div>
                </div>
                <span class="progress-description">
          @if(Auth::user()->level_id==1)
          
          @endif
          @if(Auth::user()->level_id==2 and (\App\Ticket::count())/(\App\Ticket::get()->count())>0) 
          {{ round(((
            (\App\Ticket::where(['status_id' => $i])->get()->count())/(\App\Ticket::get()->count())
            /
            (\App\Ticket::count())/(\App\Ticket::get()->count())
            )*100),2)
         }}%
           @endif
          @if(Auth::user()->level_id==3 and (\App\Ticket::where(['teamleader_id' => Auth::user()->id])->get()->count())) 
          {{ round(((
            (\App\Ticket::where(['status_id' => $i])->where(['teamleader_id' => Auth::user()->id])->get()->count())
            /
            (\App\Ticket::where(['teamleader_id' => Auth::user()->id])->get()->count())
            )*100),2)
           }}%
          @endif
          @if(Auth::user()->level_id==4 and (\App\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count())) 
          {{ round(((
            (\App\Ticket::where(['status_id' => $i])->where(['created_by_id' => Auth::user()->id])->get()->count())
            /
            (\App\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count())
            )*100),2)
          
          }}%
          @endif
          @if(Auth::user()->level_id==5 and  (\App\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count())>0) 
          {{ round(((\App\Ticket::where(['status_id' => $i])->where(['created_by_id' => Auth::user()->id])->get()->count())
            /
            (\App\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count()))*100,2)
          }}%
          @endif
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            @endfor
          
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
       
            

        <!-- =========================================================== -->   
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        </div>
      
      </div>
        <div class="row" >
          <div class="col-md-4">
            <!-- AREA CHART -->
            <div class="card card-primary" style="display:none">
              <div class="card-header">
                <h3 class="card-title">Area Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- DONUT CHART -->
           
          </div>
          <!-- /.col (LEFT) -->
          <div class="col-md-3" >
          
          
            <!-- /.card -->

            <!-- BAR CHART -->
            <div class="card card-success" style="display:none">
              <div class="card-header">
                <h3 class="card-title">Bar Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- STACKED BAR CHART -->
            <div class="card card-success" style="display:none">
              <div class="card-header">
                <h3 class="card-title">Stacked Bar Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
        
        
        
        
        <!-- =========================================================== -->
        
        
        <div class="row">


        
        
        
        
        
        
        
        
        
        
        
        <!-- =========================================================== -->
                   <?php
                    $colorarr[1]="bg-success";
                    $colorarr[2]="bg-danger";
                    $colorarr[3]="bg-info";
                    $colorarr[4]="bg-warning";
                    $colorarr[5]="bg-primary";
                    $colorarr[6]="bg-success";
                    $colorarr[7]="bg-warning";
                    $colorarr[8]="bg-danger";
                    $colorarr[9]="bg-info";
                   ?>
                    @for($i=6;$i<=9;$i++)
                  
                 
                    <div class="col-md-3">
         
            <div class="info-box {{ $colorarr[$i] }}">
              <span class="info-box-icon"><i class="far fa-bookmark"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{ \App\TicketStatus::find($i)->name}}</span>
                <span class="info-box-number"> 
                  
                @if(Auth::user()->level_id==1)
          
          @endif
          @if(Auth::user()->level_id==2) 
          {{ \App\Ticket::where(['status_id' => $i])->get()->count() }}
          
          Tickets From  
           {{ \App\Ticket::get()->count() }}  
           @endif
          @if(Auth::user()->level_id==3) 
          {{ \App\Ticket::where(['status_id' => $i])->where(['teamleader_id' => Auth::user()->id])->get()->count() }} 
          Tickets From 
          {{ \App\Ticket::where(['teamleader_id' => Auth::user()->id])->get()->count() }}
          @endif
          @if(Auth::user()->level_id==4) 
          {{ \App\Ticket::where(['status_id' => $i])->where(['created_by_id' => Auth::user()->id])->get()->count() }} 
          Tickets From 
          {{ \App\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count() }} 
          @endif
          @if(Auth::user()->level_id==5) 
          {{ \App\Ticket::where(['status_id' => $i])->where(['created_by_id' => Auth::user()->id])->get()->count() }}
          Tickets Form
          {{ \App\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count() }}
          @endif
        </span>

                <div class="progress">
                  <div class="progress-bar" style="width:  @if(Auth::user()->level_id==1)
          
          @endif
          @if(Auth::user()->level_id==2 and  (\App\Ticket::count())/(\App\Ticket::get()->count())>0) 
          {{ round(((
            (\App\Ticket::where(['status_id' => $i])->get()->count())/(\App\Ticket::get()->count())
            /
            (\App\Ticket::count())/(\App\Ticket::get()->count())
            )*100),2)
         }}%
           @endif
          @if(Auth::user()->level_id==3 and (\App\Ticket::where(['teamleader_id' => Auth::user()->id])->get()->count())>0) 
          {{ round(((
            (\App\Ticket::where(['status_id' => $i])->where(['teamleader_id' => Auth::user()->id])->get()->count())
            /
            (\App\Ticket::where(['teamleader_id' => Auth::user()->id])->get()->count())
            )*100),2)
           }}%
          @endif
          @if(Auth::user()->level_id==4 and  (\App\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count())>0) 
          {{ round(((
            (\App\Ticket::where(['status_id' => $i])->where(['created_by_id' => Auth::user()->id])->get()->count())
            /
            (\App\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count())
            )*100),2)
          
          }}%
          @endif
          @if(Auth::user()->level_id==5 and (\App\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count()))*100,2)>0) 
          {{ round(((\App\Ticket::where(['status_id' => $i])->where(['created_by_id' => Auth::user()->id])->get()->count())
            /
            (\App\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count()))*100,2)
          }}%
          @endif"></div>
                </div>
                <span class="progress-description">
          @if(Auth::user()->level_id==1)
          
          @endif
          @if(Auth::user()->level_id==2 and (\App\Ticket::count())/(\App\Ticket::get()->count())>0) 
          {{ round(((
            (\App\Ticket::where(['status_id' => $i])->get()->count())/(\App\Ticket::get()->count())
            /
            (\App\Ticket::count())/(\App\Ticket::get()->count())
            )*100),2)
         }} %
           @endif
          @if(Auth::user()->level_id==3 and (\App\Ticket::where(['teamleader_id' => Auth::user()->id])->get()->count())>0) 
          {{ round(((
            (\App\Ticket::where(['status_id' => $i])->where(['teamleader_id' => Auth::user()->id])->get()->count())
            /
            (\App\Ticket::where(['teamleader_id' => Auth::user()->id])->get()->count())
            )*100),2)
           }}
          @endif
          @if(Auth::user()->level_id==4 and  (\App\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count())>0) 
          {{ round(((
            (\App\Ticket::where(['status_id' => $i])->where(['created_by_id' => Auth::user()->id])->get()->count())
            /
            (\App\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count())
            )*100),2)
          
          }} %
          @endif
          @if(Auth::user()->level_id==5 and (\App\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count())>0) 
          {{ round(((\App\Ticket::where(['status_id' => $i])->where(['created_by_id' => Auth::user()->id])->get()->count())
            /
            (\App\Ticket::where(['created_by_id' => Auth::user()->id])->get()->count())
            )*100,2)
          }} %
          @endif
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            </div>
            @endfor
          
            <!-- /.info-box -->
          
          <!-- /.col -->
       
            

        <!-- =========================================================== -->   
        
        
        
        
        
        
        
      
        
        
        
        
        
        
        
        
        
        
        
        
        
        

        </div>
        
        <!-- =========================================================== -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b></b>
    </div>
    <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="https://ham.sd">HAM</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Add Content Here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->




<div class="modal fade" id="modal-change">
        <div class="modal-dialog">
          <div class="modal-content bg-default">
            <div class="modal-header">
              <h4 class="modal-title">Change My Password</h4>
                                            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
           
            <div class="modal-body">
   <form method="POST" action="{{asset('change')}}">
     
      @csrf
                 
    <div class="row">
    <div class="col-md-6">
    <label>Email</label>
    <input id="username" type="hidden" name="username" class="form-control" value="{{ Auth::user()->UserName ?? '' }}">
    <input id="id" type="hidden" name="id" class="form-control" value="{{ Auth::user()->id ?? '' }}">
    <input id="email" type="email" name="email" readonly="true" class="form-control" value="{{ Auth::user()->email ?? '' }}">
    </div>  
     <div class="col-md-6" >
    <label>Old Password</label>
    <input id="Oldpassword2" type="hidden" name="Oldpassword2" class="form-control " value="{{ Auth::user()->password ?? '' }}">
    <input id="Oldpassword" type="password" name="Oldpassword" class="form-control @error('Oldpassword') is-invalid @enderror" data-vldtr="required" autocomplete="off">
    </div>  
    </div>     
    <div class="row">
   
    <div class="col-md-6">
    <label>New Password</label>
    <input id="NewPassword" type="password" name="NewPassword"  data-vldtr="required" class="form-control @error('NewPassword') is-invalid @enderror">
    </div> 
    <div class="col-md-6">
    <label>Confirm Password</label>
    <input id="ConfirmPassword" type="password" name="ConfirmPassword" 
    class="form-control @error('ConfirmPassword') is-invalid @enderror" data-vldtr="matches" data-vldtr-matches="NewPassword"  class="form-control">
    </div>  
    </div>
              
       

                      
    </div>
              <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default btn-outline-light" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-success btn-outline-light">Change</button>
              </form>
              </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>


<div class="modal fade" id="modal-logout">
        <div class="modal-dialog modal-sm">
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
<!-- jQuery -->
<script src="{{asset('dashboard/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('dashboard/plugins/chart.js/Chart.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dashboard/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dashboard/dist/js/demo.js')}}"></script>


<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dashboard/dist/js/pages/dashboard2.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label               : 'Digital Goods',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [28, 48, 40, 19, 86, 27, 90]
        },
        {
          label               : 'Electronics',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [65, 59, 80, 81, 56, 55, 40]
        },
      ]
    }

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    new Chart(areaChartCanvas, {
      type: 'line',
      data: areaChartData,
      options: areaChartOptions
    })

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: lineChartData,
      options: lineChartOptions
    })


    <?php
                    $colorarr[1]="#f56954";
                    $colorarr[2]="#00a65a";
                    $colorarr[3]="#f39c12";
                    $colorarr[4]="#00c0ef";
                    $colorarr[5]="#3c8dbc";
                    $colorarr[6]="#d2d6de";
                    $colorarr[7]="#e83e8c";
                    $colorarr[8]="#6f42c1";
                    $colorarr[9]="#001f3f";
                    $colorarr[10]="#01ff70";
                   ?>
    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
          
       
@if(isset($equipmentdata))
 @foreach($equipmentdata as $data)
'{{$data->name_en ?? ''}}',
 @endforeach
 @endif

   
             ],
      datasets: [
        {
          data: [
            
            @for($i=1;$i<=10;$i++)
            @if(Auth::user()->level_id==1)
          
          @endif
          @if(Auth::user()->level_id==2) 
          {{ \App\Ticket::where(['equipment_id' => $i])->get()->count() }}, 
           @endif
          @if(Auth::user()->level_id==3) 
          {{ \App\Ticket::where(['equipment_id' => $i])->where(['teamleader_id' => Auth::user()->id])->get()->count() }}, 
          @endif
          @if(Auth::user()->level_id==4) 
          {{ \App\Ticket::where(['equipment_id' => $i])->where(['created_by_id' => Auth::user()->id])->get()->count() }},
          @endif
          @if(Auth::user()->level_id==5) 
          {{ \App\Ticket::where(['equipment_id' => $i])->where(['created_by_id' => Auth::user()->id])->get()->count() }} ,
          @endif
         @endfor

          ],
          backgroundColor : [
            
            @for($i=1;$i<=10;$i++)
            '{{$colorarr[$i]}}',
            @endfor
          
          ],
        }
      ]
    }


    var donutData2        = {
      labels: [
          
       

@for($i=1;$i<=9;$i++)
'{{ \App\TicketStatus::find($i)->name}}',
 @endfor
 

   
             ],
      datasets: [
        {
          data: [
            
            @for($i=1;$i<=9;$i++)
            @if(Auth::user()->level_id==1)
          
          @endif
          @if(Auth::user()->level_id==2) 
          {{ \App\Ticket::where(['status_id' => $i])->get()->count() }}, 
           @endif
          @if(Auth::user()->level_id==3) 
          {{ \App\Ticket::where(['status_id' => $i])->where(['teamleader_id' => Auth::user()->id])->get()->count() }}, 
          @endif
          @if(Auth::user()->level_id==4) 
          {{ \App\Ticket::where(['status_id' => $i])->where(['created_by_id' => Auth::user()->id])->get()->count() }},
          @endif
          @if(Auth::user()->level_id==5) 
          {{ \App\Ticket::where(['status_id' => $i])->where(['created_by_id' => Auth::user()->id])->get()->count() }} ,
          @endif
         @endfor

          ],
          backgroundColor : [
            
            @for($i=1;$i<=9;$i++)
            '{{$colorarr[$i]}}',
            @endfor
          
          ],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = donutData2;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })

    var pieDataSLA = {
            labels: [
                "IN SLA",
                "OUT SLA",
            ],
            datasets: [{
                data: [
                  {{ \App\Ticket::inSLA()->count() }},
                  {{ \App\Ticket::outSLA()->count() }},
                ],
                backgroundColor: [
                    "#888888",
                    "#bbbbbb",
                ],
            }]
        }
        
        var pieChartCanvasSLA = $('#pieChartSLA').get(0).getContext('2d')
        var pieDataSLA = pieDataSLA;
        var pieOptionsSLA = {
            maintainAspectRatio: false,
            responsive: true,
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        new Chart(pieChartCanvasSLA, {
            type: 'pie',
            data: pieDataSLA,
            options: pieOptionsSLA
        })

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })

    //---------------------
    //- STACKED BAR CHART -
    //---------------------
    var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
    var stackedBarChartData = $.extend(true, {}, barChartData)

    var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }

    new Chart(stackedBarChartCanvas, {
      type: 'bar',
      data: stackedBarChartData,
      options: stackedBarChartOptions
    })
  })

  $('#modal-change').on('show.bs.modal',function(event){
  
  var button =$(event.relatedTarget)
  
  var modal=$(this)
  
  
  })
</script>
</body>
</html>
