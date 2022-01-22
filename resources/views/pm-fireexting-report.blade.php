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
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Preventive Maintenace</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Fireexting</h3>
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
                        <input type="date" id="fromDate" name="fromDate" class="form-control">
                    </div>

                    <div class="p-3 col-md-3">
                        <input type="date" id="toDate" name="toDate" class="form-control">
                    </div>
                </div>

                <div class="p-3 table-responsive">
                    <table id="example" class="table table-bordered table-striped" width="100%"></table>
                </div>
            </div>
        </div>
    </div>

    <script>
        var station = "", equipment = "", fromDate = "", toDate = "";
        var fires = @json($fires);
        const columns = [{
                title: "Station"
            },
            {
                title: "Number"
            },
            {
                title: "Type"
            },
            {
                title: "Indicator"
            },
            {
                title: "Safty pin"
            },
            {
                title: "Hose"
            },
            {
                title: "Date"
            },
            {
                title: "Note"
            }
        ]
        var dataSet = [];
        fires.forEach(e => {
            dataSet.push([
                e.station,
                e.serial,
                e.type,
                e.indicator,
                e.safty_pin,
                e.hose,
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
            var startDate = fromDate ? moment(new Date(fromDate), 'YYYY-MM-DD') : null; 
            var endDate = toDate ? moment(new Date(toDate), 'YYYY-MM-DD') : moment();
            let result = fires.filter((o) => {
                var inDay = true;
                
                if(startDate && endDate) {
                    var date = moment(new Date(o.date), 'YYYY-MM-DD');
                    inDay = date.isBetween(startDate, endDate);
                }
                
                return inDay &&
                    (o.station_id == station || !station) &&
                    (o.equipment == equipment || !equipment);
                });

            example.rows().remove().draw(false);
            result.forEach(e => {
                example.row.add([
                    e.station,
                    e.serial,
                    e.type,
                    e.indicator,
                    e.safty_pin,
                    e.hose,
                    // e.actions.join(', '),
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
            jQuery('input[name="fromDate"]').on('change', function() {
                fromDate = jQuery(this).val();
                filterReport();
            });
            var to = jQuery('input[name="toDate"]');
            to.val(moment().format('YYYY-MM-DD'));
            to.on('change', function() {
                toDate = jQuery(this).val();
                filterReport();
            });
        });
    </script>
@endsection
