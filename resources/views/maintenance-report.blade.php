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
                            <li class="breadcrumb-item active">Maintenance</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>

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

                    <div class="p-3 col-md-3">
                        <select id="spare_id" name="spare_id"
                            class="select2bs4 form-control @error('spare_id') is-invalid @enderror" data-vldtr="required">
                            <option value="">-Select Spare Part-</option>
                            @if (isset($spareparts))
                                @foreach ($spareparts as $data)
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
                    <table id="qty" class="table table-bordered table-striped" width="100%"></table>
                </div>
                <hr>
                <div class="p-3 table-responsive">
                    <table id="example" class="table table-bordered table-striped" width="100%"></table>
                </div>
            </div>
        </div>
    </div>

    <script>
        var station = "", equipment = "", type = "", spare = "", fromDate = "", toDate = "";

        var maintenanceDetails = @json($maintenance_details);

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
        ];

        var dataSet = [];
        maintenanceDetails.forEach(e => {
            dataSet.push([
                e.process.ticket.number,
                e.process.ticket.station.name,
                e.process.ticket.equipment.name,
                e.process.equipment?.serial ?? "#",
                e.spare_sub_part?.name ?? e.procedure.spare_part?.name ?? e.procedure.name,
                e.process.ticket.teamleader.name,
                e.process.ticket.type.name,
                new Date(e.process.ticket.openline.timestamp).toLocaleString(),
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

        const qtyColumns = [{
                title: "Sparepart"
            },
            {
                title: "Qty"
            },
            // {
            //     title: "Used"
            // },
            // {
            //     title: "Waiting"
            // }
        ];
        var spareParts = getSpareParts(maintenanceDetails);

        var qtyDataSet = [];
        spareParts['keys'].forEach(e => {
            qtyDataSet.push([
                spareParts['data'][e]['spare'],
                spareParts['data'][e]['qty'] ?? 0,
                // spareParts[e]['used'] ?? 0,
                // spareParts[e]['waiting'] ?? 0,
            ]);
        });
        
        var qtyDateTable = jQuery('#qty').DataTable({
            data: qtyDataSet,
            columns: qtyColumns,
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
            qtyDateTable.rows().remove().draw(false);

            var startDate = fromDate ? moment(new Date(fromDate), 'YYYY-MM-DD') : null; 
            var endDate = toDate ? moment(new Date(toDate), 'YYYY-MM-DD') : moment();
            let result = maintenanceDetails.filter((o) => {
                var inDay = true;
                
                if(startDate && endDate) {
                    var date = moment(new Date(o.process.ticket.openline.timestamp), 'YYYY-MM-DD');
                    inDay = date.isBetween(startDate, endDate);
                }
                
                return inDay &&
                    (o.process.ticket.station_id == station || !station) &&
                    (o.procedure.spare_part_id == spare || !spare) &&
                    (o.process.ticket.type_id == type || !type) &&
                    (o.process.ticket.equipment_id == equipment || !equipment);
                });

            var spareParts = getSpareParts(result);

            spareParts['keys'].forEach(e => {
                qtyDateTable.row.add([
                    spareParts['data'][e]['spare'],
                    spareParts['data'][e]['qty'] ?? 0,
                ]).draw(false);
            });

            result.forEach(e => {
                example.row.add([
                    e.process.ticket.number,
                    e.process.ticket.station.name,
                    e.process.ticket.equipment.name,
                    e.process.equipment?.serial ?? "#",
                    e.spare_sub_part?.name ?? e.procedure.spare_part?.name ?? e.procedure.name,
                    e.process.ticket.teamleader.name,
                    e.process.ticket.type.name,
                    new Date(e.process.ticket.openline.timestamp).toLocaleString(),
                ]).draw(false);
            });
        }

        function getSpareParts(details) {
            var spareParts = [];
            var sparePartKeys = [];
            details.forEach(e => {
                // var state = e.process?.timeline?.status?.key == 'waiting_for_spare_parts' ? 'waiting': 'used';
                if(e.spare_sub_part) {
                    var key = 'sub.' + e.spare_sub_part.id;
                    if(spareParts[key]) {
                        spareParts[key]['qty'] += 1;
                    } else {
                        sparePartKeys.push(key);
                        spareParts[key] = {
                            'spare' : e.spare_sub_part.name,
                            'qty' :  1,
                            // 'used' : state == 'used' ? 1 : 0,
                            // 'waiting' : state == 'waiting' ? 1 : 0,
                        };
                    }
                } else {
                    var key = 'super.' + e.procedure.id;
                    if(spareParts[key]) {
                        spareParts[key]['qty'] += 1;
                    } else {
                        sparePartKeys.push(key);
                        spareParts[key] = {
                            'spare' : e.procedure.spare_part?.name ?? e.procedure.name,
                            'qty' :  1,
                            // 'used' : state == 'used' ? 1 : 0,
                            // 'waiting' : state == 'waiting' ? 1 : 0,
                        };
                    }
                }
            });
            return {'keys': sparePartKeys, 'data': spareParts};
        }

        jQuery(document).ready(function() {
            jQuery('select[name="station_id"]').on('change', function() {
                station = jQuery(this).val();
                filterReport();
            });
        });

        jQuery(document).ready(function() {
            jQuery('select[name="equipment_id"]').on('change', function() {
                equipment = jQuery(this).val();
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
            jQuery('select[name="spare_id"]').on('change', function() {
                spare = jQuery(this).val();
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
