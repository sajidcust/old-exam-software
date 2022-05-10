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
              <form id="quickForm" method="post" action="{{ route('sessions.update') }}">
              	{{ csrf_field() }}
                <input id="hidden_identifier" type="hidden" value="{{ $session->id }}" name="session_id">
                <div class="card-body">
                  <div class="form-group">
                    <label for="labelInputSessionName">Session title<i class="fa fa-star-of-life required-label"></i></label>
                    <input type="text" name="title" class="form-control" id="labelInputSessionName" placeholder="Enter session title" value="{{ $session->title }}" value="{{ Request::old('title') != '' ? Request::old('title'):$session->title }}">
                  </div>
                  <div class="form-group">
                      <label for="labelInputYear">Year<i class="fa fa-star-of-life required-label"></i></label>
                      <input type="number" id="year" name="year" class="form-control" id="labelInputYear" placeholder="Enter year e.g (2021) " value="{{ Request::old('year') != '' ? Request::old('year'):$session->year }}">
                  </div>
                  <div class="form-group">
                      <label>Expiry Date<i class="fa fa-star-of-life required-label"></i></label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input id="datemask" type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask="" inputmode="numeric" name="expiry_date" value="{{ Request::old('expiry_date') != '' ? Request::old('expiry_date') : date('d-m-Y', strtotime($session->expiry_date)) }}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Result Declaration Date<i class="fa fa-star-of-life required-label"></i></label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input id="datemask" type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask="" inputmode="numeric" name="result_declaration_date" value="{{ Request::old('result_declaration_date') != '' ? Request::old('result_declaration_date') : date('d-m-Y', strtotime($session->result_declaration_date)) }}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="labelInputIsActive">Is Active<i class="fa fa-star-of-life required-label"></i></label>
                      <select class="custom-select rounded-0" id="labelInputIsActive" name="is_active">
                      @if(Request::old('is_active') != '')
                          <option value="0" {{ Request::old('is_active') == 0 ? 'selected':'' }}>NO</option>
                          <option value="1" {{ Request::old('is_active') == 1 ? 'selected':'' }}>YES</option>
                      @else
                        <option value="0" {{ $session->is_active == 0 ? 'selected':'' }}>NO</option>
                          <option value="1" {{ $session->is_active == 1 ? 'selected':'' }}>YES</option>
                      @endif
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

  $('input[name="expiry_date"]').datepicker({
    format: 'dd-mm-yyyy'
  });

  $('[data-mask]').inputmask();

  var isGreaterThanCurrentYear = function(enteredYear) {
      var d = new Date();
      var currentYear = d.getFullYear();
      if(currentYear >= parseInt(enteredYear)){
        return true;
      }
    };

    jQuery.validator.addMethod("isGreaterThanCurrentYear", function(value, element) {

        return isGreaterThanCurrentYear(value);
    }, "Year cannot be greater than current year.");

	var validatevar = $('#quickForm').validate({
	    rules: {
	      name: {
	        required: true,
	        minlength: 3,
	      },
        year: {
           required:true,
           minlength:4,
           maxlength:4
        },
        expiry_date: {
          required:true
        },
        is_active: {
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
</script>

@endpush