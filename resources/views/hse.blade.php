@extends('layouts.dashboard-ltr')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">HSE</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('Home') }}">Home</a></li>
                            <li class="breadcrumb-item active">HSE</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">New HSE</h3>
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
                <form action="" method="post">
                    <div class="row">
                        <div class="p-3 col-md-6">
                            <select id="hse_id" name="hse_id"
                                class="select2bs4 form-control @error('hse_id') is-invalid @enderror" data-vldtr="required">
                                @if (isset($hses))
                                    @foreach ($hses as $data)
                                        <option value="{{ $data->id ?? '' }}">{{ $data->name ?? '' }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="p-3 col-md-6">
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
                        <div class="p-3 col-md-6">
                            {{-- <select id="station_id" name="station_id"
                                class="select2bs4 form-control @error('station_id') is-invalid @enderror" data-vldtr="required">
                                <option value="">-Select Serial-</option>
                                @if (isset($stations))
                                    @foreach ($stations as $data)
                                        <option value="{{ $data->id ?? '' }}">{{ $data->name ?? '' }}</option>
                                    @endforeach
                                @endif
                            </select> --}}
                            <label for="serial">Serial </label>
                            <input class= "form-control" type="text" name="serial" id="serial">
                        </div>
                        <div class="p-3 col-md-6">
                            <label for="date">Date </label>
                            <input class= "form-control" type="date" name="date" id="date">
                        </div>
                    </div>
                    <div class="p-3">
                        <label for="basic-url">Your vanity URL</label>
                        <div class="row p-3">
                            <div class="col-md-3">
                                <label for="date">Date </label>
                                <div class="input-group mb-3 form-check-inline">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input type="radio" id="a" name="option">
                                    </div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Some text">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="date">Date </label>
                                <div class="input-group mb-3 form-check-inline">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input type="radio" id="b" name="option">
                                    </div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Some text">
                                </div>
                            </div>
                        </div>
                        <label for="basic-url">Your vanity URL</label>
                        <div class="row p-3"><div class="form-check-inline">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="optradio">Option 1
                            </label>
                          </div>
                          <div class="form-check-inline">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="optradio">Option 2
                            </label>
                          </div>
                          <div class="form-check-inline disabled">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="optradio" disabled>Option 3
                            </label>
                          </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let form = {
            station: "",
            hse: @json($hses),
            data: null,
            serial: null,
            proseders: []
        }
        console.log(@json($hses));
        // var maintenanceDetails = @ json($maintenance_details);

        jQuery(document).ready(function() {
            jQuery('select[name="station_id"]').on('change', function() {
                form.station = jQuery(this).val();
                console.log(form);
            });
        });

        jQuery(document).ready(function() {
            jQuery('select[name="hse_id"]').on('change', function() {
                form.hse = jQuery(this).val();
            });
        });

    </script>
@endsection
