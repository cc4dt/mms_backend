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
                            <li class="breadcrumb-item active">Preventive Maintenace</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Preventive Maintenace</h3>
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
                        <select id="equipment" name="equipment"
                            class="select2bs4 form-control @error('equipment') is-invalid @enderror"
                            data-vldtr="required">
                            <option value="">-Select Equipment-</option>
                            @if (isset($equipment))
                                @foreach ($equipment as $data)
                                    <option value="{{ $data ?? '' }}">{{ $data ?? '' }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="p-3 col-md-3">
                        <select id="duration" name="duration"
                            class="select2bs4 form-control" data-vldtr="required">
                            <option value="">-Select Duration-</option>
                            <option value="1">1 month</option>
                            <option value="3">3 months</option>
                            <option value="6">6 months</option>
                            <option value="12">12 months</option>
                        </select>
                    </div>

                    <div class="p-3 col-md-3">
                        <input type="date" id="from" name="from" class="form-control">
                    </div>
                </div>

                <div class="p-3 table-responsive">
                    <table id="example" class="table table-bordered table-striped" width="100%"></table>
                </div>
            </div>
        </div>
    </div>

    <script>
        var station = "", equipment = "", from = "", duration = "";
        var pms = @json($pms);
        const columns = [{
                title: "Station"
            },
            {
                title: "Equipment"
            },
            {
                title: "Serial / No"
            },
            {
                title: "Date"
            },
            {
                title: "Note"
            }
        ]
        var dataSet = [];
        pms.forEach(e => {
            dataSet.push([
                e.station,
                e.equipment,
                e.serial,
                // e.actions.join(', '),
                new Date(e.date).toLocaleString(),
                e.note,
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
            var start = from ? moment(new Date(from)) : moment().subtract(duration, 'months'); 
            var end = from ? moment(new Date(from)).add(duration, 'months') : moment(); 
            let result = pms.filter((o) => {
                return (moment(new Date(o.date), 'YYYY-MM-DD').isBetween(start, end, undefined, '[]') || !duration) &&
                    (o.station_id == station || !station) &&
                    (o.equipment == equipment || !equipment);
                });

            example.rows().remove().draw(false);
            result.forEach(e => {
                example.row.add([
                    e.station,
                    e.equipment,
                    e.serial,
                    new Date(e.date).toLocaleString(),
                    e.note,
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
            jQuery('select[name="equipment"]').on('change', function() {
                equipment = jQuery(this).val();
                filterReport();
            });
        });

        jQuery(document).ready(function() {
            jQuery('select[name="duration"]').on('change', function() {
                duration = jQuery(this).val();
                filterReport();
            });
        });

        jQuery(document).ready(function() {
            jQuery('input[name="from"]').on('change', function() {
                from = jQuery(this).val();
                filterReport();
            });
        });
    </script>
@endsection
