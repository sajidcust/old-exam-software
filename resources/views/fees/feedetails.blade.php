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
                  <a href="{{ url('admin/fees/downloadcompletefeereport/'.$session_id) }}" class="btn btn-info custom-pull-right"><span class="fa fa-plus-square"></span>&nbsp;&nbsp;Generate for Complete Session</a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div id="buttons_container">
                  <table id="manageDatatable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Center</th>
                      <th>Tehsil</th>
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

    $(document).ready(function() {
        $('#manageDatatable').DataTable({
          dom: 'Bfrltip',
          "lengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
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
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              url: "{{ route('fees.generatefeedetailsbyinstitutions') }}",
              data: { 
                session_id: '{{ $session_id }}'
              },
              type:"POST"
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
                data: 'tehsil_name',
                name: 'tehsil_name'
              },
              {
                data: 'action',
                name: 'action',
                orderable:false
              }
            ],
        });
    });

  ///---------------------------------------------------------------------


  $('.select2').select2({
      theme: 'bootstrap4'
  }).change(function(){
      $('#quickForm_genbulk').valid();
  });

</script>

@endpush