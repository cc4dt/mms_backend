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
                            <li class="breadcrumb-item"><a href="{{ route('Home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Breakdowns</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>

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
                <div class="row">
                    <div class="p-3 col-md-3">
                        <select id="station_id" name="station_id"
                            class="select2bs4 form-control @error('station_id') is-invalid @enderror" data-vldtr="required">
                            <option value="">-Select Station-</option>
                            @if (isset($stations))
                                @foreach ($stations as $data)
                                    <option value="{{ $data->id ?? '' }}">{{ $data->name ?? '' }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="p-3 col-md-3">
                        <select id="equipment_id" name="equipment_id"
                            class="select2bs4 form-control @error('equipment_id') is-invalid @enderror"
                            data-vldtr="required">
                            <option value="">-Select Equipment-</option>
                            @if (isset($equipment))
                                @foreach ($equipment as $data)
                                    <option value="{{ $data->id ?? '' }}">{{ $data->name ?? '' }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="p-3 col-md-3">
                        <select id="breakdown_id" name="breakdown_id"
                            class="select2bs4 form-control @error('breakdown_id') is-invalid @enderror"
                            data-vldtr="required">
                            <option value="">-Select Breakdown-</option>
                            @if (isset($breakdowns))
                                @foreach ($breakdowns as $data)
                                    <option value="{{ $data->id ?? '' }}">{{ $data->name ?? '' }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="p-3 col-md-3">
                        <select id="status_id" name="status_id"
                            class="select2bs4 form-control @error('status_id') is-invalid @enderror" data-vldtr="required">
                            <option value="">-Select Status-</option>
                            @if (isset($status))
                                @foreach ($status as $data)
                                    <option value="{{ $data->id ?? '' }}">{{ $data->name ?? '' }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="p-3 col-md-3">
                        <select id="type_id" name="type_id"
                            class="select2bs4 form-control @error('type_id') is-invalid @enderror" data-vldtr="required">
                            <option value="">-Select Type-</option>
                            @if (isset($types))
                                @foreach ($types as $data)
                                    <option value="{{ $data->id ?? '' }}">{{ $data->name ?? '' }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="p-3 table-responsive">
                    <table id="example" class="table table-bordered table-striped" width="100%">
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        var station = "", status = "", equipment = "", breakdown = "", type = "";

        var tickets = @json($tickets);
        
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
                title: "Breakdown"
            },
            {
                title: "Type"
            },
            {
                title: "SLA"
            },
            {
                title: "SLA Sataus"
            },
            {
                title: "Action Done"
            },
            {
                title: "Received"
            },
            {
                title: "Resolution"
            },
            {
                title: "Led Time"
            },
            {
                title: "Status"
            },
        ];
        var dataSet = [];
        tickets.forEach(e => {
            dataSet.push([
                e.number,
                e.station?.name ?? "",
                e.equipment?.name ?? "",
                e.breakdown?.name ?? "",
                e.type?.name ?? "",
                e.sla,
                e.in_sla ? 'IN' : 'OUT',
                e.actions.join(', '),
                new Date(e.created_at).toLocaleString(),
                new Date(e.updated_at).toLocaleString(),
                e.led_time,
                e.status.name
            ]);
        });

        var example = jQuery('#example').DataTable({
            data: dataSet,
            columns: columns,
            dom: 'Bfrtip',
            lengthMenu: [
                [10, 25, 50, 100, 250],
                ['10', '25', '50', '100', '250']
            ],
            buttons: [
                'copy',
                {
                    extend: 'print',
                    charset: 'UTF-8',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions: {
                        columns: ':visible'
                    },
                },
                {
                    extend: 'excel',
                    charset: 'UTF-8',
                    exportOptions: {
                        columns: ':visible'
                    },
                },
                {
                    extend: 'csv',
                    charset: 'UTF-8',
                    exportOptions: {
                        columns: ':visible'
                    },
                },
                'colvis',
                'pageLength'
            ]
        });

        function filterReport() {
            example.rows().remove().draw(false);
            tickets.forEach(e => {
                if ((e.station_id == station || !station) &&
                    (e.status_id == status || !status) &&
                    (e.type_id == type || !type) &&
                    (e.breakdown_id == breakdown || !breakdown) &&
                    (e.equipment_id == equipment || !equipment))
                    example.row.add([
                        e.number,
                        e.station?.name ?? "",
                        e.equipment?.name ?? "",
                        e.breakdown?.name ?? "",
                        e.type?.name ?? "",
                        e.sla,
                        e.in_sla ? 'IN' : 'OUT',
                        e.actions.join(', '),
                        new Date(e.created_at).toLocaleString(),
                        new Date(e.updated_at).toLocaleString(),
                        e.led_time,
                        e.status.name
                    ]).draw(false);
            });
        }

        jQuery(document).ready(function() {
            jQuery('select[name="station_id"]').on('change', function() {
                station = jQuery(this).val();
                filterReport();
            });
        });

        jQuery(document).ready(function() {
            jQuery('select[name="breakdown_id"]').on('change', function() {
                breakdown = jQuery(this).val();
                filterReport();
            });
        });

        jQuery(document).ready(function() {
            jQuery('select[name="status_id"]').on('change', function() {
                status = jQuery(this).val();
                filterReport();
            });
        });

        jQuery(document).ready(function() {
            jQuery('select[name="type_id"]').on('change', function() {
                type = jQuery(this).val();
                filterReport();
            });
        });

        jQuery(document).ready(function() {
            jQuery('select[name="equipment_id"]').on('change', function() {
                equipment = jQuery(this).val();
                filterReport();
            });
        });
    </script>
@endsection
