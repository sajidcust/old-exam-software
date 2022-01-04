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
                <h3 class="card-title">{{ $card_title }}</small></h3>
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
              <form id="quickForm" method="post" action="{{ route('institutions.store') }}">
              	{{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label for="labelInputInstitutionName">Institution Name<i class="fa fa-star-of-life required-label"></i></i></label>
                    <input type="text" name="name" class="form-control" id="labelInputInstitutionName" placeholder="Enter institution name" value="{{ Request::old('name') }}">
                   </div>
                   <div class="form-group">
                    <label for="labelInputIsDDO">Is DDO<i class="fa fa-star-of-life required-label"></i></label>
                    <select class="custom-select rounded-0" id="labelInputIsDDO" name="is_ddo">
                      <option value="1" {{ Request::old('is_ddo') == 1 ? 'selected':'' }}>YES</option>
                      <option value="0" {{ Request::old('is_ddo') == 0 ? 'selected':'' }}>NO</option>
                    </select>
                   </div>
                   <div class="form-group">
                      <label for="labelInputSelectDDO">Select DDO</label>
                      <select class="custom-select rounded-0 select2" id="labelInputSelectDDO" name="ddo_id">
                          <option value="">Select DDO</option> 
                          @foreach($institutions as $institution)
                              @if($institution->id == Request::old('ddo_id'))
                                  <option selected value="{{ $institution->id }}">{{ $institution->name }}</option>
                              @else
                                  <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                              @endif
                          @endforeach
                      </select>
                   </div>
                   <div class="form-group">
                    <label for="labelInputIsCenter">Is Center<i class="fa fa-star-of-life required-label"></i></label>
                    <select class="custom-select rounded-0" id="labelInputIsCenter" name="is_center">
                      <option value="1" {{ Request::old('is_center') == 1 ? 'selected':'' }}>YES</option>
                      <option value="0" {{ Request::old('is_center') == 0 ? 'selected':'' }}>NO</option>
                    </select>
                   </div>
                   <div class="form-group">
                      <label for="labelSelectTehsil">Select Tehsil</label>
                      <select class="custom-select rounded-0 select2" id="labelSelectTehsil" name="tehsil_id">
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

  $('#quickForm select[name="is_ddo"]').change(function(){
    if(parseInt($(this).val()) == 1){
      $('#quickForm select[name="ddo_id"]').attr('disabled', true);
    } else {
      $('#quickForm select[name="ddo_id"]').attr('disabled', false);
    }
  });

	var validatevar = $('#quickForm').validate({
      rules: {
        name: {
          required: true,
          minlength: 3,
        },
        is_ddo: {
          required: true
        },
        ddo_id: {
          required: true
        },
        is_center: {
          required: true
        },
        tehsil_id: {
          required: true
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
  }).change(function(){
      $('#quickForm').valid();
  });
</script>

@endpush