@extends('layouts.main')


@section('content')
	<!-- Content Header (Page header) -->
    <section class="content-header">
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

	<!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Generate Slips For {{ $session->title }} - {{ $semester->title }}</small></h3>
              </div>
              <!-- /.card-header -->
                @if($errors->any())
	              <div class="">
	                <div class="alert alert-danger" role="alert">The following errors have occured:<br>
	                   @foreach($errors->all() as $error)
	                      <li>{{ $error }} </li>
	                   @endforeach
	                </div>
	              </div>
	            @endif
              <!-- form start -->
              <form id="quickForm_sessions" method="post" action="{{ route('exams.generateslipbysessionid') }}">
              	{{ csrf_field() }}
                <input type="hidden" name="session_id" value="{{ $session->id }}">
                <input type="hidden" name="semester_id" value="{{ $semester->id }}">
                <div class="card-body">
                  <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label>Skip Records<i class="fa fa-star-of-life required-label"></i></label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa fa-mobile-alt"></i></span>
                            </div>
                            <input type="number" class="form-control" data-inputmask="'mask': '9999'" data-mask="" inputmode="text" name="skip_records" value="{{ Request::old('skip_records') }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label>Limit Records<i class="fa fa-star-of-life required-label"></i></label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa fa-mobile-alt"></i></span>
                            </div>
                            <input type="number" class="form-control" data-inputmask="'mask': '9999'" data-mask="" inputmode="text" name="limit_records" value="{{ Request::old('limit_records') }}">
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input id="submitBtn" type="submit" class="btn btn-success" value="Submit">
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Generate Slips By District For {{ $session->title }} - {{ $semester->title }}</small></h3>
              </div>
              <!-- /.card-header -->
                @if($errors->any())
                <div class="">
                  <div class="alert alert-danger" role="alert">The following errors have occured:<br>
                     @foreach($errors->all() as $error)
                        <li>{{ $error }} </li>
                     @endforeach
                  </div>
                </div>
              @endif
              <!-- form start -->
              <form id="quickForm_districts" method="post" action="{{ route('exams.generateslipbydistrictid') }}">
                {{ csrf_field() }}
                <input type="hidden" name="session_id" value="{{ $session->id }}">
                <input type="hidden" name="semester_id" value="{{ $semester->id }}">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                          <label for="labelInputSelectDistrict">Select District</label>
                          <select class="custom-select rounded-0 select2" id="labelInputSelectDistrict" name="district_id">
                              <option value="">Select District</option> 
                              @foreach($districts as $district)
                                  @if($district->id == Request::old('district_id'))
                                      <option selected value="{{ $district->id }}">{{ $district->name }}</option>
                                  @else
                                      <option value="{{ $district->id }}">{{ $district->name }}</option>
                                  @endif
                              @endforeach
                          </select>
                       </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Skip Records<i class="fa fa-star-of-life required-label"></i></label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa fa-mobile-alt"></i></span>
                            </div>
                            <input type="number" class="form-control" data-inputmask="'mask': '9999'" data-mask="" inputmode="text" name="skip_records" value="{{ Request::old('skip_records') }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Limit Records<i class="fa fa-star-of-life required-label"></i></label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa fa-mobile-alt"></i></span>
                            </div>
                            <input type="number" class="form-control" data-inputmask="'mask': '9999'" data-mask="" inputmode="text" name="limit_records" value="{{ Request::old('limit_records') }}">
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input id="submitBtn" type="submit" class="btn btn-success" value="Submit">
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Generate Slips By Tehsils For {{ $session->title }} - {{ $semester->title }}</small></h3>
              </div>
              <!-- /.card-header -->
                @if($errors->any())
                <div class="">
                  <div class="alert alert-danger" role="alert">The following errors have occured:<br>
                     @foreach($errors->all() as $error)
                        <li>{{ $error }} </li>
                     @endforeach
                  </div>
                </div>
              @endif
              <!-- form start -->
              <form id="quickForm_tehsils" method="post" action="{{ route('exams.generateslipbytehsilid') }}">
                {{ csrf_field() }}
                <input type="hidden" name="session_id" value="{{ $session->id }}">
                <input type="hidden" name="semester_id" value="{{ $semester->id }}">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                          <label for="labelInputSelectTehsil">Select Tehsil</label>
                          <select class="custom-select rounded-0 select2" id="labelInputSelectTehsil" name="tehsil_id">
                              <option value="">Select Tehsil</option> 
                              @foreach($tehsils as $tehsil)
                                  @if($tehsil->id == Request::old('tehsil_id'))
                                      <option selected value="{{ $tehsil->id }}">{{ $tehsil->name }}</option>
                                  @else
                                      <option value="{{ $tehsil->id }}">{{ $tehsil->name }}</option>
                                  @endif
                              @endforeach
                          </select>
                       </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Skip Records<i class="fa fa-star-of-life required-label"></i></label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa fa-mobile-alt"></i></span>
                            </div>
                            <input type="number" class="form-control" data-inputmask="'mask': '9999'" data-mask="" inputmode="text" name="skip_records" value="{{ Request::old('skip_records') }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Limit Records<i class="fa fa-star-of-life required-label"></i></label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa fa-mobile-alt"></i></span>
                            </div>
                            <input type="number" class="form-control" data-inputmask="'mask': '9999'" data-mask="" inputmode="text" name="limit_records" value="{{ Request::old('limit_records') }}">
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input id="submitBtn" type="submit" class="btn btn-success" value="Submit">
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Generate Slips By Institutions For {{ $session->title }} - {{ $semester->title }}</small></h3>
              </div>
              <!-- /.card-header -->
                @if($errors->any())
                <div class="">
                  <div class="alert alert-danger" role="alert">The following errors have occured:<br>
                     @foreach($errors->all() as $error)
                        <li>{{ $error }} </li>
                     @endforeach
                  </div>
                </div>
              @endif
              <!-- form start -->
              <form id="quickForm_institutions" method="post" action="{{ route('exams.generateslipbyinstitutionid') }}">
                {{ csrf_field() }}
                <input type="hidden" name="session_id" value="{{ $session->id }}">
                <input type="hidden" name="semester_id" value="{{ $semester->id }}">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                          <label for="labelInputSelectInstitution">Select Institution</label>
                          <select class="custom-select rounded-0 select2" id="labelInputSelectInstitution" name="institution_id">
                              <option value="">Select Institution</option> 
                              @foreach($institutions as $institution)
                                  @if($institution->id == Request::old('institution_id'))
                                      <option selected value="{{ $institution->id }}">{{ $institution->name }}</option>
                                  @else
                                      <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                                  @endif
                              @endforeach
                          </select>
                       </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Skip Records<i class="fa fa-star-of-life required-label"></i></label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa fa-mobile-alt"></i></span>
                            </div>
                            <input type="number" class="form-control" data-inputmask="'mask': '9999'" data-mask="" inputmode="text" name="skip_records" value="{{ Request::old('skip_records') }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Limit Records<i class="fa fa-star-of-life required-label"></i></label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa fa-mobile-alt"></i></span>
                            </div>
                            <input type="number" class="form-control" data-inputmask="'mask': '9999'" data-mask="" inputmode="text" name="limit_records" value="{{ Request::old('limit_records') }}">
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input id="submitBtn" type="submit" class="btn btn-success" value="Submit">
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Generate Slips By Centers For {{ $session->title }} - {{ $semester->title }}</small></h3>
              </div>
              <!-- /.card-header -->
                @if($errors->any())
                <div class="">
                  <div class="alert alert-danger" role="alert">The following errors have occured:<br>
                     @foreach($errors->all() as $error)
                        <li>{{ $error }} </li>
                     @endforeach
                  </div>
                </div>
              @endif
              <!-- form start -->
              <form id="quickForm_centers" method="post" action="{{ route('exams.generateslipbycenterid') }}">
                {{ csrf_field() }}
                <input type="hidden" name="session_id" value="{{ $session->id }}">
                <input type="hidden" name="semester_id" value="{{ $semester->id }}">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                          <label for="labelInputSelectCenter">Select Center</label>
                          <select class="custom-select rounded-0 select2" id="labelInputSelectCenter" name="center_id">
                              <option value="">Select Center</option> 
                              @foreach($institutions as $institution)
                                  @if($institution->is_center)
                                    @if($institution->id == Request::old('center_id'))
                                        <option selected value="{{ $institution->id }}">{{ $institution->name }}</option>
                                    @else
                                        <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                                    @endif
                                  @endif
                              @endforeach
                          </select>
                       </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Skip Records<i class="fa fa-star-of-life required-label"></i></label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa fa-mobile-alt"></i></span>
                            </div>
                            <input type="number" class="form-control" data-inputmask="'mask': '9999'" data-mask="" inputmode="text" name="skip_records" value="{{ Request::old('skip_records') }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Limit Records<i class="fa fa-star-of-life required-label"></i></label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa fa-mobile-alt"></i></span>
                            </div>
                            <input type="number" class="form-control" data-inputmask="'mask': '9999'" data-mask="" inputmode="text" name="limit_records" value="{{ Request::old('limit_records') }}">
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input id="submitBtn" type="submit" class="btn btn-success" value="Submit">
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Generate Slips By Classes For {{ $session->title }} - {{ $semester->title }}</small></h3>
              </div>
              <!-- /.card-header -->
                @if($errors->any())
                <div class="">
                  <div class="alert alert-danger" role="alert">The following errors have occured:<br>
                     @foreach($errors->all() as $error)
                        <li>{{ $error }} </li>
                     @endforeach
                  </div>
                </div>
              @endif
              <!-- form start -->
              <form id="quickForm_classes" method="post" action="{{ route('exams.generateslipbyclassid') }}">
                {{ csrf_field() }}
                <input type="hidden" name="session_id" value="{{ $session->id }}">
                <input type="hidden" name="semester_id" value="{{ $semester->id }}">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                          <label for="labelInputSelectClass">Select class</label>
                          <select class="custom-select rounded-0 select2" id="labelInputSelectClass" name="class_id">
                              <option value="">Select class</option> 
                              @foreach($standards as $standard)
                                  @if($standard->id == Request::old('class_id'))
                                      <option selected value="{{ $standard->id }}">{{ $standard->name }}</option>
                                  @else
                                      <option value="{{ $standard->id }}">{{ $standard->name }}</option>
                                  @endif
                              @endforeach
                          </select>
                       </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Skip Records<i class="fa fa-star-of-life required-label"></i></label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa fa-mobile-alt"></i></span>
                            </div>
                            <input type="number" class="form-control" data-inputmask="'mask': '9999'" data-mask="" inputmode="text" name="skip_records" value="{{ Request::old('skip_records') }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Limit Records<i class="fa fa-star-of-life required-label"></i></label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa fa-mobile-alt"></i></span>
                            </div>
                            <input type="number" class="form-control" data-inputmask="'mask': '9999'" data-mask="" inputmode="text" name="limit_records" value="{{ Request::old('limit_records') }}">
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input id="submitBtn" type="submit" class="btn btn-success" value="Submit">
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Generate Slips By Student Type For {{ $session->title }} - {{ $semester->title }}</small></h3>
              </div>
              <!-- /.card-header -->
                @if($errors->any())
                <div class="">
                  <div class="alert alert-danger" role="alert">The following errors have occured:<br>
                     @foreach($errors->all() as $error)
                        <li>{{ $error }} </li>
                     @endforeach
                  </div>
                </div>
              @endif
              <!-- form start -->
              <form id="quickForm_studenttypes" method="post" action="{{ route('exams.generateslipbystudenttype') }}">
                {{ csrf_field() }}
                <input type="hidden" name="session_id" value="{{ $session->id }}">
                <input type="hidden" name="semester_id" value="{{ $semester->id }}">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="labelInputStudentType">Student Type<i class="fa fa-star-of-life required-label"></i></label>
                        <select class="custom-select rounded-0" id="labelInputStudentType" name="student_type">
                          <option value="1" {{ Request::old('student_type') == 1 ? 'selected':'' }}>PRIVATE</option>
                          <option value="0" {{ Request::old('student_type') == 0 ? 'selected':'' }}>REGULAR</option>
                        </select>
                       </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Skip Records<i class="fa fa-star-of-life required-label"></i></label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa fa-mobile-alt"></i></span>
                            </div>
                            <input type="number" class="form-control" data-inputmask="'mask': '9999'" data-mask="" inputmode="text" name="skip_records" value="{{ Request::old('skip_records') }}">
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Limit Records<i class="fa fa-star-of-life required-label"></i></label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa fa-mobile-alt"></i></span>
                            </div>
                            <input type="number" class="form-control" data-inputmask="'mask': '9999'" data-mask="" inputmode="text" name="limit_records" value="{{ Request::old('limit_records') }}">
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input id="submitBtn" type="submit" class="btn btn-success" value="Submit">
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@stop


