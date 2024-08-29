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
                        <h5><b>Edit user.</b></h5>
                    </div>

                    {{ Form::model($user->id, array('route' => ['user-management.update', $user->id], 'class' => 'form', 'id' => 'edit-account-form', 'files' => true)) }}
                    {!! method_field('POST') !!}

                    <div class="row mt-4">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="name">Name:</label>
                                {{ Form::text('name', $user->name, ['class' => ( 'form-control '. ( $errors->has('name') ? ' is-invalid' : '' )), 'id' => 'name']) }}
                                <div class="invalid-feedback">
                                    {{ $errors->has('name') ? $errors->first('name') : '' }}
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="email_address">Email Address:</label>
                                {{ Form::email('email_address', $user->email, ['class' => ( 'form-control '. ( $errors->has('email_address') ? ' is-invalid' : '' )), 'id' => 'email_address']) }}
                                <div class="invalid-feedback">
                                    {{ $errors->has('email_address') ? $errors->first('email_address') : '' }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="password">Password:</label>
                                {{ Form::password($user->password, ['class' => ( 'form-control '. ( $errors->has('password') ? ' is-invalid' : '' )), 'id' => 'password', 'name' => 'password']) }}
                                <div class="invalid-feedback">
                                    {{ $errors->has('password') ? $errors->first('password') : '' }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="confirm_password">Confirm Password:</label>
                                {{ Form::password($user->password, ['class' => ( 'form-control '. ( $errors->has('confirm_password') ? ' is-invalid' : '' )), 'id' => 'confirm_password', 'name' => 'confirm_password']) }}
                                <div class="invalid-feedback">
                                    {{ $errors->has('confirm_password') ? $errors->first('confirm_password') : '' }}
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="form-group {{( $errors->has('role')) ? 'has-error' : ''}}">
                                <label class="control-label d-block" for="role">
                                    Choose Role:
                                </label>
                                {{ Form::select('role[]',
                                            $roles,
                                            $user->roles()->pluck('id'),
                                            array('class' => ( ['form-control select2'] ),
                                            'id' => 'role[]',
                                             'multiple' => 'multiple')) }}
                                <span class="help-block">
                                    {{ $errors->has('role')? $errors->first('role'): '' }}
                           </span>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="form-group {{( $errors->has('status')) ? 'has-error' : ''}}">
                                <label class="control-label d-block" for="status">
                                    Choose Status:
                                </label>
                                {{ Form::select('status',
                                            ["1" => "Active",
                                            "0" => "In-Active",],
                                            $user->status,
                                            array('class' => ( 'form-control' ),
                                            'id' => 'status')) }}
                                <span class="help-block">
                                                            {{ $errors->has('status')? $errors->first('status'): '' }}
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

@endsection

