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
                    <h5 class="card-title"><b>Permissions Details</b></h5>

                    <div class="table-responsive">
                        <table class="table app-table-hover mb-0 text-left">
                            <thead>
                            <tr>
                                <th class="cell">S#</th>
                                <th class="cell">Name</th>
                                <th class="cell">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($models as $roles)
                                <tr>
                                    <td class="cell">{{$loop->iteration}}</td>
                                    <td class="cell">{{$roles->name ?? 'NA'}}</td>
                                    <td class="cell"><a class="btn-sm btn-primary"
                                                        href="{{route('permissions.edit', $roles->id)}}">Edit</a>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="6">No Permission Found..</td>
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
