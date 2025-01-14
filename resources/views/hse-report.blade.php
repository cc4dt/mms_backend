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
                            <li class="breadcrumb-item active">HSE</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">HSE</h3>
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
                        <select id="hse_id" name="hse_id"
                            class="select2bs4 form-control @error('hse_id') is-invalid @enderror" data-vldtr="required">
                            <option value="">-Select HSE-</option>
                            @if (isset($hse))
                                @foreach ($hse as $data)
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
        var station = "",
            hse = "",
            fromDate = "",
            toDate = "";

        var details = @json($details);
        var masterHses = @json($master_hses);
        var processes = @json($processes);

        const columns = [{
                title: "process_id"
            },
            {
                title: "master_hse_id"
            },
            {
                title: "Station"
            },
            {
                title: "Created By"
            },
            {
                title: "Date"
            },
            {
                title: "HSE"
            },
            {
                title: "Serial"
            },
            {
                title: "Note"
            },
            {
                title: "Procedure"
            },
            {
                title: "Option"
            },
            {
                title: "Sparepart"
            },
            {
                title: "Note"
            },
        ];

        var dataSet = [];
        details.forEach(e => {
            var d = masterHses.filter((o) => o.id == e.process?.master_hse_id)[0];
            var c = processes.filter((o) => o.id == e.process_id)[0];
            dataSet.push([
                e.process_id ?? "0",
                e.process?.master_hse_id ?? "0",
                d?.station?.name ?? "",
                d?.created_by?.name ?? "",
                d?.timestamp ?? "",
                c?.hse?.name ?? "",
                c?.equipment?.serial ?? "",
                c?.description ?? "",
                e.procedure?.name ?? "",
                e.option?.name ?? "",
                e.spare_part?.name ?? "",
                e.value ?? "",
                // new Date(e.timestamp).toLocaleString(),  
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
            ],

            order: [
                [1, 'asc'],
                [0, 'asc']
            ],
            columnDefs: [{
                targets: [0, 1, 2, 3, 4, 5, 6, 7],
                visible: false
            }],
            rowGroup: {
                endRender: null,
                startRender: function(rows, group, level) {
                    if (level == 0) {
                        var d = masterHses.filter((o) => o.id == group)[0];
                        return $('<tr/>')
                            .append('<td colspan="2">' + (d.station?.name ?? '') + '</td>')
                            .append('<td>' + (d.created_by?.name ?? '') + '</td>')
                            // .append( '<td/>' )
                            .append('<td>' + (d.timestamp ?? '') + '</td>');
                    } else if (level == 1) {
                        var d = processes.filter((o) => o.id == group)[0];
                        return $('<tr/>')
                            .append('<td colspan="2" style="background-color: darkslategrey; color: white">' + (
                                d.hse?.name ?? "") + '</td>')
                            .append('<td style="background-color: darkslategrey; color: white">' + (d.equipment
                                ?.serial ?? "") + '</td>')
                            // .append( '<td/>' )
                            .append('<td style="background-color: darkslategrey; color: white">' + (d
                                .description ?? "") + '</td>');
                    }
                },
                dataSrc: [1, 0]
            }
        });

        function filterReport() {
            example.rows().remove().draw(false);
            var startDate = fromDate ? moment(new Date(fromDate), 'YYYY-MM-DD') : null;
            var endDate = toDate ? moment(new Date(toDate), 'YYYY-MM-DD') : moment();
            let result = details.filter((o) => {
                var d = masterHses.filter((p) => p.id == o.process?.master_hse_id)[0];
                var inDay = true;

                if (startDate && endDate) {
                    var date = moment(new Date(d.timestamp), 'YYYY-MM-DD');
                    inDay = date.isBetween(startDate, endDate);
                }

                return inDay &&
                    (o.process?.hse_id == hse || !hse) &&
                    (d.station_id == station || !station);
            });

            // var spareParts = getSpareParts(result);

            // spareParts['keys'].forEach(e => {
            //     qtyDateTable.row.add([
            //         spareParts['data'][e]['spare'],
            //         spareParts['data'][e]['qty'] ?? 0,
            //     ]).draw(false);
            // });

            result.forEach(e => {
                var d = masterHses.filter((o) => o.id == e.process?.master_hse_id)[0];
                var c = processes.filter((o) => o.id == e.process_id)[0];
                example.row.add([
                    e.process_id ?? "0",
                    e.process?.master_hse_id ?? "0",
                    d?.station?.name ?? "",
                    d?.created_by?.name ?? "",
                    d?.timestamp ?? "",
                    c?.hse?.name ?? "",
                    c?.equipment?.serial ?? "",
                    c?.description ?? "",
                    e.procedure?.name ?? "",
                    e.option?.name ?? "",
                    e.spare_part?.name ?? "",
                    e.value ?? "",
                    // new Date(e.timestamp).toLocaleString(),
                ]).draw(false);
            });
        }

        // function getSpareParts(details) {
        //     var spareParts = [];
        //     var sparePartKeys = [];
        //     details.forEach(e => {
        //         // var state = e.process?.timeline?.status?.key == 'waiting_for_spare_parts' ? 'waiting': 'used';
        //         if(e.spare_sub_part) {
        //             var key = 'sub.' + e.spare_sub_part.id;
        //             if(spareParts[key]) {
        //                 spareParts[key]['qty'] += 1;
        //             } else {
        //                 sparePartKeys.push(key);
        //                 spareParts[key] = {
        //                     'spare' : e.spare_sub_part.name,
        //                     'qty' :  1,
        //                     // 'used' : state == 'used' ? 1 : 0,
        //                     // 'waiting' : state == 'waiting' ? 1 : 0,
        //                 };
        //             }
        //         } else {
        //             var key = 'super.' + e.procedure.id;
        //             if(spareParts[key]) {
        //                 spareParts[key]['qty'] += 1;
        //             } else {
        //                 sparePartKeys.push(key);
        //                 spareParts[key] = {
        //                     'spare' : e.procedure.spare_part?.name ?? e.procedure.name,
        //                     'qty' :  1,
        //                     // 'used' : state == 'used' ? 1 : 0,
        //                     // 'waiting' : state == 'waiting' ? 1 : 0,
        //                 };
        //             }
        //         }
        //     });
        //     return {'keys': sparePartKeys, 'data': spareParts};
        // }

        jQuery(document).ready(function() {
            jQuery('select[name="station_id"]').on('change', function() {
                station = jQuery(this).val();
                filterReport();
            });
        });

        jQuery(document).ready(function() {
            jQuery('select[name="hse_id"]').on('change', function() {
                hse = jQuery(this).val();
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