@push('scripts')
<script>

	var validatevar = $('#quickForm_sessions').validate({
      rules: {
        skip_records: {
          required: true,
          number: true
        },
        limit_records: {
          required: true,
          number: true
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        $(element).removeClass('is-valid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        $(element).addClass('is-valid');
      },
      submitHandler: function(form) {
        form.submit();
      }
   });

  var validatevar = $('#quickForm_districts').validate({
      rules: {
        district_id: {
          required: true
        },
        skip_records: {
          required: true,
          number: true
        },
        limit_records: {
          required: true,
          number: true
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        $(element).removeClass('is-valid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        $(element).addClass('is-valid');
      },
      submitHandler: function(form) {
        form.submit();
      }
   });

  var validatevar = $('#quickForm_tehsils').validate({
      rules: {
        tehsil_id: {
          required: true
        },
        skip_records: {
          required: true,
          number: true
        },
        limit_records: {
          required: true,
          number: true
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        $(element).removeClass('is-valid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        $(element).addClass('is-valid');
      },
      submitHandler: function(form) {
        form.submit();
      }
   });

  var validatevar = $('#quickForm_centers').validate({
      rules: {
        center_id: {
          required: true
        },
        skip_records: {
          required: true,
          number: true
        },
        limit_records: {
          required: true,
          number: true
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        $(element).removeClass('is-valid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        $(element).addClass('is-valid');
      },
      submitHandler: function(form) {
        form.submit();
      }
   });

  var validatevar = $('#quickForm_institutions').validate({
      rules: {
        institution_id: {
          required: true
        },
        skip_records: {
          required: true,
          number: true
        },
        limit_records: {
          required: true,
          number: true
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        $(element).removeClass('is-valid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        $(element).addClass('is-valid');
      },
      submitHandler: function(form) {
        form.submit();
      }
   });

  var validatevar = $('#quickForm_classes').validate({
      rules: {
        class_id: {
          required: true
        },
        skip_records: {
          required: true,
          number: true
        },
        limit_records: {
          required: true,
          number: true
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        $(element).removeClass('is-valid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        $(element).addClass('is-valid');
      },
      submitHandler: function(form) {
        form.submit();
      }
   });

  var validatevar = $('#quickForm_studenttypes').validate({
      rules: {
        student_type: {
          required: true
        },
        skip_records: {
          required: true,
          number: true
        },
        limit_records: {
          required: true,
          number: true
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        $(element).removeClass('is-valid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        $(element).addClass('is-valid');
      },
      submitHandler: function(form) {
        form.submit();
      }
   });

  $('.select2').select2({
      theme: 'bootstrap4'
  });
</script>

@endpush