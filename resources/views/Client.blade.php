@extends('layouts.dashboard-ltr')
@section('content')
<?php $surl=asset('');

?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Clients</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#" >Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </secton>

 <div class="card">
        <div class="card-header">
            <h3 class="card-title">Breakdown Tickets</h3>

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

<div class"row">
<div class="col-md-3">

<table>
<tr>
<td> <button type="button" class="btn   btn-primary  " data-toggle="modal" data-target="#modal-save">
              Add New
            </button></td>

</tr>
</table> 

            </div>
           
       </div>
<font size="2">
  <table id="example2" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Ticket No</th>
                        <th>Status </th>
                        <th>State</th>
                        <th>Station</th>
                        <th>Equipment</th>
                        <th>Breakdown</th>
                        <th>Recieved Time</th>
                        <th>Description</th>
                        <th>Operations</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($showdata))
                    @foreach($showdata as $show)
                    <tr>
                        <th>{{ $show->number ?? '' }}</th>
                        <th>

                   
                           
                          
                           @if($show->status_id==1)
                           {{ 'opened' }}
                             @endif
                              @if($show->status_id==2)
                           {{ 'closed' }}
                             @endif
                              @if($show->status_id==3)
                           {{ 'cancelled' }}
                             @endif
                              @if($show->status_id==4)
                           {{ 'waiting_for_spare_parts' }}
                             @endif
                              @if($show->status_id==5)
                           {{ 'waiting_for_approval' }}
                             @endif
                              @if($show->status_id==6)
                           {{ 'waiting_for_access' }}
                             @endif
                               @if($show->status_id==7)
                           {{ 'transfer_to_job' }}
                             @endif

                            @if($show->status_id==8)
                           {{ 'pending' }}
                             @endif
                           @if($show->status_id==9)
                           {{ 'needs_approval_from_Client' }}
                             @endif


  
                            </th>
                        <th>Khartoum </th>
                        <th>{{ $show->station_en ?? '' }}</th>
                        <th>{{ $show->equipment_en ?? '' }}</th> 
                        <th>{{ $show->breakdown_en ?? '' }}</th>      
                        <th>{{ $show->created_at ?? '' }}</th>
                        <th>{{ $show->open_description ?? '' }}</th>
                        

                        
                      
          <th > 
        

     @if($show->status_id==1)    
 <a href="{{asset(route('Client.edit',$show->id))}}"> <li class="fa fa-edit" ></li>
                           </a>
                           @endif
      
       {{" - "}}

                            <a href="{{asset(route('Client.show',$show->id))}}"> <li class="fa fa-eye" data-backdrop="static"
   data-keyboard="false" data-toggle="modal" data-target="#"  style="color: rgb(0,0,0);"></li>
                           </a>



  
 @if($show->status_id==1)

 {{" - "}}
                              <a href="#"> <li class="fa fa-trash" style="color: rgb(255,0,0);" 
                             data-id="{{ $show->id ?? '' }}"
                             data-name="{{ $show->number ?? '' }}"
                             data-toggle="modal" 
                             data-target="#modal-delete2">
                                </li>
                            </a>
                            @endif
 


   @if($show->status_id==9)   

   {{" - "}} 
    <a href="#"> <button  class="btn-success" 
                             data-id="{{ $show->id ?? '' }}"
                             data-name="{{ $show->number ?? '' }}"
                              data-toggle="modal" 
                             data-target="#modal-action">
                             Approval
                               </button>
                            </a>
@endif


       
 </th>
                        
                    </tr>
                    @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                         <th></th>
                        <th></th>
                        <th></th>
                        
                    </tr>
                </tfoot>
            </table>

</font>
 


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












<div class="modal fade" id="modal-save">
        <div class="modal-dialog modal-lg">
              <form method="POST" action="{{route('Client.store')}}">
                @csrf
                <input type="hidden" name="created_by_id" value="{{ Auth::user()->id ?? '' }}">
                <input type="hidden" name="created_at" value="<?php echo date('Y-m-d h:i:s') ?>">
                <input type="hidden" name="status_id" value="1">
          <div class="modal-content">
            <div class="modal-header">


              <h4 class="modal-title" style="border-color: #007bff">Create Tickets</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">


<!-- ====================######################################========================== -->






            <div class="row">

  
<!-- ============================================== -->                         
                            <div class="col-md-3">
                                
                                 <label >{{ __('State') }}</label>
<select id="state_id" name="state_id" class="select2bs4 form-control @error('state_id') is-invalid @enderror" style="width: 100%; height: 30;" data-vldtr="required" >
    <option value="">-Select-</option>
     @if(isset($statedata))
 @foreach($statedata as $data)
<option value="{{$data->id ?? ''}}">{{$data->name_en ?? ''}}</option>
 @endforeach
 @endif
