@extends('layouts.main')


@section('content')
	<!-- Content Header (Page header) -->
	

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
              <li class="breadcrumb-item"><a href="{{ url('assessmentcenter/dashboard') }}">Dashboard</a></li>
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
          <div class="col-12">
            <!-- /.card -->

            <!-- /.row -->
	        <div class="row">
	          <div class="col-md-12">
	            <div class="card card-default">
	              <div class="card-header">
	                <h3 class="card-title">{{ $card_title }} of <a href="javascript:void(0);">{{ $student->name }}</a> s/d of <a href="javascript:void(0);">{{ $student->father_name }}</a> r/o <a href="javascript:void(0);">{{ $student->home_address }}</a> for <a href="javascript:void(0);">{{ $semester->title }}</a></h3>
	              </div>
	              @if($errors->any())
	              <div class="">
	                <div class="alert alert-danger" role="alert">The following errors have occured:<br>
	                   @foreach($errors->all() as $error)
	                      <li>{{ $error }} </li>
	                   @endforeach
	                </div>
	              </div>
	            @endif
	            <form id="quickForm" method="post" action="{{ route('marks.update') }}" class="form-horizontal" enctype="multipart/form-data">
                	{{ csrf_field() }}
                	<input type="hidden" name="student_id" value="{{ $student->id }}">
                	<input type="hidden" name="semester_id" value="{{ $semester->id }}">
                	@if(isset($session_id))
	                	<input type="hidden" name="session_id" value="{{ $session_id }}">
	                	<input type="hidden" name="class_id" value="{{ $class_id }}">
	                	<input type="hidden" name="center_id" value="{{ $center_id }}">
	                @endif
	              <div class="card-body">
	              	<div class="row">
		              	<div class="col-lg-3">
		                    <label class="text-align-center" for="labelInputSubject">Subject<i class="fa fa-star-of-life required-label"></i></label>
			           </div>
			           <div class="col-lg-1">
		                    <label class="text-align-center" for="labelInputTheoryMaxMarks">Absent<i class="fa fa-star-of-life required-label"></i></label>
		                </div>
		                <div class="col-lg-2">
		                    <label class="text-align-center" for="labelInputSheetNo">Sheet No<i class="fa fa-star-of-life required-label"></i></label>
		                </div>
		               <div class="col-lg-1">
		                    <label class="text-align-center" for="labelInputTheoryMaxMarks">Theory Max Marks<i class="fa fa-star-of-life required-label"></i></label>
		                </div>
		                <div class="col-lg-1">
		                    <label class="text-align-center" for="labelInputTheoryObtMarks">Theory Obt Marks<i class="fa fa-star-of-life required-label"></i></label>
		                </div>
		                <div class="col-lg-1">
		                    <label class="text-align-center" for="labelInputPracticalMaxMarks">Practical Max Marks<i class="fa fa-star-of-life required-label"></i></label>
		                </div>
		                <div class="col-lg-1">
		                    <label class="text-align-center" for="labelInputPracticalObtMarks">Practical Obt Marks<i class="fa fa-star-of-life required-label"></i></label>
		                </div>
		                <div class="col-lg-1">
		                    <label class="text-align-center" for="labelInputTotalMaxMarks">Total Max Marks<i class="fa fa-star-of-life required-label"></i></label>
		                </div>
		                <div class="col-lg-1">
		                    <label class="text-align-center" for="labelInputTotalObtMarks">Total Obtained Marks<i class="fa fa-star-of-life required-label"></i></label>
		                </div>
		            </div>   
	              	<div id="field_wrapper">
			            @foreach($subjects as $subject)

			            <?php
			              	$se = App\Models\StudentsExam::getExamdetailsByStudents($student->id, $semester->id, $subject->id);
			            ?>
			              		<div class="dynamic_wrapper">
				              		<div class="row">
						              	<div class="col-lg-3">
							              	<div class="form-group">
							                    <select class="custom-select rounded-0 is-valid" name="subject_id[]" aria-invalid="false">
							                    	<option data-haspractical="{{ $subject->has_practical }}" value="{{ $subject->id }}">{{ $subject->name }}</option>
							                    </select>
							               </div>
							           </div>
							           <div class="col-lg-1 is_absent">
							                <div class="form-group clearfix">
							                	<div class="centerer">
							                      <div class="icheck-danger d-inline">
							                        <input {{ is_null($se) ? '':$se->is_absent == 1 ? 'checked':'' }} type="checkbox" name="is_absent[]" id="check_box_{{ $subject->id }}" value="{{ is_null($se) ? '0':$se->is_absent }}">
							                        <input type="hidden" name="is_absent_val[]" value="{{ is_null($se) ? '0':$se->is_absent }}">
							                        <label for="check_box_{{ $subject->id }}">
							                        </label>
							                      </div>
							                    </div>
						                    </div>
						                </div>
							           <div class="col-lg-2 sheet_no">
							           		<div class="form-group clearfix">
							                    <input {{ is_null($se) ? '':$se->is_absent == 1 ? 'readonly':'' }} type="text" name="sheet_no[]" class="form-control" id="labelInputSheetNo" placeholder="Enter sheet no" value="{{ is_null($se) ? '':$se->sheet_no }}">
							                 </div>
						                </div>
						                <div class="col-lg-1 theory_marks">
							                <div class="form-group">
							                    <input type="number" name="theory_max_marks[]" class="form-control" placeholder="Theory Max Marks" value="{{ is_null($se) ? '0':$se->theory_max_marks }}">
						                   </div>
						                </div>
						                <div class="col-lg-1 theory_marks">
							                <div class="form-group">
							                    <input {{ is_null($se) ? '' : $se->is_absent == 1 ? 'readonly':'' }} type="number" name="theory_obt_marks[]" class="form-control" placeholder="Theory Obt Marks" value="{{ is_null($se) ? '0' : $se->theory_obt_marks }}">
						                   </div>
						                </div>
						                <div class="col-lg-1 practical_marks">
							                <div class="form-group">
							                    <input {{ $subject->has_practical == 1 ? '':'readonly' }} type="number" name="practical_max_marks[]" class="form-control" placeholder="Practical Max Marks" value="{{ is_null($se) ? '0' : $subject->has_practical == 1 ? $se->practical_max_marks:'0' }}">
						                   </div>
						                </div>
						                <div class="col-lg-1 practical_marks">
							                <div class="form-group">
							                    <input {{ is_null($se) ? '' : $se->is_absent == 1 ? 'readonly':'' }} {{ $subject->has_practical == 1 ? '':'readonly' }} type="number" name="practical_obt_marks[]" class="form-control" placeholder="Practical Obt Marks" value="{{ is_null($se) ? '0' : $subject->has_practical == 1 ? $se->practical_obt_marks:'0' }}">
						                   </div>
						                </div>
						                <div class="col-lg-1 total_marks">
							                <div class="form-group">
							                    <input readonly="true" type="number" name="total_max_marks[]" class="form-control" placeholder="Total Max Marks" value="{{ is_null($se) ? '0' : $se->total_max_marks }}">
						                   </div>
						                </div>
						                <div class="col-lg-1 total_marks">
							                <div class="form-group">
							                    <input readonly="true" type="number" name="total_obt_marks[]" class="form-control" placeholder="Total Obt Marks" value="{{ is_null($se) ? '0' : $se->total_obt_marks }}">
						                   </div>
						                </div>
						            </div>
						        </div>
			            @endforeach
	               	</div>
	              </div>
	              <!-- /.card-body -->
	                <div class="card-footer">
	                  <div class="display-inline">
	                    <button type="submit" id="save_button" class="btn btn-primary pull-right-button" disabled>Save</button>
	                  </div>
	                </div>
				</form>
	            </div>
	            <!-- /.card -->
	          </div>
	        </div>
	        <!-- /.row -->
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@stop


