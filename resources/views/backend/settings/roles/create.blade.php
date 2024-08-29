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
                    <div class="col-10">
                        <h5><b>Create new user role.</b></h5>
                    </div>

                    {{ Form::open(array('route' => 'roles.store', 'class' => 'form', 'id' => 'create-roles-form')) }}

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="name">Name:</label>
                                {{ Form::text('name', NULL, ['class' => ( 'form-control '. ( $errors->has('name') ? ' is-invalid' : '' )), 'id' => 'name']) }}
                                <div class="invalid-feedback">
                                    {{ $errors->has('name') ? $errors->first('name') : '' }}
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group {{( $errors->has('permissions')) ? 'has-error' : ''}}">
                                <label class="control-label" for="permissions">Choose Permissions</label>
                                {{ Form::select('permissions[]',
                                                $permissions,
                                                request('permissions'),
                                                array('class' => ( 'form-control select2' ),
                                                'id' => 'permissions[]',
                                                'multiple' => 'multiple'))
                                                }}
                                <span class="help-block">
                                    {{ $errors->has('permissions')? $errors->first('permissions'): '' }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-12 mt-2">
                            <input id="submitBtn" type="submit" class="btn btn-success" value="Submit">
                        </div>
                    </div>


                    {{ Form::close() }}

                </div>
            </div>
        </div>
    </div>
@endsection
