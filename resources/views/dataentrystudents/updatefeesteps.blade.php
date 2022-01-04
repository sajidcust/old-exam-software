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
                <h3 class="card-title">{{ $card_title }} of &nbsp;<a href="javascript:void(0);">{{ $student->name }}</a></h3>
                <h3 class="card-title float-lg-right"><b>Step 2 of 2</b></h3>
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
              <form id="quickForm" method="post" action="{{ route('destudents.storefee') }}">
              	{{ csrf_field() }}
                <input type="hidden" name="is_step" value="1">
              	<input type="hidden" name="student_id" value="{{ $student->id }}">
              	<input type="hidden" name="semester_id" value="{{ $semester->id }}">
                <div class="card-body">
                	<?php 
                		$selected_fee = App\Models\StudentsFeesSelection::returnfeeidsarray($student->id, $semester->id);

                	?>
                  <div class="form-group">
                      <label for="fee_id">Select Fee<i class="fa fa-star-of-life required-label select_input"></i></label>
                      <select class="custom-select rounded-0 select2" id="fee_id" name="fee_id[]" multiple="true">
                        @foreach($fees as $fee)
                          @if(in_array($fee->id, $selected_fee))
                            <option data-amount="{{ $fee->amount }}" selected value="{{ $fee->id }}">{{ $fee->title }}</option>
                          @else
                            <option data-amount="{{ $fee->amount }}" value="{{ $fee->id }}">{{ $fee->title }}</option>
                          @endif
                        @endforeach
                      </select>
                   </div>
                   <div class="form-group">
                      <label for="bank_id">Select Bank<i class="fa fa-star-of-life required-label select_input"></i></label>
                      <select class="custom-select rounded-0" id="bank_id" name="bank_id">
                        @foreach($banks as $bank)
                          @if($studentsfee)
	                          @if($bank->id == $studentsfee->bank_id)
	                            <option selected value="{{ $bank->id }}">{{ $bank->name }}</option>
	                          @else
	                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
	                          @endif
                          @else
                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                          @endif
                        @endforeach
                      </select>
                   </div>
                   <div class="form-group">
                    <label>Challan No<i class="fa fa-star-of-life required-label"></i></label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa fa-mobile-alt"></i></span>
                      </div>
                      <input type="number" class="form-control" data-inputmask="'mask': '9999'" data-mask="" inputmode="text" name="challan_no" value="{{ Request::old('challan_no') != '' ? Request::old('challan_no') : $studentsfee != NULL ?  $studentsfee->challan_no : ''}}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Date Of Deposit<i class="fa fa-star-of-life required-label"></i></label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                      </div>
                      <input id="datemask" type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask="" inputmode="numeric" name="date_of_deposit" value="{{ Request::old('date_of_deposit') != '' ? Request::old('date_of_deposit') : $studentsfee != NULL ? date('d-m-Y', strtotime($studentsfee->date_of_deposit)) : '' }}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Total Amount<i class="fa fa-star-of-life required-label"></i></label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa fa-mobile-alt"></i></span>
                      </div>
                      <input readonly="true" type="number" class="form-control" data-inputmask="'mask': '9999'" data-mask="" inputmode="text" name="total_amount" value="{{ Request::old('total_amount') != '0' ? Request::old('total_amount') : $studentsfee != NULL ?  $studentsfee->total_amount : '0'}}">
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
	$(document).ready(function(){
		var total_amount = 0;
		$('select[name="fee_id[]"] option:selected').each(function() {
		    total_amount = total_amount+parseInt($(this).data('amount'));
		});

		$('input[name=total_amount]').val(total_amount);
	});

	$('#quickForm').on('focus keyup keypress blur change focusout','select[name="fee_id[]"]', function(e){
		var total_amount = 0;
		$('select[name="fee_id[]"] option:selected').each(function() {
		    total_amount = total_amount+parseInt($(this).data('amount'));
		});

		$('input[name=total_amount]').val(total_amount);
	});

	$('input[name="date_of_deposit"]').datepicker({
	    format: 'dd-mm-yyyy'
	  });

	$('[data-mask]').inputmask();

	$(function () {
	    bsCustomFileInput.init();
	  });

	var validatevar = $('#quickForm').validate({
	    rules: {
	        "fee_id[]": {
            	required: true
	        },
	        bank: {
	          	required: true
	        },
	        challan_no: {
	          	required: true,
	          	number: true
	        },
	        date_of_deposit: {
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