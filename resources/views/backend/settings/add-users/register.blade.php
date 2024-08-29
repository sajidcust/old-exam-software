@extends('layouts.sub')


@section('content')
    <div class="card">
        @if(Session::has('message'))
            <div class="alert alert-info alert-dismissible font-size-12px">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <p class="error-title-styling"><i class="icon fas fa-check"></i> Message!</p>
                <hr class="error-hr">
                {{ Session::get('message') }}
            </div>
        @endif

        @if($errors->has('message'))
            <div class="alert alert-danger alert-dismissible font-size-12px">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <p class="error-title-styling"><i class="icon fas fa-ban"></i> Error!</p>
                <hr class="error-hr">
                {{ $errors->first('message') }}
            </div>
        @endif
        <div class="card-body login-card-body">
            <p class="login-box-msg">Register now</p>

            <form id="quickForm" action="{{ route('user-management.submit.registration') }}" method="post">
                {{ csrf_field() }}
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Name" name="name"
                           value="{{ Request::old('name') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email" name="email"
                           value="{{ Request::old('email') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-12 mt-2">
                        <button type="submit" class="btn btn-success btn-block">Register</button>
                    </div>
                    <!-- /.col -->
                </div>

            </form>


        </div>
        <!-- /.login-card-body -->
    </div>
@stop