</select>
                           

                                @error('state_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

<!-- ============================================== -->

                              <div class="col-md-3">
                                 <label >{{ __('Stations') }}</label>

                              <select id="station_id" name="station_id" value="{{ old('station_id') }}" class="select2bs4 form-control @error('station_id') is-invalid @enderror" data-vldtr="required">
    <option value="">-Select Once-</option>
    
</select>

                                @error('station_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                               </div>


<!-- ============================================== -->
                                <div class="col-md-3">
                                 <label >{{ __('Equipments') }}</label>

                                <select id="equipment_id" name="equipment_id" class="select2bs4 form-control @error('equipment_id') is-invalid @enderror" data-vldtr="required">
<option value="">-Select Once-</option>
  @if(isset($equipmentdata))
 @foreach($equipmentdata as $data)
<option value="{{$data->id ?? ''}}">{{$data->name_en ?? ''}}</option>
 @endforeach
 @endif
</select>

                                @error('equipment_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                               </div>

                          <div class="col-md-3">
                                 <label >{{ __('Breakdowns') }}</label>

                                <select id="breakdown_id" name="breakdown_id" class="select2bs4 form-control @error('breakdown_id') is-invalid @enderror" data-vldtr="required">
    <option value="">-Select Once-</option>
 
</select>

                                @error('breakdown_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                               </div>
<!-- ============================================== -->
                        </div>
<br>

 <div class="form-group row">
  
<!-- ============================================== -->                         
                                <div class="col-md-12">
                                 <label >{{ __('Descriptions') }}</label>
<textarea rows="2" class="form-control @error('open_description') is-invalid @enderror" name="open_description" id="open_description"  rows="5"></textarea>
                              

                                @error('open_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                               </div>

</div>
<!-- ============================================== -->
<!-- ====================######################################========================== -->
            </div>
            <!-- =======================modal body======================= -->
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">
                                   Create
                                </button>
            </div> 
          </div>
          <!-- /.modal-content -->
          </form>
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->



 <div class="modal fade" id="modal-delete2">
        <div class="modal-dialog">
          <div class="modal-content bg-danger">
            <div class="modal-header">
              <h4 class="modal-title">Delete ticket

 <form method="POST" action="{{route('Client.destroy','delete')}}">
  {{method_field('delete')}}
  @csrf
                  <input id="id" type="hidden" name="id" value="">
                    <input id="type" type="hidden" name="type" value="">
                                               @csrf
              </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
           
            <div class="modal-body">
              

                       
       </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default btn-outline-light" data-dismiss="modal">No</button>
              <button type="submit" class="btn btn-success btn-outline-light">Yes</button>
               </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>





 <div class="modal fade" id="modal-action">
        <div class="modal-dialog">
          <div class="modal-content bg-default">
            <div class="modal-header">
              <h4 class="modal-title">Tacke Actions

 <form method="POST" action="{{route('Client.create','head')}}">
  {{method_field('head')}}
  @csrf
                  <input id="id" type="hidden" name="id" value="">
                 
                                               @csrf
              </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
           
            <div class="modal-body">

                <input type="hidden" name="create_by" value="{{ Auth::user()->name ?? '' }}">
              
<div class="row">
        
          <label>Ticket No</label>
          <input type="text" name="ticketno" class="form-control" value="" id="type"> 
      
</div>


<div class="row">
        
          <label>Actions</label>
          <select name="ticketaction" id="ticketaction" class="form-control">
            <option value="">-Select-</option>
            <option value="3">Approve</option>
            <option value="4">Reject</option>
            
          </select>
      
</div>

<div class="row">
   <label >{{ __('Action Notes') }}</label>
<textarea class="form-control @error('Notes') is-invalid @enderror" name="Notes" id="Notes"   rows="3">
</textarea>
</div>




       </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default btn-outline-light" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-success btn-outline-light">Ok</button>
               </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>




@if(isset($showupdate))

 @foreach($showupdate as $shupdate)

<!--------------------------modal edit----------------------------->


<div class="modal fade" id="modal-edit">
        <div class="modal-dialog modal-lg">
              <form method="POST" action="{{route('Client.update',$shupdate->id)}}">
                @csrf
                 {{method_field('patch')}}
                <input type="hidden" name="number" value="{{$shupdate->number}}">
                <input type="hidden" name="id" value="{{$shupdate->id}}">
                <input type="hidden" name="updated_by_id" value="{{ Auth::user()->id ?? '' }}">
                <input type="hidden" name="updated_at" value="<?php echo date('Y-m-d h:i:s') ?>">
                <input type="hidden" name="status_id" value="1">

                <div class="modal-content">
                <div class="modal-header">


              <h4 class="modal-title" style="border-color: #007bff">Edit Ticket</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
      


            <div class="row">

  
<!-- ============================================== -->                         
                            <div class="col-md-3">
                                
                                 <label >{{ __('State') }}</label>
<select id="state_id" name="state_id" class="select2bs4 form-control @error('state_id') is-invalid @enderror" style="width: 100%; height: 30;" data-vldtr="required" >
    <option value="">-Select-</option>
     @if(isset($statedata))
 @foreach($statedata as $data)
<option value="{{$data->id ?? ''}}" <?php if($data->id==$shupdate->state_id){ ?> selected="true" <?php } ?> >{{$data->name_en ?? ''}}</option>
 @endforeach
 @endif
</select>
                           

                                @error('state_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>


                              <div class="col-md-3">
                                 <label >{{ __('Stations') }}</label>

                              <select id="station_id" name="station_id" value="{{ old('station_id') }}" class="select2bs4 form-control @error('station_id') is-invalid @enderror" data-vldtr="required">
                              <option value="">-Select-</option>
  @if(isset($stationdata))
 @foreach($stationdata as $data)
 <option value="{{$data->id ?? ''}}" <?php if($data->id==$shupdate->station_id){ ?> selected="true" <?php } ?> >
 {{$data->name_en ?? ''}}
 </option>
 @endforeach
 @endif
    
</select>

                                @error('station_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                               </div>


<!-- ============================================== -->
                                <div class="col-md-3">
                                 <label >{{ __('Equipments') }}</label>

                                <select id="equipment_id" name="equipment_id" class="select2bs4 form-control @error('equipment_id') is-invalid @enderror" data-vldtr="required">
<option value="">-Select Once-</option>
  @if(isset($equipmentdata))
 @foreach($equipmentdata as $data)
<option value="{{$data->id ?? ''}}"  <?php if($data->id==$shupdate->equipment_id){ ?> selected="true" <?php } ?> >{{$data->name_en ?? ''}}</option>
 @endforeach
 @endif
</select>

                                @error('equipment_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                               </div>

                          <div class="col-md-3">
                                 <label >{{ __('Breakdowns') }}</label>

                                <select id="breakdown_id" name="breakdown_id" class="select2bs4 form-control @error('breakdown_id') is-invalid @enderror" data-vldtr="required">
                              

                                <option value="">-Select-</option>
  @if(isset($breakdowndata))
 @foreach($breakdowndata as $data)
 <option value="{{$data->id ?? ''}}" <?php if($data->id==$shupdate->breakdown_id){ ?> selected="true" <?php } ?> >
 {{$data->name_en ?? ''}}
 </option>
 @endforeach
 @endif
 
</select>

                                @error('breakdown_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                               </div>
<!-- ============================================== -->
                        </div>
<br>

 <div class="form-group row">
  
<!-- ============================================== -->                         
                                <div class="col-md-12">
                                 <label >{{ __('Descriptions') }}</label>
<textarea rows="5" class="form-control @error('open_description') is-invalid @enderror" name="open_description" id="open_description"  rows="5">
{{$shupdate->open_description}}
</textarea>
                              

                                @error('open_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                               </div>

                          
            </div>
            <!-- =======================modal body======================= -->
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">
                                   Update
                                </button>
            </div> 
          </div>
          <!-- /.modal-content -->
          </form>
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->



<!-------------------------------end modal edit--------------------------------->
@endforeach
@endif

@if(isset($showreport))
<!------------------------------------modal view-------------------------------->
<div class="modal fade" id="modal-view">
        <div class="modal-dialog modal-lg">
             
               
                <input type="hidden" name="create_by" value="{{ Auth::user()->UserName ?? '' }}">
                <input type="hidden" name="status" value="1">
          <div class="modal-content">
            <div class="modal-header">


              <h4 class="modal-title" style="border-color: #007bff">View Service Ticket</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="modal-body">
                @foreach($showreport as $data)
            <table width="100%" border="0" align="center">     
            <tr>
            <td align="left" width="70" valign="middle"><img src="{{ url('storage/logo/'.$data->Att) }}" alt="" title="" width="60" height="60" /></th>
            <td width="60"></th>
            <td align="center"> <font face="arial"  size="+2" color="#040168"> Service Ticket </font></th>
            <td align="right" width="165" valign="middle"><img src="{{ url('storage/logo/HAM.jpg') }}" alt="" title="" width="130" height="30" /></th>
            </tr>
             </table>
           
          
               <table border="1" align="center" width="100%" style="border-collapse: collapse;">
                <tr>
                    
                    <td width="50%"> <table width="100%" border="0" align="center" style="border-collapse: collapse;">
            <tr>
            <td width="50%">
         
            <font face="arial" size="3" style="float: left;">Client:</font>
            
            <font face="arial" size="3" style="float: right;">{{ $data->name ?? '' }}</font>
            
            </th>
           
            </tr>
             <tr>
            <td width="50%"> <font face="arial" size="3" style="float: left;">Field:</font>
            
            <font face="arial" size="3" style="float: right;"> Block {{ $data->blockName ?? '' }}</font></th>
           
            </tr>
             <tr>
            <td width="50%"><font face="arial" size="3" style="float: left;">Well:</font>
            
            <font face="arial" size="3" style="float: right;">{{ $data->wellName ?? '' }}</font></th>
            
            </tr>
             <tr>
            <td width="50%"><font face="arial" size="3" style="float: left;">Rig:</font>
            
            <font face="arial" size="3" style="float: right;">{{ $data->rig ?? '' }}</font></th>
           
            </tr>
             <tr>
            <td width="50%"><font face="arial" size="3" style="float: left;">Run:</font>
            
            <font face="arial" size="3" style="float: right;">{{ $data->run ?? '' }}@if($data->run2!='N/A')#{{ $data->run2 ?? '' }} @endif @if($data->run3){{ $data->run3 ?? '' }} @endif</font></th>
            
            </tr>
</table></th>

                    <td width="50%"> <table width="98%" border="0" align="center" style="border-collapse: collapse;">
            <tr>
            <td width="50%">
         
            <font face="arial" size="3" style="float: left;">Ticket Number:</font>
            
            <font face="arial" size="3" style="float: right;">{{ $data->ticketno ?? '' }}</font>
            
            </th>
           
            </tr>
             <tr>
            <td width="50%"> <font face="arial" size="3" style="float: left;">Arrive Locations:</font>
            
            <font face="arial" size="3" style="float: right;"><?php echo date_format(date_create($data->arraive_location),'d-M-y'); ?></font></th>
           
            </tr>
             <tr>
            <td width="50%"><font face="arial" size="3" style="float: left;">Job Start:</font>
            
            <font face="arial" size="3" style="float: right;"><?php echo date_format(date_create($data->startdate),'d-M-y'); ?></font></th>
            
            </tr>
             <tr>
            <td width="50%"><font face="arial" size="3" style="float: left;">Job End:</font>
            
            <font face="arial" size="3" style="float: right;"><?php echo date_format(date_create($data->enddate),'d-M-y'); ?></font></th>
           
            </tr>
             <tr>
            <td width="50%"><font face="arial" size="3" style="float: left;"></font>
            
            <font face="arial" size="3" style="float: right;">&nbsp;</font></th>
            
            </tr>
</table></th>
                </tr>
                   

               </table>
            <table width="100%" align="center" border="1" style="border-collapse: collapse;">
            <tr>
            <td><font face="arial" size="3" style="float: left;">Contract Number:</font>&nbsp;
            
            <font face="arial" size="3" style="float: left;">{{ $data->contractno ?? '' }}</font></td>
            </tr>

             <tr>
            <td><font face="arial" size="3" style="float: left;">Contract Name:</font>&nbsp;
            
            <font face="arial" size="3" style="float: left;"> <?php echo $data->contract_name; ?></font></td>
            </tr>

                    </table>
                       
          
            <table width="100%" align="center" border="1" style="border-collapse: collapse;">
            <tr>
            <td><font face="arial" size="3" style="float: left;">Service Instructions:&nbsp;
            
           <?php  echo $data->service_desc; ?></font></td>
            </tr>
            </table>
       
@foreach($showreport2 as $data2)
@endforeach

 <table width="100%" align="center" border="1" style="border-collapse: collapse;">
           <thead>
            <tr  style="background-color:rgba(22,54,92);">
            <th width="17%" height="30" align="center"> <font face="arial" size="2" color="#ffffff" ><center>Item No.</center></font></th>
            
            <th  width="38%" align="center"> <font face="arial" face="arial" size="2" color="#ffffff" ><center> Description</center></font></th>
            <th align="center" > <font face="arial" size="2" color="#ffffff" ><center>Qty</center></font></th>
            <th align="center"> <font face="arial" size="2" color="#ffffff" ><center>(UOM)</center></font></th>
            <th align="center" width="12%" align="center"> <font face="arial" size="2" color="#ffffff" ><center>Price $</center></font></th>
            <th align="center" width="9%" align="center"> <font face="arial" size="2" color="#ffffff" ><center>Discount</center></font></th>
            <th align="center" width="13%" align="center"> <font face="arial" size="2" color="#ffffff" ><center>Amount $ </center></font></th>
            </tr>
            </thead>
            <tbody>
<?php $sum1=0; $sum2=0;  ?>


 @foreach($showreport3 as $data3)
 <?php $sum3=0; ?>
  @foreach($showreport2 as $data2)
  @if($data3->id==$data2->service_category)
 
             <tr>
            <td><font face="arial" size="2" style="float: left;">&nbsp;{{$data2->UID}}</font></th>
            <td><font face="arial" size="2" style="float: left;">&nbsp;{{$data2->service}}</font></th>
            <td align="center"><font face="arial" size="2">{{$data2->qty}}</font></th>
            <td align="center"><font face="arial" size="2" >{{$data2->uom}}</font></th>
            <td ><font style="float:left">$</font> <font face="arial" size="2" ><center>
<?php  echo number_format($data2->price,2); $sum1=$sum1+$data2->price; ?>
            </font></center></th>
            <td align="center"><font face="arial" size="2">{{$data2->discount}} %</font></th>
            <td> <font style="float:left">$</font><center><font face="arial" size="2" >
<?php

echo number_format((($data2->qty * $data2->price )-(($data2->qty * $data2->price )*($data2->discount))),2);
  $sum2=$sum2+($data2->qty * $data2->price )-(($data2->qty * $data2->price )*($data2->discount)); 
$sum3=$sum3+($data2->qty * $data2->price )-(($data2->qty * $data2->price )*($data2->discount));
?>
           </font> </center></th>
            </tr>
            @endif
            @endforeach
<tr style="background-color:rgba(250,191,143);"><th colspan="6" > 
 <center><font face="arial" size="2"> {{$data3->service_category }} Sub-Total ({{$data2->Currency }})</font></center>
</th>

<th  > 
<font style="float:left" >$</font><center> <font face="arial" size="2"><?php echo number_format($sum3,2);?></font></center>
</th>
</tr>

 @endforeach
             
           
           
            <tr style="background-color:rgba(22,54,92);">
            <td colspan="6" align="center"><center> <font face="arial" size="2"  color="#ffffff" >Service Ticket Grand-Total ({{ $data2->Currency ?? '' }})</font>&nbsp;</center></th>
            <th ><font style="float:left" color="ffffff">$</font><center> <font face="arial" size="2" color="#ffffff" style=""><?php echo number_format($sum2,2); ?></font></center></th>
            </tr>
             </tbody>
            </table>


            </th>
            </tr>
            </table>
<p></p>
<table width="100%" align="center" border="0" style="border-collapse: collapse;" style="page-break-before:auto" >
  <tr><td>
  <p align="justify"> <font face="arial" size="2"> THE ESTIMATED CHARGES SHOWN ABOVE MAY BE EXCLUSIVE OF TAX AND THE FINAL INVOICE WILL INCLUDE ALL APPLICABLE TAXES.   </font></p>  
    <p align="justify"> <font face="arial" size="2">  
     THE SERVICES, EQUIPMENT, MATERIALS AND/OR PRODUCTS COVERED BY THIS SERVICE TICKET HAVE BEEN PERFORMED OR RECEIVED AS SET FORTH ABOVE.                       
  </font></p></td></tr>
</table>
<p>&nbsp;</p>
<table width="100%" align="center" border="0" style="border-collapse: collapse;">
  <tr align="center"><td width="33%"><font face="arial" size="3"> HAM Supervisor</font></th><td width="33%"></th><td align="center" width="33%"><font face="arial" size="3"> {{ $data->name ?? '' }} Representative </font></th></tr>
  <tr><td align="center" width="33%"><font face="arial" size="3"><b> {{ $data->Supervisor ?? ''  }}</b></font> </th><td align="center" width="33%"></th><td width="33%" align="center"><font face="arial" size="3"><b> {{ $data->Representative ?? ''  }}</b></font></th></tr>
  
</table>
@endforeach

 <!-- end div print 
 <table width="100%" align="center" border="0" style="margin-bottom: 0;">
  <tr><td align="center">
  <font face="arial" size="2"><strong> Orignal Copy </strong></font> 
</td></tr></table>
-->

            </div>
             
  
   
            <!-- =======================modal body======================= -->
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="PrintDiv2();PrintDiv3();PrintDiv4();">
                                  <li class="fa fa-print"></li>
                                </button>
            </div> 
          </div>
          <!-- /.modal-content -->
         </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
<!---------------------------------end modal view------------------------------->
@endif



<!---------------------------------modal det view------------------------------->

<div class="modal fade" id="modal-det">
        <div class="modal-dialog modal-xl">
            <form method="POST" action="{{route('Client.store')}}">
              @csrf
              <input type="hidden" name="create_by" value="{{ Auth::user()->UserName ?? '' }}">
              <input type="hidden" name="status" value="1">
          <div class="modal-content">
            <div class="modal-header">


              <h4 class="modal-title" style="border-color: #007bff">Add Service To Ticket</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
 
<!-- ====================######################################========================== -->





            <div class="row">
            
            
  <div class="col-md-3">
                                 <label >{{ __('Ticket Number') }}</label>
<div class="input-group">
                    
                                <input id="ticketno" readonly="true" data-vldtr="required" type="text" class="form-control @error('ticketno') is-invalid @enderror"
                                    name="ticketno" value="" autocomplete="" autofocus>
                                        <input id="ticketid" data-vldtr="required" type="hidden" name="ticketid">
                                        <input id="ClientsID" data-vldtr="required" type="hidden" name="ClientsID">
</div>
                                @error('ticketno')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                               </div>
  
<!-- ============================================== -->                         
                            <div class="col-md-3">
                              
                               <label >{{ __('Clients') }}</label>
<select id="Clients" name="Clients" class="select2bs4 form-control @error('Clients') is-invalid @enderror" style="width: 100%; height: 30;" data-vldtr="required" >
 
    
</select>
                           

                                @error('Clients')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

<!-- ============================================== -->

                              <div class="col-md-2">
                               <label >{{ __('Field') }}</label>

                              <select id="block" name="block" value="{{ old('block') }}" class="select2bs4 form-control @error('block') is-invalid @enderror" data-vldtr="required">

      

</select>

                                @error('block')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                               </div>


<!-- ============================================== -->
                                <div class="col-md-2">
                               <label >{{ __('location') }}</label>

                                <select id="location" name="location" class="select2bs4 form-control @error('location') is-invalid @enderror" data-vldtr="required">

</select>

                                @error('location')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                               </div>

                         
                           <div class="col-md-2">
                               <label >{{ __('well') }}</label>

                                <select id="well" name="well" class="select2bs4 form-control @error('well') is-invalid @enderror" data-vldtr="required">

   

</select>

                                @error('well')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                               </div>
<!-- ============================================== -->
                        </div>
<p>

</p>
<!-- ======================###########################################33======================== -->
 
  


  @if(isset($categorydata))
      @foreach($categorydata as $shc)
      <table border="1" width="100%" class="table table-bordered" >
        <tr>
<td width="2%">
<span id="showli<?php echo $shc->id; ?>" style="display: ;">
  <li class="fa fa-plus" onclick="show('span<?php echo $shc->id; ?>','hideli<?php echo $shc->id; ?>','showli<?php echo $shc->id; ?>')"></li>
</span>
<span id="hideli<?php echo $shc->id; ?>" style="display: none;">
  <li class="fa fa-minus" onclick="hide('span<?php echo $shc->id; ?>','hideli<?php echo $shc->id; ?>','showli<?php echo $shc->id; ?>')"></li>
</span>

</td>
          <td>
     <a href="#" onclick="show('span<?php echo $shc->id; ?>','hideli<?php echo $shc->id; ?>','showli<?php echo $shc->id; ?>')">{{ $shc->service_category }}</a>
      </td>
      </tr>
</table>
      <span id="span<?php echo $shc->id; ?>" style="display: none;">
   

 <table  class="table table-bordered table-striped">
<thead>
  <tr>
  
    <th>Description</th>
    <th>QTY</th>
    <th>UOM</th>
    <th>Price</th>
    <th>Discount %</th>
  </tr>
  </thead>
  <tbody>

<!-- ============================================== -->
    




                               
<!-- ============================================== -->
                    

                    @if(isset($showservice))
                    @foreach($showservice as $sho)
          @if($sho->service_category=$shc->id)
          <tr id="{{$sho->id}}">
   
    <th> 
      <input type="checkbox" name="Actcat<?php echo $shc->id; ?>" value="<?php echo $shc->id; ?>"/>
<select id="rows[{{$sho->id}}][CAT]" name="rows[{{$sho->id}}][CAT]" class="select2bs4 form-control @error('CAT') is-invalid @enderror" data-vldtr="required" style="display: none;">
  
    @if(isset($categorydata))
@foreach($categorydata as $data)
@if($data->id==$sho->service_category)
<option value="{{$data->id ?? ''}}" >{{$data->service_category ?? ''}}</option>
@endif
 @endforeach
 @endif
</select>

<input name="rows[{{$sho->id}}][items]" type="hidden" value="{{$sho->id}}"  size="4">
  <input name="rows[{{$sho->id}}][client]" type="hidden" value="{{$sho->clientid}}"  size="4">      


      <input id="Description{{$sho->id}}" data-vldtr="required" type="hidden" class="form-control @error('Description') is-invalid @enderror"
                                    name="rows[{{$sho->id}}][Description]" value="{{ $sho->service }}" readonly="true">
{{ $sho->service }}
                                  </th>
    <th><input id="Qty{{$sho->id}}"  type="text" class="form-control @error('Qty') is-invalid @enderror"
                                    name="rows[{{$sho->id}}][Qty]" size="7">
                    @error('Qty')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>                                </span>
                                @enderror</th>
    <th> <input id="UOM{{$sho->id}}" data-vldtr="required" type="text" class="form-control @error('UOM') is-invalid @enderror"
                                    name="rows[{{$sho->id}}][UOM]" value="{{ $sho->uom }}" readonly="true" size="7"></th>
    <th> <input id="Price{{$sho->id}}" data-vldtr="required" type="text" class="form-control @error('Price') is-invalid @enderror"
                                    name="rows[{{$sho->id}}][Price]" value="{{ $sho->price }}" readonly="true" size="7"></th>
    <th> <input  data-vldtr="required" type="number" class="form-control @error('Discount') is-invalid @enderror"
                                    name="rows[{{$sho->id}}][Discount]" value="0" autocomplete="Discount"  size="2" ></th>
    </tr>
          
          
          <!-- ====================######################################========================== -->
          @endif
          @endforeach
          
          @endif
          
            
  </tbody>
</table>
     
      </span>
      <br>
      @endforeach
      @endif



<!-- ============================================== -->                         
                               
 <div class="card-body">
             

</div>
 

<!-- ====================######################################========================== -->
            </div>
            <!-- =======================modal body======================= -->
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">
                                   save
                                </button>
            </div> 
          </div>
          <!-- /.modal-content -->
          </form>
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

<!---------------------------------end modal view------------------------------->




</div><!-- end card body -->
</div>
</div><!-- end wrapper -->


<!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  @include('layouts/footer_ltr')


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


 <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<script src="{{ asset('LTR/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{ asset('LTR/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
<!-- InputMask -->
<script src="{{ asset('LTR/plugins/moment/moment.min.js')}}"></script>
<script src="{{ asset('LTR/plugins/inputmask/min/jquery.inputmask.bundle.min.js')}}"></script>
<!-- date-range-picker -->
<script src="{{ asset('LTR/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap color picker -->
<script src="{{ asset('LTR/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('LTR/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Bootstrap Switch -->
<script src="{{ asset('LTR/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<script src="{{ asset('LTR/plugins/datepicker/bootstrap-datepicker.js')}}"></script>

<script src="{{ asset('LTR/plugins/summernote/summernote-bs4.min.js')}}"></script>


@if(isset($showreport))
<script type="text/javascript">
    $(window).on('load',function(){
        $('#modal-view').modal('show');
      //  $('#modal-det').modal('show');
    });
</script>
@endif

@if(isset($showupdate))

<script type="text/javascript">
      $(window).on('load',function(){
        $('#modal-edit').modal('show');
      //  $('#modal-det').modal('show');
    });
</script>
@endif




 <script type="text/javascript">



    jQuery(document).ready(function ()
    {
            jQuery('select[name="state_id"]').on('change',function(){
               var state = jQuery(this).val();
               if(state)
               {
                  jQuery.ajax({
                     url : '<?php echo $surl; ?>ajax_fetch_data/stations/' + state,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(data);
                        jQuery('select[name="station_id"]').empty();
                         $('select[name="station_id"]').append('<option value="">-Select Once-</option>');
                        jQuery.each(data, function(key,value){
                           $('select[name="station_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                     }
                  });
               }
              
            });
    });


    jQuery(document).ready(function ()
    {
            jQuery('select[name="equipment_id"]').on('change',function(){
               var equipment = jQuery(this).val();
               if(equipment)
               {
                  jQuery.ajax({
                     url : '<?php echo $surl; ?>ajax_fetch_data/breakdowns/' + equipment,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(data);
                        jQuery('select[name="breakdown_id"]').empty();
                         $('select[name="breakdown_id"]').append('<option value="">-Select Once-</option>');
                        jQuery.each(data, function(key,value){
                           $('select[name="breakdown_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                     }
                  });
               }
              
            });
    });

 
    </script>

<script>
$("#datepicker").change(function () {
    var startDate = document.getElementById("datepicker").value;
    var endDate = document.getElementById("datepicker1").value;
    var endDate2 = document.getElementById("datepicker2").value;
    if ((Date.parse(startDate) >= Date.parse(endDate))) {
      toastr.error("Job Start  should be after Arrive "); 
        document.getElementById("datepicker1").value = "";
        document.getElementById("datepicker2").value = "";
    }

     if ((Date.parse(endDate) >= Date.parse(endDate2))) {
      toastr.error("Job End  should be after Job Start"); 
        document.getElementById("datepicker2").value = "";
    }
});


$("#datepicker1").change(function () {
    var startDate = document.getElementById("datepicker").value;
    var endDate = document.getElementById("datepicker1").value;
    var endDate2 = document.getElementById("datepicker2").value;
    if ((Date.parse(startDate) >= Date.parse(endDate))) {
      toastr.error("Job Start  should be after Arrive "); 
        document.getElementById("datepicker1").value = "";
        document.getElementById("datepicker2").value = "";
    }

     if ((Date.parse(endDate) >= Date.parse(endDate2))) {
      toastr.error("Job Start  should be befor Job End "); 
        document.getElementById("datepicker1").value = "";
    }
});

$("#datepicker2").change(function () {
    var startDate = document.getElementById("datepicker1").value;
    var endDate = document.getElementById("datepicker2").value;

    if ((Date.parse(startDate) >= Date.parse(endDate))) {
      toastr.error("Job End  should be after Job Start"); 
        document.getElementById("datepicker2").value = "";
    }
});
</script>

<script>
$("#datepicker4").change(function () {
    var startDate = document.getElementById("datepicker4").value;
    var endDate = document.getElementById("datepicker5").value;
    var endDate2 = document.getElementById("datepicker6").value;
    if ((Date.parse(startDate) >= Date.parse(endDate))) {
      toastr.error("Job Start  should be after Arrive "); 
        document.getElementById("datepicker5").value = "";
        document.getElementById("datepicker6").value = "";
    }

     if ((Date.parse(endDate) >= Date.parse(endDate2))) {
      toastr.error("Job End  should be after Job Start"); 
        document.getElementById("datepicker6").value = "";
    }
});


$("#datepicker5").change(function () {
    var startDate = document.getElementById("datepicker4").value;
    var endDate = document.getElementById("datepicker5").value;
    var endDate2 = document.getElementById("datepicker6").value;
    if ((Date.parse(startDate) >= Date.parse(endDate))) {
      toastr.error("Job Start  should be after Arrive "); 
        document.getElementById("datepicker5").value = "";
         document.getElementById("datepicker6").value = "";

    }

     if ((Date.parse(endDate) >= Date.parse(endDate2))) {
      toastr.error("Job Start  should be befor Job End "); 
        document.getElementById("datepicker5").value = "";
    }
});

$("#datepicker6").change(function () {
    var startDate = document.getElementById("datepicker5").value;
    var endDate = document.getElementById("datepicker6").value;

    if ((Date.parse(startDate) >= Date.parse(endDate))) {
      toastr.error("Job End  should be after Job Start"); 
        document.getElementById("datepicker6").value = "";
    }
});
</script>

<script>
  $(function () {
    // Summernote
    $('.textarea').summernote()
  })
</script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })




 $('#datepicker').datepicker({
      autoclose: true
    });

   //Date picker
    $('#datepicker1').datepicker({
      autoclose: true
    });
    
       //Date picker
    $('#datepicker2').datepicker({
      autoclose: true
    });

       //Date picker
    $('#datepicker3').datepicker({
      autoclose: true
    });

       //Date picker
    $('#datepicker4').datepicker({
      autoclose: true
    });

   //Date picker
    $('#datepicker5').datepicker({
      autoclose: true
    });

   //Date picker
    $('#datepicker6').datepicker({
      autoclose: true
    });

//Date picker
    $('#datepicker7').datepicker({
      autoclose: true
    });
    
    //Date picker
    $('#datepicker8').datepicker({
      autoclose: true
    });
    
        //Date picker
    $('#datepicker9').datepicker({
      autoclose: true
    });
    
    //Date picker
    $('#datepicker10').datepicker({
      autoclose: true
    });
    
    //Date picker
    $('#datepicker11').datepicker({
      autoclose: true
    });
//Date picker
    $('#datepicker31').datepicker({
      autoclose: true
    });

//Date picker
    $('#datepicker12').datepicker({
      autoclose: true
    });
    
    //Date picker
    $('#datepicker13').datepicker({
      autoclose: true
    });
    
    //Date picker
    $('#datepicker14').datepicker({
      autoclose: true
    });
    //Date picker
    $('#datepicker15').datepicker({
      autoclose: true
    });
    //Date picker
    $('#datepicker16').datepicker({
      autoclose: true
    });
    //Date picker
    $('#datepicker17').datepicker({
      autoclose: true
    });
    //Date picker
    $('#datepicker18').datepicker({
      autoclose: true
    });
    //Date picker
    $('#datepicker19').datepicker({
      autoclose: true
    });
    //Date picker
    $('#datepicker20').datepicker({
      autoclose: true
    });
    //Date picker
    $('#datepicker21').datepicker({
      autoclose: true
    });
     $('#datepicker22').datepicker({
      autoclose: true
    });
     $('#datepicker23').datepicker({
      autoclose: true
    });
     $('#datepicker24').datepicker({
      autoclose: true
    });
     $('#datepicker25').datepicker({
      autoclose: true
    });
     $('#datepicker30').datepicker({
      autoclose: true
    });
     $('#datepicker26').datepicker({
      autoclose: true
    });
     $('#datepicker27').datepicker({
      autoclose: true
    });
     $('#datepicker28').datepicker({
      autoclose: true
    });
     $('#datepicker29').datepicker({
      autoclose: true
    });
    


</script>




<script>


    @if(count($errors) > 0)
        @foreach($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach

    @endif


      @if(Session::get('result'))
        
            toastr.success("{{ Session::get('result') }}");
       
    @endif


     @if(Session::get('result2'))
        
            toastr.error("{{ Session::get('result2') }}");
       
    @endif
    
     @if(Session::get('result3'))
        
            toastr.error("{{ Session::get('result3') }}");
       
    @endif
</script>

<script type="text/javascript">
function set_session(cid_val)
{
        $.ajax({
         type: "GET",
         url : '<?php echo $surl; ?>set_session/' + cid_val
      });
}
$('#modal-det').on('hidden.bs.modal', function () {
     location.reload();
});

$('#modal-det').on('show.bs.modal',function(event){
var button2 =$(event.relatedTarget);
var cid_val=button2.data('cid')
 set_session(cid_val); 
  
 
var button =$(event.relatedTarget)
var id_val=button.data('id')
var c_val=button.data('cname')
var cid_val=button.data('cid')
var b_val=button.data('bname')
var l_val=button.data('lname')
var w_val=button.data('wname')
var ticketno_val=button.data('no')


 
var modal=$(this)
modal.find('.modal-body #ticketid').val(id_val)
modal.find('.modal-body #ClientsID').val(cid_val)
modal.find('.modal-body #ticketno').val(ticketno_val)
modal.find('.modal-body #Clients').empty()
modal.find('.modal-body #Clients').append('<option value="'+ cid_val +'">'+ c_val +'</option>')
modal.find('.modal-body #block').empty()
modal.find('.modal-body #block').append('<option value="'+ b_val +'">'+ b_val +'</option>')
modal.find('.modal-body #location').empty()
modal.find('.modal-body #location').append('<option value="'+ l_val +'">'+ l_val +'</option>')
modal.find('.modal-body #well').empty()
modal.find('.modal-body #well').append('<option value="'+ w_val +'">'+ w_val +'</option>')
 

})

    
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
modal.find('.modal-body #IsAdmin').prop('checked', isadmin_val)
modal.find('.modal-body #IsActive').prop('checked',isactive_val)
modal.find('.modal-body #IsSave').prop('checked',issave_val)
modal.find('.modal-body #IsUpdate').prop('checked',isupdate_val)
modal.find('.modal-body #IsDelete').prop('checked',isdelete_val)
modal.find('.modal-body #IsReport').prop('checked',isreport_val)

})




$('#modal-delete2').on('show.bs.modal',function(event){
  
var button =$(event.relatedTarget)
var name_val=button.data('name')

var id_val=button.data('id')

var modal=$(this)



modal.find('.modal-title #id').val(id_val)

modal.find('.modal-body').text('Are you soure you want to delete Ticket  :[ '+name_val+ ']')

})



$('#modal-action').on('show.bs.modal',function(event){
  
var button =$(event.relatedTarget)
var name_val=button.data('name')

var id_val=button.data('id')

var modal=$(this)



modal.find('.modal-title #id').val(id_val)
modal.find('.modal-body #type').val(name_val)

//modal.find('.modal-body').text('Are you soure you want to delete Ticket  :[ '+name_val+ ']')

})
</script>



<script type="text/javascript">
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
       "paging": true,
      "lengthChange": false,
      "searching": true,
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

<script>

var i=1;
var x="";
function show(gid, gid2,gid3){
  var elmnt = document.getElementById(gid);
  var elmnt2 = document.getElementById(gid2);
   var elmnt3 = document.getElementById(gid3);
  
   elmnt.style.display = 'block';
   elmnt2.style.display = 'block';
   elmnt3.style.display = 'none';
  
   
}

function hide(gid, gid2,gid3){
  var elmnt = document.getElementById(gid);
  var elmnt2 = document.getElementById(gid2);
   var elmnt3 = document.getElementById(gid3);
  
   elmnt.style.display = 'none';
   elmnt2.style.display = 'none';
   elmnt3.style.display = 'block';
  
   
}





</script>

</body>
</html>

@endsection