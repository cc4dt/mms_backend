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
                <h3 class="card-title">HSE Costs</h3>
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
                <div class="p-3">
                    <table id="example" class="table table-bordered table-striped table-responsive text-center" width="100%">
                        <thead>
                            <tr>
                                <th rowspan="3">Station</th>
                                @foreach ($columns->hses as $hse)
                                    <th colspan="{{$hse->count}}">{{$hse->name}}</th>
                                @endforeach
                                <th rowspan="3">Total</th>
                            </tr>
                            <tr>
                                @foreach ($columns->procedures as $item)
                                    @if ($item->count > 1)
                                            <th colspan="{{$item->count}}">{{$item->name}}</th>
                                    @else
                                        <th rowspan="2">{{$item->name}}</th>
                                    @endif
                                @endforeach
                            </tr>
                            <tr>
                                @foreach ($columns->spares as $item)
                                    <th>{{$item->name}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $row)
                                <tr>
                                    <th>{{$row->name}}</th>
                                    @foreach ($row->items as $item)
                                        <td>{{$item ? $item : ''}}</td>
                                    @endforeach
                                    <th>{{$row->total}}</th>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>SUM</th>
                                @foreach ($sumRow as $item)
                                    <th>{{$item}}</th>
                                @endforeach
                                <th>{{array_sum($sumRow)}}</th>
                            </tr>
                            <tr>
                                <th>Price</th>
                                @foreach ($priceRow as $item)
                                    <th>{{$item}}</th>
                                @endforeach
                                <th>{{array_sum($priceRow)}}</th>
                            </tr>
                            <tr>
                                <th>Total</th>
                                @foreach ($totalRow as $item)
                                    <th>{{$item}}</th>
                                @endforeach
                                <th>{{array_sum($totalRow)}}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        var example = jQuery('#example').DataTable({
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
        });
    </script>
@endsection