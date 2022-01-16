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
              <form id="quickForm" method="post" action="{{ route('students.store') }}"enctype="multipart/form-data">
              	{{ csrf_field() }}
                
                <div class="card-body">
                    <div class="form-group">
                      <label for="labelInputSelectSession">Select Session<i class="fa fa-star-of-life required-label"></i></label>
                      <select class="custom-select rounded-0 select2" id="labelInputSelectSession" name="session_id">
                          @foreach($sessions as $session)
                              @if($session->id == Request::old('session_id'))
                                  <option data-expirydate="{{ str_replace('-', '/', $session->expiry_date) }}" selected value="{{ $session->id }}">{{ $session->title }}</option>
                              @else
                                  <option data-expirydate="{{ str_replace('-', '/', $session->expiry_date) }}" value="{{ $session->id }}">{{ $session->title }}</option>
                              @endif
                          @endforeach
                      </select>
                   </div>
                   <div class="form-group">
                      <label for="labelSelectClass">Select Class<i class="fa fa-star-of-life required-label"></i></label>
                      <select class="custom-select rounded-0" id="labelSelectClass" name="class_id"> 
                          @foreach($standards as $standard)
                            @if($standard->id == Request::old('class_id'))
                                <option data-minage="{{ $standard->min_age }}" data-minsubjects="{{ $standard->min_subjects }}" selected value="{{ $standard->id }}">{{ $standard->name }}</option>
                            @else
                                <option data-minage="{{ $standard->min_age }}" data-minsubjects="{{ $standard->min_subjects }}" value="{{ $standard->id }}">{{ $standard->name }}</option>
                            @endif
                          @endforeach
                      </select>
                   </div>
                    <div class="form-group">
                      <label for="labelInputStudentName">Student Name<i class="fa fa-star-of-life required-label"></i></i></label>
                      <input type="text" name="name" class="form-control" id="labelInputStudentName" placeholder="Enter student name" value="{{ Request::old('name') }}">
                   </div>
                   <div class="form-group">
                      <label for="labelInputFatherName">Father Name<i class="fa fa-star-of-life required-label"></i></i></label>
                      <input type="text" name="father_name" class="form-control" id="labelInputFatherName" placeholder="Enter father name" value="{{ Request::old('father_name') }}">
                   </div>
                   <div class="form-group">
                      <label>Date Of Birth<i class="fa fa-star-of-life required-label"></i></label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input id="datemask" type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask="" inputmode="numeric" name="date_of_birth" value="{{ Request::old('date_of_birth') }}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="labelInputDOBInWords">DOB (In Words)<i class="fa fa-star-of-life required-label"></i></i></label>
                      <input type="text" name="dob_in_words" class="form-control" id="labelInputDOBInWords" placeholder="Enter date of birth (in words)" value="{{ Request::old('dob_in_words') }}">
                   </div>
                   <div class="form-group">
                    <label for="labelInputGender">Gender<i class="fa fa-star-of-life required-label"></i></label>
                    <select class="custom-select rounded-0" id="labelInputGender" name="gender">
                      <option value="0" {{ Request::old('gender') == 1 ? 'selected':'' }}>Male</option>
                      <option value="1" {{ Request::old('gender') == 0 ? 'selected':'' }}>Female</option>
                    </select>
                   </div>
                   <div class="form-group">
                      <label for="labelInputHomeAddress">Home Address<i class="fa fa-star-of-life required-label"></i></i></label>
                      <input type="text" name="home_address" class="form-control" id="labelInputHomeAddress" placeholder="Enter date of birth (in words)" value="{{ Request::old('home_address') }}">
                   </div>
                   <div class="form-group">
                      <label>Cell No</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa fa-mobile-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" data-inputmask="'mask': '0399-9999999'" data-mask="" inputmode="text" name="cell_no" value="{{ Request::old('cell_no') }}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="labelInputEmail">Email</i></label>
                      <input type="text" name="email" class="form-control" id="labelInputEmail" placeholder="Enter email" value="{{ Request::old('email') }}">
                   </div>
                   <div class="form-group">
                      <label for="exampleInputFile">Upload Photo (Passport Size)<i class="fa fa-star-of-life required-label"></i></label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="exampleInputFile" name="image" accept="image/*">
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                      </div> 
                    </div>
                   <div class="form-group">
                    <label for="labelInputStudentType">Student Type<i class="fa fa-star-of-life required-label"></i></label>
                    <select class="custom-select rounded-0" id="labelInputStudentType" name="student_type">
                      <option value="1" {{ Request::old('student_type') == 1 ? 'selected':'' }}>PRIVATE</option>
                      <option value="0" {{ Request::old('student_type') == 0 ? 'selected':'' }}>REGULAR</option>
                    </select>
                   </div>
                   <div class="form-group">
                      <label for="labelSelectInstitution">Select Institution<i class="fa fa-star-of-life required-label"></i></label>
                      <select class="custom-select rounded-0 select2" id="labelSelectInstitution" name="institution_id">
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
                   <div class="form-group">
                      <label for="labelSelectCenter">Select Center<i class="fa fa-star-of-life required-label"></i></label>
                      <select class="custom-select rounded-0 select2" id="labelSelectCenter" name="center_id">
                          <option value="">Select Center</option> 
                          @foreach($institutions as $institution)
                            @if($institution->is_center == 1)
                              @if($institution->id == Request::old('center_id'))
                                  <option selected value="{{ $institution->id }}">{{ $institution->name }}</option>
                              @else
                                  <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                              @endif
                            @endif
                          @endforeach
                      </select>
                   </div>
                   <div class="form-group">
                      <label for="labelSelectSubjects">Select Subjects<i class="fa fa-star-of-life required-label"></i></label>
                      <select class="custom-select rounded-0 select2" id="labelSelectSubjects" name="subject_id[]" multiple="true">
                          @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
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
  $('select[name="class_id"]').change(function(){
    var class_id = $(this).val();

    var url = "{{ route('students.getsubjectsgroupdata') }}";

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: url,
        data: {class_id:class_id},
        beforeSend: function()
        {
          $('#modal-danger').modal('hide');
          Pace.start();
        },
        complete: function() {
          Pace.stop();
          $('#modal-danger').modal('hide');
        },
        success: function(data)
        {
          data_arr = JSON.parse(data);

          $('select[name="subject_id[]"]').select2().val(data_arr).trigger('change');
        }
    });

  });

  $(document).ready(function(){
    var class_id = $('select[name="class_id"]').val();
    var url = "{{ route('students.getsubjectsgroupdata') }}";

    $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: url,
        data: {
          class_id: class_id
        },
        beforeSend: function()
        {
          $('#modal-danger').modal('hide');
          Pace.start();
        },
        complete: function() {
          Pace.stop();
          $('#modal-danger').modal('hide');
        },
        success: function(data)
        {
          data_arr = JSON.parse(data);

          $('select[name="subject_id[]"]').select2().val(data_arr).trigger('change');
        }
    });
  });

  var ones = ['', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
  var tens = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
  var teens = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];

  function convert_millions(num) {
    if (num >= 1000000) {
      return convert_millions(Math.floor(num / 1000000)) + " million " + convert_thousands(num % 1000000);
    } else {
      return convert_thousands(num);
    }
  }

  function convert_thousands(num) {
    if (num >= 1000) {
      return convert_hundreds(Math.floor(num / 1000)) + " thousand " + convert_hundreds(num % 1000);
    } else {
      return convert_hundreds(num);
    }
  }

  function convert_hundreds(num) {
    if (num > 99) {
      return ones[Math.floor(num / 100)] + " hundred " + convert_tens(num % 100);
    } else {
      return convert_tens(num);
    }
  }

  function convert_tens(num) {
    if (num < 10) return ones[num];
    else if (num >= 10 && num < 20) return teens[num - 10];
    else {
      return tens[Math.floor(num / 10)] + " " + ones[num % 10];
    }
  }

  function convert(num) {
    if (num == 0) return "zero";
    else return convert_millions(num);
  }

  function monthName(mon) {
     return ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'][mon - 1];
  }

  $('#quickForm').on('focus keyup keypress blur change focusout','input[name="date_of_birth"]', function(e){
    var date_of_birth = $(this).val();

    var dob_spl = date_of_birth.split('-');
    var day = dob_spl[0];
    var month = dob_spl[1];
    var year = dob_spl[2];

    var day_eng = convert(parseInt(day));
    var month_eng = monthName(parseInt(month));

    switch (parseInt(day)) {
      case 1:
        day_eng = 'first';
        break;
      case 2:
        day_eng = 'second';
        break;
      case 3:
        day_eng = 'third';
        break;
      case 5:
        day_eng = 'fifth';
        break;
      case 8:
        day_eng = 'eighth';
        break;
      case 20:
        day_eng = 'twentieth';
        break;
      case 21:
        day_eng = 'twenty first';
        break;
      case 22:
        day_eng = 'twenty second';
        break;
      case 23:
        day_eng = 'twenty third';
        break;
      case 25:
        day_eng = 'twenty fifth';
        break;
      case 28:
        day_eng = 'twenty eighth';
        break;
      case 30:
        day_eng = 'thirtieth';
        break;
      case 31:
        day_eng = 'thirty first';
        break;
      default:
        day_eng = day_eng+'th';
        break;
    }

    var year_eng = convert(parseInt(year))
    $('#quickForm input[name="dob_in_words"]').val('');
    $('#quickForm input[name="dob_in_words"]').val((day_eng || "").toUpperCase()+' '+(month_eng || "").toUpperCase()+' '+(year_eng || "").toUpperCase());
  });

  $(function () {
    bsCustomFileInput.init();
  });

  $('input[name="date_of_birth"]').datepicker({
    format: 'dd-mm-yyyy'
  });

  $('[data-mask]').inputmask();

  var isGreaterThanCurrentDate = function(enteredDate) {
    var d = new Date();
    var entDate = moment(enteredDate, 'DD-MM-YYYY').toDate();
    if(d > entDate){
      return true;
    }
  };

  jQuery.validator.addMethod("isGreaterThanCurrentDate", function(value, element) {

      return isGreaterThanCurrentDate(value);
  }, "Date of birth cannot be greater than current date.");

  jQuery.validator.addMethod("checkImage", function(value, element) {
    if($("input[name='is_edit']").val() == 1) {
      return true;
    } else {
      if ($('#exampleInputFile').get(0).files.length === 0) {
          return false;
      } else {
        return true;
      }
    }
    }, "This field is required.");

  $('#quickForm').on('change', 'input[name="date_of_birth"]', function(){
    $('#quickForm').valid();
  });

  var isLessThanMinAge = function (minimumAge, enteredAge, expiry_date){
      var minAge = parseInt(minimumAge);

      var backDate = new Date(expiry_date);
      backDate.setFullYear( backDate.getFullYear() - minAge );

      var minAgeInD = (new Date(expiry_date) - new Date(backDate)) / (1000 * 60 * 60 * 24);

      var minAgeInDays = Math.round(minAgeInD)+1;


      var days = (new Date(expiry_date) - new Date(moment(enteredAge, 'DD-MM-YYYY'))) / (1000 * 60 * 60 * 24);
      var ageInDays = Math.round(days);

      if(parseInt(ageInDays) >= minAgeInDays){
        return true;
      }
    }

    jQuery.validator.addMethod("isLessThanMinAge", function(value, element, expiry_date) {

        return isLessThanMinAge($('select[name="class_id"] option:selected').data('minage'), value, $('select[name="session_id"] option:selected').data('expirydate'));
    }, "You are under age for submitting your application.");



	var validatevar = $('#quickForm').validate({
      rules: {
        name: {
          required: true,
          minlength: 3,
        },
        father_name: {
          required: true,
          minlength: 3,
        },
        date_of_birth: {
          required: true,
          isLessThanMinAge:true
        },
        dob_in_words: {
          required: true,
          minlength: 10
        },
        gender: {
          required: true
        },
        home_address: {
          minlength: 1
        },
        cell_no: {
          minlength: 12,
          maxlength: 12
        },
        email: {
          email: true
        },
        image:{
          checkImage:true,
          extension: "jpg|jpeg|png|ico|bmp"
        },
        student_type: {
          required: true
        },
        session_id: {
          required: true
        },
        class_id: {
          required: true
        },
        institution_id: {
          required: true
        },
        center_id: {
          required: true
        },
        "subject_id[]": {
          required:true,
          minlength: function(){
            var min_subs = $('select[name="class_id"] option:selected').data('minsubjects');

            if(parseInt(min_subs)){
              return min_subs;
            } else {
              return 0;
            }
          },
          maxlength: function(){
            var min_subs = $('select[name="class_id"] option:selected').data('minsubjects');

            if(parseInt(min_subs)){
              return min_subs;
            } else {
              return 0;
            }
          }
          //addMinimumLimits:true
        }
      },
      messages: {
          "subject_id[]": {
              required: 'This field is required.',
              minlength: function(){
                var s_class = $('select[name="class_id"] option:selected').data('minsubjects');
                if(parseInt(s_class)){
                  return "Please select at least "+ s_class +" items.";
                } else {
                  return "Please select any class to continue.";
                }
              },
              maxlength: function(){
                var s_class = $('select[name="class_id"] option:selected').data('minsubjects');
                if(parseInt(s_class)){
                  return "Maximum "+ s_class +" items can be selected.";
                } else {
                  return "Please select any class to continue.";
                }
              }
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