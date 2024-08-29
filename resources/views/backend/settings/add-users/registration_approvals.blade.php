@extends('layouts.main')


@section('content')

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
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $breadcrumb_title }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">

                    <div class="row g-2 justify-content-start justify-content-md-end align-items-center">

                        <div class="col-10">
                            <h5><b> View and Manage all requests shown below.</b></h5>
                        </div>

                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table app-table-hover mb-0 text-left">
                            <thead>
                            <tr>
                                <th class="cell">S#</th>
                                <th class="cell">Name</th>
                                <th class="cell">Email Address</th>
                                <th class="cell"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($models as $users)
                                <tr>
                                    <td class="cell text-center"><b>{{$loop->iteration}}</b></td>
                                    <td class="cell">{{$users->name ?? 'NA'}}</td>
                                    <td class="cell">{{$users->email ?? 'NA'}}</td>

                                    <td class="cell"><a class="btn btn-success"
                                                        href="{{route('user-management.show', $users->id)}}">Approved</a>
                                    </td>

                                    <td class="cell"><a class="btn btn-danger"
                                                        href="{{route('user-management.delete', $users->id)}}">Dis-Approved</a>
                                    </td>

                                </tr>

                            @empty
                                <tr>
                                    <td colspan="3">No User Found</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                        <br>

                    </div><!--//table-responsive-->
                </div>
            </div><!--//app-card-body-->
        </div>
    </div>
@endsection

