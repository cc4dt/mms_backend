@extends('layouts.dashboard-ltr')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Reports</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('Home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Maintenance</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
        </secton>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Spare Parts</h3>
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
                <div class="row">
                    <div class="col-md-3">

                        <select id="station_id" name="station_id"
                            class="select2bs4 form-control @error('station_id') is-invalid @enderror"
                            data-vldtr="required">
                            <option value="">-Select Station-</option>
                            @if(isset($stations))
                            @foreach($stations as $data)
                            <option value="{{$data->id ?? ''}}">{{$data->name ?? ''}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>


                <div class="p-3 table-responsive">
                    <table id="example" class="table table-bordered table-striped" width="100%"></table>
                    </dev>
                    </dev>
                    </dev>
                    </dev>

                    <script>
                    var maintenanceDetails = @json($maintenance_details);
                    console.log(maintenanceDetails);
                    const columns = [{
                            title: "Ticket No"
                        },
                        {
                            title: "Station"
                        },
                        {
                            title: "Equipment"
                        },
                        {
                            title: "Serial No"
                        },
                        {
                            title: "Spare Part"
                        },
                        {
                            title: "Teamleader"
                        },
                        {
                            title: "Type"
                        },
                        {
                            title: "Date"
                        },
                    ]
                    var dataSet = [];
                    maintenanceDetails.forEach(e => {
                        dataSet.push([
                            e.process.ticket.number,
                            e.process.ticket.station.name,
                            e.process.ticket.equipment.name,
                            e.value,
                            e.procedure.spare_part.name,
                            e.process.ticket.teamleader.name,
                            e.process.ticket.type.name,
                            new Date(e.process.ticket.updated_at).toLocaleString(), 
                        ]);
                    });

                    var example = jQuery('#example').DataTable({
                        data: dataSet,
                        columns: columns
                    });

                    jQuery(document).ready(function() {
                        jQuery('select[name="station_id"]').on('change', function() {
                            var station = jQuery(this).val();
                            console.log(station);
                            example.rows().remove().draw(false);
                            maintenanceDetails.forEach(e => {
                                if (e.process.ticket.station_id == station || !station)
                                    example.row.add([
                                        e.process.ticket.number,
                                        e.process.ticket.station.name,
                                        e.process.ticket.equipment.name,
                                        e.value,
                                        e.procedure.spare_part.name,
                                        e.process.ticket.teamleader.name,
                                        e.process.ticket.type.name,
                                        new Date(e.process.ticket.updated_at).toLocaleString(), 
                                    ]).draw(false);
                            });
                        });
                    });
                    </script>
                    @endsection