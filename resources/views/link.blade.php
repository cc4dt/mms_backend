@extends('layouts.dashboard-ltr')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Links</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('Home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Links</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Links</h3>
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

                        <table>
                            <tr>
                                <td> <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-save">
                                        Add New
                                    </button>
                                </td>
                            </tr>
                        </table>

                    </div>
                </div>
                {{-- <div class="row">
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
                </div> --}}

                <div class="p-3 table-responsive">
                    <table id="example" class="table table-bordered table-striped" width="100%"></table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-save">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{route('link.store')}}">
                @csrf
                <input type="hidden" name="type_id" value="1">
                <div class="modal-content">
                    <div class="modal-header">


                        <h4 class="modal-title" style="border-color: #007bff">Create Link</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">


                        <!-- ====================######################################========================== -->

                        <div class="row form-group ">
                            <!-- ============================================== -->
                            <div class="col-md-3">

                                <label>{{ __('Title EN') }}</label>
                                <input id="name_en" type="text" name="name_en" value="{{ old('name_en') }}" class="form-control @error('name_en') is-invalid @enderror" required>

                                @error('name_en')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- ============================================== -->
                            <div class="col-md-3">

                                <label>{{ __('Title AR') }}</label>
                                <input id="name_ar" type="text" name="name_ar" value="{{ old('name_ar') }}" class="form-control @error('name_ar') is-invalid @enderror" required>

                                @error('name_ar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <br>

                        <div class="form-group row">

                            <!-- ============================================== -->
                            <div class="col-md-12">
                                <label>{{ __('URL') }}</label>
                                <input id="url" type="text" name="url" value="{{ old('url') }}" class="form-control @error('url') is-invalid @enderror" required>


                                @error('url')
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
    <script>

        var links = @json($links);

        const columns = [{
                title: "Title"
            }, 
            {
                "title": "URL",
                // "data": "url",
                "render": function(data, type, row, meta) {
                    data = '<a href="' + data + '" target="_blank">' + data + '</a>';
                    return data;
                }
            }
        ]
        var dataSet = [];
        links.forEach(e => {
            dataSet.push([
                e.name,
                e.url,
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

        // function filterReport() {
        //     example.rows().remove().draw(false);
        //     maintenanceDetails.forEach(e => {
        //         if ((e.process.ticket.station_id == station || !station) &&
        //             (e.procedure.spare_part_id == spare || !spare) &&
        //             (e.process.ticket.type_id == type || !type) &&
        //             (e.process.ticket.equipment_id == equipment || !equipment))
        //             example.row.add([
        //                 e.process.ticket.number,
        //                 e.process.ticket.station.name,
        //                 e.process.ticket.equipment.name,
        //                 e.process.equipment?.serial ?? "#",
        //                 e.procedure.spare_part?.name ?? e.procedure.name,
        //                 e.process.ticket.teamleader.name,
        //                 e.process.ticket.type.name,
        //                 new Date(e.created_at).toLocaleString(),
        //             ]).draw(false);
        //     });
        // }

        jQuery(document).ready(function() {
            jQuery('select[name="station_id"]').on('change', function() {
                station = jQuery(this).val();
                filterReport();
            });
        });

    </script>
@endsection
