@extends('layouts.layout')

@section('content')

    <main id="main" class="main">

        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">User Profile Details</h5>

                        {{ Form::model($user->id, array('route' => ['users.update-profile', $user->id], 'class' => 'form', 'id' => 'edit-account-form', 'files' => true)) }}
                        {!! method_field('POST') !!}

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">Name:</label>
                                    {{ Form::text('name', $user->name, ['class' => ( 'form-control '. ( $errors->has('name') ? ' is-invalid' : '' )), 'id' => 'name']) }}
                                    <div class="invalid-feedback">
                                        {{ $errors->has('name') ? $errors->first('name') : '' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="father_name">Father Name:</label>
                                    {{ Form::text('father_name', $user->father_name, ['class' => ( 'form-control '. ( $errors->has('father_name') ? ' is-invalid' : '' )), 'id' => 'father_name']) }}
                                    <div class="invalid-feedback">
                                        {{ $errors->has('father_name') ? $errors->first('father_name') : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="cnic_no">CNIC:</label>
                                    {{ Form::number('cnic_no', $user->cnic_number, ['class' => ( 'form-control '. ( $errors->has('cnic_no') ? ' is-invalid' : '' )), 'id' => 'cnic_no']) }}
                                    <div class="invalid-feedback">
                                        {{ $errors->has('cnic_no') ? $errors->first('cnic_no') : '' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="cell_no">Cell No:</label>
                                    {{ Form::number('cell_no', $user->cell_number, ['class' => ( 'form-control '. ( $errors->has('cell_no') ? ' is-invalid' : '' )), 'id' => 'cell_no']) }}
                                    <div class="invalid-feedback">
                                        {{ $errors->has('cell_no') ? $errors->first('cell_no') : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="email_address">Email Address:</label>
                                    {{ Form::email('email_address', $user->email, ['class' => ( 'form-control '. ( $errors->has('email_address') ? ' is-invalid' : '' )), 'id' => 'email_address']) }}
                                    <div class="invalid-feedback">
                                        {{ $errors->has('email_address') ? $errors->first('email_address') : '' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="password">Password:</label>
                                    {{ Form::password($user->password, ['class' => ( 'form-control '. ( $errors->has('password') ? ' is-invalid' : '' )), 'id' => 'password', 'name' => 'password']) }}
                                    <div class="invalid-feedback">
                                        {{ $errors->has('password') ? $errors->first('password') : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="confirm_password">Confirm Password:</label>
                                    {{ Form::password($user->password, ['class' => ( 'form-control '. ( $errors->has('confirm_password') ? ' is-invalid' : '' )), 'id' => 'confirm_password', 'name' => 'confirm_password']) }}
                                    <div class="invalid-feedback">
                                        {{ $errors->has('confirm_password') ? $errors->first('confirm_password') : '' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="image">Profile Picture:</label>
                                    {{ Form::file('image', ['class' => ( 'form-control '. ( $errors->has('image') ? ' is-invalid' : '' )), 'id' => 'image']) }}
                                    <div class="invalid-feedback">
                                        {{ $errors->has('image') ? $errors->first('image') : '' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="signature">Signature:</label>
                                    {{ Form::file('signature', ['class' => ( 'form-control '. ( $errors->has('signature') ? ' is-invalid' : '' )), 'id' => 'signature']) }}
                                    <div class="invalid-feedback">
                                        {{ $errors->has('signature') ? $errors->first('signature') : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row  mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label" for="address">Address:</label>
                                    {{ Form::text('address', $user->address, ['class' => ( 'form-control '. ( $errors->has('address') ? ' is-invalid' : '' )), 'id' => 'address']) }}
                                    <div class="invalid-feedback">
                                        {{ $errors->has('address') ? $errors->first('address') : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4 float-end">
                            <div class="col-md-12">
                                <div class="form-group">
                                    @if($user->profile_picture != NULL)
                                        <img src="{{asset($user->profile_picture)}}" alt="No Image" width="200px"
                                             height="200px" style="margin-right: 30px; border-radius: 10%;">
                                    @endif

                                    @if($user->signature != NULL)
                                        <img src="{{asset($user->signature)}}" alt="No Image" width="200px"
                                             height="200px" style="border-radius: 10%;">
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>

                    {{ Form::close() }}

                </div>
            </div>
        </div>


        {{--        <div class="row">--}}
        {{--            <div class="col">--}}
        {{--                <div class="card">--}}
        {{--                    <div class="card-body">--}}

        {{--                        <h5 class="card-title">Roles</h5>--}}

        {{--                        <div class="mb-3">--}}
        {{--                            <div class="row">--}}
        {{--                                @if ($user->roles)--}}
        {{--                                    @foreach ($user->roles as $user_role)--}}
        {{--                                        <div class="col-sm-3">--}}

        {{--                                            <form class="py-2"--}}
        {{--                                                  method="POST"--}}
        {{--                                                  action="{{ route('users.remove-role', [$user->id, $user_role->id]) }}"--}}
        {{--                                                  onsubmit="return confirm('Are you sure?');">--}}
        {{--                                                @csrf--}}
        {{--                                                @method('GET')--}}

        {{--                                                <button type="submit" class="btn btn-danger"--}}
        {{--                                                        style="height: 40px; width: 200px; font-size: 13px;">{{ $user_role->name }}</button>--}}
        {{--                                            </form>--}}
        {{--                                            @endforeach--}}
        {{--                                            @endif--}}
        {{--                                        </div>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}

        {{--                        <div class="max-w-xl mb-5">--}}
        {{--                            <form method="POST" action="{{ route('users.assign-role', $user->id) }}">--}}
        {{--                                @csrf--}}

        {{--                                <div class="row mb-3">--}}
        {{--                                    <div class="col-md-12">--}}
        {{--                                        <div class="form-group {{( $errors->has('role')) ? 'has-error' : ''}}">--}}
        {{--                                            <label class="control-label d-block" for="role">--}}
        {{--                                                Choose Role:--}}
        {{--                                            </label>--}}
        {{--                                            {{ Form::select('role',--}}
        {{--                                                        $roles,--}}
        {{--                                                        NULL,--}}
        {{--                                                        array('class' => ( 'form-select' ),--}}
        {{--                                                        'id' => 'role')) }}--}}
        {{--                                            <span class="help-block">--}}
        {{--                                    {{ $errors->has('role')? $errors->first('role'): '' }}--}}
        {{--                           </span>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                </div>--}}

        {{--                                <div class="row">--}}
        {{--                                    <div class="col-md-12">--}}
        {{--                                        <div class="form-group">--}}
        {{--                                            <button type="submit" class="btn btn-success">Assign</button>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                </div>--}}

        {{--                            </form>--}}
        {{--                        </div>--}}


        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}

        {{--        <div class="row">--}}
        {{--            <div class="col">--}}
        {{--                <div class="card">--}}
        {{--                    <div class="card-body">--}}

        {{--                        <h5 class="card-title">Permissions</h5>--}}

        {{--                        <div class="mb-3">--}}
        {{--                            <div class="row">--}}
        {{--                                @if ($user->permissions)--}}
        {{--                                    @foreach ($user->permissions as $user_permission)--}}

        {{--                                        <div class="col-sm-3">--}}
        {{--                                            <form class="py-2" method="POST"--}}
        {{--                                                  action="{{ route('users.remove-permission', [$user->id, $user_permission->id]) }}"--}}
        {{--                                                  onsubmit="return confirm('Are you sure?');">--}}
        {{--                                                @csrf--}}
        {{--                                                @method('GET')--}}

        {{--                                                <button type="submit"--}}
        {{--                                                        class="btn btn-danger"--}}
        {{--                                                        style="height: 50px; width: 200px; font-size: 13px;">{{ $user_permission->name }}</button>--}}
        {{--                                            </form>--}}
        {{--                                        </div>--}}
        {{--                                    @endforeach--}}
        {{--                                @endif--}}
        {{--                            </div>--}}
        {{--                        </div>--}}

        {{--                        <div class="max-w-xl">--}}
        {{--                            <form method="POST" action="{{ route('users.assign-permission', $user->id) }}">--}}
        {{--                                @csrf--}}

        {{--                                <div class="row mb-3">--}}
        {{--                                    <div class="col-md-12">--}}
        {{--                                        <div--}}
        {{--                                            class="form-group {{( $errors->has('permission')) ? 'has-error' : ''}}">--}}
        {{--                                            <label class="control-label d-block" for="permission">--}}
        {{--                                                Choose Permission:--}}
        {{--                                            </label>--}}
        {{--                                            {{ Form::select('permission',--}}
        {{--                                                        $permissions,--}}
        {{--                                                        NULL,--}}
        {{--                                                        array('class' => ( 'form-select' ),--}}
        {{--                                                        'id' => 'permission')) }}--}}
        {{--                                            <span class="help-block">--}}
        {{--                                    {{ $errors->has('permission')? $errors->first('permission'): '' }}--}}
        {{--                           </span>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                </div>--}}

        {{--                                <div class="row">--}}
        {{--                                    <div class="col-md-12">--}}
        {{--                                        <div class="form-group">--}}
        {{--                                            <button type="submit" class="btn btn-success">Assign</button>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                </div>--}}
        {{--                            </form>--}}
        {{--                        </div>--}}

        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}

    </main>

@endsection

