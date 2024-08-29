@extends('layouts.main')


@section('content')
    <!-- Content Header (Page header) -->


    <section class="content-header">
        @if (Session::has('message'))
            <div class="callout callout-success" role="alert">{{ Session::get('message') }}</div>
        @endif
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $main_title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            @if(auth()->user()->user_role == 1)
                                <a href="{{ url('admin/dashboard') }}">
                                    @elseif(auth()->user()->user_role == 2)
                                        <a href="{{ url('assessmentcenter/dashboard') }}">
                                            @else
                                                <a href="{{ url('dataentry/index') }}">
                                                    @endif
                                                    Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $breadcrumb_title }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- /.card -->

                    <div class="card">
                        <div class="card-header row">
                            <div class="col-lg-12">
                                <h3 class="card-title custom-card-title">{{ $card_title }}</h3>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@stop


@push('scripts')
    <script>


    </script>

@endpush