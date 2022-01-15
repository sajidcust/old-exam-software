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
              <form id="quickForm" method="post" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input id="hidden_identifier" type="hidden" value="{{ $setting->id }}" name="setting_id">
                <input type="hidden" value="1" name="is_edit">
                <div class="card-body">
                   <div class="form-group">
                      <label for="labelInputBoardFullName">Board Full Name<i class="fa fa-star-of-life required-label"></i></i></label>
                      <input type="text" name="board_full_name" class="form-control" id="labelInputBoardFullName" placeholder="Enter board full name" value="{{ Request::old('board_full_name')!='' ? Request::old('board_full_name'):$setting->board_full_name }}">
                   </div>
                   <div class="form-group">
                      <label for="labelInputMinisterName">Minister's Name<i class="fa fa-star-of-life required-label"></i></i></label>
                      <input type="text" name="minister_name" class="form-control" id="labelInputMinisterName" placeholder="Enter minister name" value="{{ Request::old('minister_name') != '' ? Request::old('minister_name') : $setting->minister_name }}">
                   </div>
                   <div class="form-group">
                      <label for="exampleInputFileMinisterImage">Upload Minister's Photo<i class="fa fa-star-of-life required-label"></i></label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input exampleInputFile" id="exampleInputFileMinisterImage" name="minister_image" accept="image/*">
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                      </div> 
                    </div>
                    <div class="form-group">
                      <label for="labelInputCriteria">Mininster's Message<i class="fa fa-star-of-life required-label"></i></label>
                      <textarea id="summernote" name="ministers_message" class="summernote form-control" placeholder="Ministers message here.">{{ Request::old('ministers_message')!='' ? Request::old('ministers_message'):$setting->ministers_message }}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="labelInputSecretaryName">Secretary's Name<i class="fa fa-star-of-life required-label"></i></i></label>
                      <input type="text" name="secretary_name" class="form-control" id="labelInputSecretaryName" placeholder="Enter secretary name" value="{{ Request::old('secretary_name') != '' ? Request::old('secretary_name') : $setting->secretary_name }}">
                   </div>
                   <div class="form-group">
                      <label for="exampleInputFileSecretaryImage">Upload Secretary's Photo<i class="fa fa-star-of-life required-label"></i></label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input exampleInputFile" id="exampleInputFileSecretaryImage" name="secretary_image" accept="image/*">
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                      </div> 
                    </div>
                    <div class="form-group">
                      <label for="labelInputSecretaryMessage">Secretary's Message<i class="fa fa-star-of-life required-label"></i></label>
                      <textarea id="summernote" name="secretarys_message" class="summernote form-control" placeholder="Secretarys message here.">{{ Request::old('secretarys_message')!='' ? Request::old('secretarys_message'):$setting->secretarys_message }}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="labelInputControllerName">Controller's Name<i class="fa fa-star-of-life required-label"></i></i></label>
                      <input type="text" name="controller_name" class="form-control" id="labelInputControllerName" placeholder="Enter controller name" value="{{ Request::old('controller_name') != '' ? Request::old('controller_name') : $setting->controller_name }}">
                   </div>
                   <div class="form-group">
                      <label for="exampleInputFileControllerImage">Upload Controller's Photo<i class="fa fa-star-of-life required-label"></i></label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input exampleInputFile" id="exampleInputFileControllerImage" name="controller_image" accept="image/*">
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                      </div> 
                    </div>
                    <div class="form-group">
                      <label for="labelInputCriteria">Controller's Message<i class="fa fa-star-of-life required-label"></i></label>
                      <textarea id="summernote" name="controllers_message" class="summernote form-control" placeholder="Controllers message here.">{{ Request::old('controllers_message')!='' ? Request::old('controllers_message'):$setting->controllers_message }}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="labelInputDeputyControllerName">Deputy Controller's Name<i class="fa fa-star-of-life required-label"></i></i></label>
                      <input type="text" name="deputy_controller_name" class="form-control" id="labelInputDeputyControllerName" placeholder="Enter deputy controllers name" value="{{ Request::old('deputy_controller_name') != '' ? Request::old('deputy_controller_name') : $setting->deputy_controller_name }}">
                   </div>
                   <div class="form-group">
                      <label for="exampleInputFileDepyteControllerSignature">Upload Deputy Controller's Signature Image<i class="fa fa-star-of-life required-label"></i></label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input exampleInputFile" id="exampleInputFileDepyteControllerSignature" name="deputy_controller_signature" accept="image/*">
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
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

  $(function () {
    bsCustomFileInput.init();
  });

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
      if ($('.exampleInputFile').get(0).files.length === 0) {
          return false;
      } else {
        return true;
      }
    }
    }, "This field is required.");

  $('#quickForm').on('change', 'input[name="date_of_birth"]', function(){
    $('#quickForm').valid();
  });

  var isLessThanMinAge = function (minimumAge, enteredAge){
      var minAge = parseInt(minimumAge);

      var backDate = new Date();
      backDate.setFullYear( backDate.getFullYear() - minAge );

      var minAgeInD = (new Date() - new Date(backDate)) / (1000 * 60 * 60 * 24);

      var minAgeInDays = Math.round(minAgeInD)+1;


      var days = (new Date() - new Date(moment(enteredAge, 'DD-MM-YYYY'))) / (1000 * 60 * 60 * 24);
      var ageInDays = Math.round(days);

      if(parseInt(ageInDays) >= minAgeInDays){
        return true;
      }
    }

    jQuery.validator.addMethod("isLessThanMinAge", function(value, element) {

        return isLessThanMinAge($('select[name="class_id"] option:selected').data('minage'), value);
    }, "You are under age for submitting your application.");



  var validatevar = $('#quickForm').validate({
      rules: {
        board_full_name: {
          required: true,
          minlength: 3
        },
        minister_name: {
          required: true,
          minlength: 3
        },
        minister_image:{
          checkImage:true,
          extension: "jpg|jpeg|png|ico|bmp"
        },
        ministers_message:{
          required:true,
          minlength:40
        },
        secretary_name: {
          required: true,
          minlength: 3
        },
        secretary_image:{
          checkImage:true,
          extension: "jpg|jpeg|png|ico|bmp"
        },
        secretarys_message:{
          required:true,
          minlength:40
        },
        controller_name: {
          required: true,
          minlength: 3
        },
        controller_image:{
          checkImage:true,
          extension: "jpg|jpeg|png|ico|bmp"
        },
        controllers_message:{
          required:true,
          minlength:40
        },
        deputy_controller_name: {
          required: true,
          minlength: 3
        },
        deputy_controller_signature:{
          checkImage:true,
          extension: "jpg|jpeg|png|ico|bmp"
        }
      },
      ignore: ":hidden:not(.summernote),.note-editable.card-block",
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

  var myElement = $('.summernote');

  myElement.summernote({
    height:200,
    toolbar: [
      ['style', ['style']],
      ['font', ['bold', 'underline', 'clear']],
      ['fontname', ['fontname']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['table', ['table']],
      ['view', ['fullscreen', 'codeview', 'help']],
    ]
  });

</script>

@endpush