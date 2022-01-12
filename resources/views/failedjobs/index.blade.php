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
          <div class="col-12">
            <!-- /.card -->

            <div class="card">
              <div class="card-header row">
              	<div class="col-lg-6">
                	<h3 class="card-title custom-card-title">{{ $card_title }}</h3>
              	</div>
              	<div class="col-lg-6">
              		<button id="reset_btn" class="btn btn-danger custom-pull-right margin-left-right-5px"><span class="fa fa-trash"></span>&nbsp;&nbsp;Delete All</button>
              	</div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              	<div id="buttons_container">
	                <table id="manageDatatable" class="table table-bordered table-striped">
	                	<thead>
	                  <tr>
	                    <th>ID</th>
	                    <th>Process ID</th>
	                    <th>Error</th>
	                    <th>Queue</th>
	                    <th>Failed At</th>
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
    $('body').on('click', '#reset_btn', function (){
      url = "{{ route('failedjobs.destroyall') }}";

      $.confirm({
          title: 'Are you sure?',
          content: 'Simple confirm!',
          buttons: {
              yes: {
                  text: 'Yes',
                  btnClass: 'btn-red',
                  keys: ['enter', 'shift'],
                  action: function(){
                      Pace.track(function(){
                        $.ajax({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                          type: "POST",
                          url: url,
                          beforeSend: function()
                          {
                            Pace.start();
                          },
                          complete: function() {
                            Pace.stop();
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

	$(document).ready(function(){
		$('body').on('click', '#dlt_button', function (){
			id = $(this).data('failedjobid');
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
	                title: 'Directorate Of Education MIS System (CSV-Format)',
	                exportOptions: {
	                    columns: ':visible'
	                }
	            },
	            {
	                extend: 'excelHtml5',
	                title: 'Directorate Of Education MIS System, (Excel-Format)',
	                exportOptions: {
	                    columns: ':visible'
	                }
	            },
	            {
	                extend: 'pdfHtml5',
	                title: 'Directorate Of Education MIS System, (PDF-Format)',
	                exportOptions: {
	                    columns: ':visible'
	                },
	                orientation: 'portrait',
                	pageSize: 'A4',
                	download: 'open'
	            },
	            {
	                extend: 'print',
	                title: 'Directorate Of Education MIS System, (Print-Format)',
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
              url: "{{ route('failedjobs.index') }}",
            },
            columns:[
              {
                data: 'id',
                name: 'id'
              },
              {
                data: 'uuid',
                name: 'uuid'
              },
              {
                data: 'exception',
                name: 'exception'
              },
              {
                data: 'queue',
                name: 'queue'
              },
              {
                data: 'failed_at',
                name: 'failed_at'
              },
              {
                data: 'action',
                name: 'action',
                orderable:false
              }
            ]
        });
    });

</script>

@endpush