@push('scripts')
<script>

	$('#quickForm').on('change', 'input[name="is_absent[]"]', function(){
		var checked = $(this).is(':checked');

		var theory_max_marks = $(this).closest('.dynamic_wrapper').find('input[name="theory_max_marks[]"]').val();
		var practical_max_marks = $(this).closest('.dynamic_wrapper').find('input[name="practical_max_marks[]"]').val();
		var total_max_marks = 0;

		if(theory_max_marks != '' && practical_max_marks == ''){
			total_max_marks = parseInt(theory_max_marks);
		} else if(theory_max_marks == '' && practical_max_marks != ''){
			total_max_marks = parseInt(practical_max_marks); 
		} else if(theory_max_marks == '' && practical_max_marks == '') {
			total_max_marks = 0;
	    } else {
			total_max_marks = parseInt(theory_max_marks) + parseInt(practical_max_marks);
		}

		$(this).closest('.dynamic_wrapper').find('input[name="total_max_marks[]"]').val(total_max_marks);

		if(checked == true) {
			$(this).closest('.dynamic_wrapper').find('input[name="is_absent_val[]"]').val('1');
			$(this).closest('.dynamic_wrapper').find('input[name="sheet_no[]"]').val('0');
			$(this).closest('.dynamic_wrapper').find('input[name="sheet_no[]"]').attr('readonly', 'true');
			//$(this).closest('.dynamic_wrapper').find('input[name="theory_max_marks[]"]').val('0');
			//$(this).closest('.dynamic_wrapper').find('input[name="theory_max_marks[]"]').attr('readonly', 'true');
			$(this).closest('.dynamic_wrapper').find('input[name="theory_obt_marks[]"]').val('0');
			$(this).closest('.dynamic_wrapper').find('input[name="theory_obt_marks[]"]').attr('readonly', 'true');

			//$(this).closest('.dynamic_wrapper').find('input[name="practical_max_marks[]"]').val('0');
			//$(this).closest('.dynamic_wrapper').find('input[name="practical_max_marks[]"]').attr('readonly', 'true');
			$(this).closest('.dynamic_wrapper').find('input[name="practical_obt_marks[]"]').val('0');
			$(this).closest('.dynamic_wrapper').find('input[name="practical_obt_marks[]"]').attr('readonly', 'true');
			//$(this).closest('.dynamic_wrapper').find('input[name="total_max_marks[]"]').val('0');
			$(this).closest('.dynamic_wrapper').find('input[name="total_obt_marks[]"]').val('0');
		} else {
			$(this).closest('.dynamic_wrapper').find('input[name="is_absent_val[]"]').val('0');
			$(this).closest('.dynamic_wrapper').find('input[name="sheet_no[]"]').val('0');
			$(this).closest('.dynamic_wrapper').find('input[name="sheet_no[]"]').removeAttr('readonly');
			//$(this).closest('.dynamic_wrapper').find('input[name="theory_max_marks[]"]').val('0');
			//$(this).closest('.dynamic_wrapper').find('input[name="theory_max_marks[]"]').removeAttr('readonly');
			$(this).closest('.dynamic_wrapper').find('input[name="theory_obt_marks[]"]').val('0');
			$(this).closest('.dynamic_wrapper').find('input[name="theory_obt_marks[]"]').removeAttr('readonly');

			//alert(parseInt($(this).closest('.dynamic_wrapper').find('select[name="subject_id[]"] option:selected').data('haspractical')));

			if(parseInt($(this).closest('.dynamic_wrapper').find('select[name="subject_id[]"] option:selected').data('haspractical')) == 0)
			{
				//$(this).closest('.dynamic_wrapper').find('input[name="practical_max_marks[]"]').val('0');
				//$(this).closest('.dynamic_wrapper').find('input[name="practical_max_marks[]"]').attr('readonly', true);
				$(this).closest('.dynamic_wrapper').find('input[name="practical_obt_marks[]"]').val('0');
				$(this).closest('.dynamic_wrapper').find('input[name="practical_obt_marks[]"]').attr('readonly', true);
				
			} else {
				//$(this).closest('.dynamic_wrapper').find('input[name="practical_max_marks[]"]').val('0');
				//$(this).closest('.dynamic_wrapper').find('input[name="practical_max_marks[]"]').removeAttr('readonly');
				$(this).closest('.dynamic_wrapper').find('input[name="practical_obt_marks[]"]').val('0');
				$(this).closest('.dynamic_wrapper').find('input[name="practical_obt_marks[]"]').removeAttr('readonly');

			}

			//$(this).closest('.dynamic_wrapper').find('input[name="total_max_marks[]"]').val('0');
			$(this).closest('.dynamic_wrapper').find('input[name="total_obt_marks[]"]').val('0');
		}
	});

	$('#quickForm').on('focus keyup keypress blur change focusout','input[name="theory_max_marks[]"]', function(e){
		var theory_max_marks = $(this).val();
		var practical_max_marks = $(this).closest('.dynamic_wrapper').find('input[name="practical_max_marks[]"]').val();
		var total_max_marks = 0;

		if(theory_max_marks != '' && practical_max_marks == ''){
			total_max_marks = parseInt(theory_max_marks);
		} else if(theory_max_marks == '' && practical_max_marks != ''){
			total_max_marks = parseInt(practical_max_marks); 
		} else if(theory_max_marks == '' && practical_max_marks == '') {
			total_max_marks = 0;
	    } else {
			total_max_marks = parseInt(theory_max_marks) + parseInt(practical_max_marks);
		}

		$(this).closest('.dynamic_wrapper').find('input[name="total_max_marks[]"]').val(total_max_marks);
	});

	$('#quickForm').on('focus keyup keypress blur change focusout','input[name="practical_max_marks[]"]', function(e){
		var practical_max_marks = $(this).val();
		var theory_max_marks = $(this).closest('.dynamic_wrapper').find('input[name="theory_max_marks[]"]').val();

		var total_max_marks = 0;
		if(practical_max_marks != '' && theory_max_marks == ''){
			total_max_marks = parseInt(practical_max_marks);
		} else if(practical_max_marks == '' && theory_max_marks != ''){
			total_max_marks = parseInt(theory_max_marks); 
		} else if(practical_max_marks == '' && theory_max_marks == '') {
			total_max_marks = 0;
	    } else {
			total_max_marks = parseInt(practical_max_marks) + parseInt(theory_max_marks);
		}

		$(this).closest('.dynamic_wrapper').find('input[name="total_max_marks[]"]').val(total_max_marks);
	});

	$('#quickForm').on('focus keyup keypress blur change focusout','input[name="theory_obt_marks[]"]', function(e){
		var theory_obt_marks = $(this).val();
		var practical_obt_marks = $(this).closest('.dynamic_wrapper').find('input[name="practical_obt_marks[]"]').val();
		var total_obt_marks = 0;
		if(theory_obt_marks != '' && practical_obt_marks == ''){
			total_obt_marks = parseInt(theory_obt_marks);
		} else if(theory_obt_marks == '' && practical_obt_marks != ''){
			total_obt_marks = parseInt(practical_obt_marks); 
		} else if(theory_obt_marks == '' && practical_obt_marks == '') {
			total_obt_marks = 0;
	    } else {
			total_obt_marks = parseInt(theory_obt_marks) + parseInt(practical_obt_marks);
		}

		$(this).closest('.dynamic_wrapper').find('input[name="total_obt_marks[]"]').val(total_obt_marks);
	});

	$('#quickForm').on('focus keyup keypress blur change focusout','input[name="practical_obt_marks[]"]', function(e){
		var practical_max_marks = $(this).val();
		var theory_obt_marks = $(this).closest('.dynamic_wrapper').find('input[name="theory_obt_marks[]"]').val();
		var total_obt_marks = 0;
		if(practical_max_marks != '' && theory_obt_marks == ''){
			total_obt_marks = parseInt(practical_max_marks);
		} else if(practical_max_marks == '' && theory_obt_marks != ''){
			total_obt_marks = parseInt(theory_obt_marks); 
		} else if(practical_max_marks == '' && theory_obt_marks == '') {
			total_obt_marks = 0;
	    } else {
			total_obt_marks = parseInt(practical_max_marks) + parseInt(theory_obt_marks);
		}

		$(this).closest('.dynamic_wrapper').find('input[name="total_obt_marks[]"]').val(total_obt_marks);
	});

	var isAfterTotalMarks = function(totalMarks, obtainedMarks) {
      var obtMarks = parseFloat(obtainedMarks);
      var totMarks = parseFloat(totalMarks);

      if(totMarks < obtMarks) {
          return false;
      } else {
      	return true;
      }
  	};

  	var isGreaterThan1 = function(element, value, haspractical) {
      if(haspractical==1){
      	if(parseInt(value)<=0){
      		return false;
      	} else {
      		return true;
      	}
      }

      return true;
    };

    var checkEnabledAndGreaterThan1 = function(element, value) {
    	var is_readonly = $(element).prop('readonly');
    	if(is_readonly) {
    		return true;
    	} else {
    		if(parseInt(value)<=0) {
	    		return false;
	    	} else {
	    		return true;
	    	}
    	}
    }

    jQuery.validator.addMethod("checkEnabledAndGreaterThan1", function(value, element) {
        return checkEnabledAndGreaterThan1(element, value);
    }, "Please enter a value greater than or equal to 1.");

	jQuery.validator.addMethod("isGreaterThan1", function(value, element) {
		var haspractical = parseInt($(element).closest('.dynamic_wrapper').find('select').find('option:selected').data('haspractical'));
        return isGreaterThan1(element, value, haspractical);
    }, "Please enter a value greater than or equal to 1.");

	jQuery.validator.addMethod("isAfterTheoryMaxMarks", function(value, element) {

        return isAfterTotalMarks($(element).closest('.dynamic_wrapper').find('input[name="theory_max_marks[]"]').val(), value);
    }, "Obtained marks cannot be greater than total marks.");

    jQuery.validator.addMethod("isAfterPracticalMaxMarks", function(value, element) {

        return isAfterTotalMarks($(element).closest('.dynamic_wrapper').find('input[name="practical_max_marks[]"]').val(), value);
    }, "Obtained marks cannot be greater than total marks.");

    jQuery.validator.addMethod("requireByAbsence", function(value, element) {

        return requireByAbsence($(element).closest('.dynamic_wrapper').find('input[name="is_absent[]"]').is(':checked'), value);
    }, "This field is required.");

	var $validator = $("#quickForm").validate({
		  rules: {
		  	semester_id: {
		  		required: true
		  	},
		  	"subject_id[]": {
		      required:true
		    },
		    "sheet_no[]": {
		      required:true,
		      integer:true
		    },
		    "theory_max_marks[]": {
		      required:true,
		      checkEnabledAndGreaterThan1:true,
		      integer:true
		    },
		    "theory_obt_marks[]": {
		      required:true,
		      isAfterTheoryMaxMarks:true,
		      integer:true
		    },
		    "practical_max_marks[]": {
		      required:true,
		      checkEnabledAndGreaterThan1:true,
		      integer:true
		    },
		    "practical_obt_marks[]": {
		      required:true,
		      isAfterPracticalMaxMarks:true,
		      integer:true
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

	$(document).ready(function(){
		$('#save_button').removeAttr('disabled');
	});
</script>
@endpush