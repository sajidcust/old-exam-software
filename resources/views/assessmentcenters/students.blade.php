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

            <div class="card">
              <div class="card-header row">
              	<div class="col-lg-12">
                	<h3 class="card-title custom-card-title">{{ $card_title }}</h3>
              	</div>
              	<!-- <div class="col-lg-6">
              		<a href="{{ url('admin/students/create') }}" class="btn btn-info custom-pull-right"><span class="fa fa-plus-square"></span>&nbsp;&nbsp;New</a>
              	</div> -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              	<div id="buttons_container">
	                <table id="manageDatatable" class="table table-bordered table-striped">
	                	<thead>
	                  <tr>
	                    <th>ID</th>
	                    <th>Name</th>
	                    <th>Father Name</th>
	                    <th>DOB</th>
	                    <th>Address</th> 
	                    <th>Contact No</th> 
	                    <th>Class</th> 
	                    <th>Type</th> 
	                    <th>Session</th> 
	                    <th>Center</th> 
	                    <th style="text-align: center;">Subject, Semester, Obt Marks</th>
	                    <th style="text-align: center;">Code, Subject</th>
	                    <th>Action</th>
	                  </tr>
	                  </thead>
	                </table>
	             </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <div class="modal" id="modal-danger" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Are you sure?</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-footer">
	        <button type="button" id="yes-btn" class="btn btn-danger">Yes</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
	      </div>
	    </div>
	  </div>
	</div>

@stop


@push('scripts')
<script>
	$(document).ready(function(){
		$('body').on('click', '#dlt_button', function (){
			id = $(this).data('studentid');
			url = $(this).data('url');

			$.confirm({
			    title: 'Are you sure?',
			    content: 'Simple confirm!',
			    buttons: {
			        yes: {
			            text: 'Yes',
			            btnClass: 'btn-red',
			            keys: ['enter', 'shift'],
			            action: function(){
			                $.ajax({
					    		headers: {
								    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
								},
				                type: "POST",
				                url: url,
				                data: {id:id},

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
				                	if(data['success'] == 'true'){
				                		var oTable = $('#manageDatatable').dataTable(); 
										oTable.fnDraw(false);
										var successToast = $(document).Toasts('create', {
											class: 'bg-success',
									        title: 'Success!',
									        autohide: true,
									        delay: 2000,
									        body: data['message']
									      });
				                	} else {
				                		var errorToast = $(document).Toasts('create', {
											class: 'bg-danger',
									        title: 'Oops!',
									        autohide: true,
									        delay: 2000,
									        body: data['message']
									      });
				                	}
				                }
				            });
			            }
			        },
			        no: {
			            text: 'No',
			            btnClass: 'btn-grey',
			            keys: ['enter', 'shift'],
			            action: function(){

			            }
			        }
			    }
			});
		});
	});	

	  $(document).ready(function() {
        $('#manageDatatable').DataTable({
        	dom: 'Bfrltip',
		    buttons: [
		    	'copy',
		    	{
	                extend: 'csvHtml5',
	                title: 'Board Elementary Examination GB MIS System (CSV-Format)',
	                exportOptions: {
	                    columns: ':visible'
	                }
	            },
	            {
	                extend: 'excelHtml5',
	                title: 'Board Elementary Examination GB MIS System, (Excel-Format)',
	                exportOptions: {
	                    columns: ':visible'
	                }
	            },
	            {
	                extend: 'pdfHtml5',
	                title: 'Board Elementary Examination GB MIS System, (PDF-Format)',
	                exportOptions: {
	                    columns: ':visible'
	                },
	                orientation: 'portrait',
                	pageSize: 'A4',
                	download: 'open'
	            },
	            {
	                extend: 'print',
	                title: 'Board Elementary Examination GB MIS System, (Print-Format)',
	                exportOptions: {
	                    columns: ':visible'
	                },
	                orientation: 'portrait',
                	pageSize: 'A4'
	            },
		        'colvis'
		    ],
            processing:true,
            serverSide:true,
            ajax:{
              headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  data: {
                    session_id:"{{ $session_id }}",
                    class_id:"{{ $class_id }}",
                    center_id:"{{ $center_id }}"
                  },
                url: "{{ route('marks.index') }}",
                type:"GET"
            },
            columns:[
              {
                data: 'id',
                name: 'id'
              },
              {
                data: 'name',
                name: 'name'
              },
              {
                data: 'father_name',
                name: 'father_name',
                visible: false
              },
              {
                data: 'date_of_birth',
                name: 'date_of_birth',
                visible: false
              },
              {
                data: 'home_address',
                name: 'home_address',
                visible: false
              },
              {
                data: 'cell_no',
                name: 'cell_no',
                visible: false
              },
              {
                data: 's_class',
                name: 's_class'
              },
              {
                data: 'student_type',
                name: 'student_type'
              },
              {
                data: 'title',
                name: 'title'
              },
              {
                data: 'center_name',
                name: 'center_name'
              },
              {
                data: 'subjects',
                name: 'subjects'
              },
              {
                data: 'subs',
                name: 'subs',
                visible:false
              },
              {
                data: 'action',
                name: 'action',
                orderable:false
              }
            ],
            "columnDefs": [
	            {
	                // The `data` parameter refers to the data for the cell (defined by the
	                // `data` option, which defaults to the column being worked with, in
	                // this case `data: 0`.
	                "render": function ( data, type, row ) {
	                    //return htmlDecode(data);
	                    var doc = new DOMParser().parseFromString(data, "text/html");
							return doc.documentElement.textContent;
	                },
	                "targets": [10, 11]
	            }
	        ],
        });
    });

</script>

@endpush