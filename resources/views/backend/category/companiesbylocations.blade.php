
@extends('backend.layouts.master')

@section('title','Companies in Category by Locations')
@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jq-3.3.1/dt-1.10.24/b-1.7.0/datatables.min.css"/>
@endsection
@section('contents')

@include('backend.layouts.sidebar')
	<div class="content">
		@if(Session::has('success'))

            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">
                    x
                </button>
                <strong>
                    {!! session('success') !!}
                </strong>
            </div>
          @endif
          @if(Session::has('failed'))

            <div class="alert alert-error alert-block">
                <button type="button" class="close" data-dismiss="alert">
                    x
                </button>
                <strong>
                    {!! session('failed') !!}
                </strong>
            </div>

		  @endif

<br>
		<center>
			<div class="heading">
				<h4 class="jumbotron jumbotron-fluid py-3"><strong>{{$data->name}}</strong>(Category) </h3>
			</div>
		</center>

		<table id="dataTableDiv" class="table">
		  <thead class="thead-dark">
		    <tr>
		      {{-- <th scope="col">#</th> --}}
		      <th scope="col">Division</th>
		      <th scope="col">Companies</th>
              <th></th>
              <th></th>
              <th></th>
		    </tr>
		  </thead>
		  <tbody>
			@foreach(App\Models\Division::orderBy('name', 'asc')->get() as $division)
				<tr>
					{{-- <th scope="row">{{$loop->index+1}}</th> --}}
			    	<td>{{$division->name}}</td>
					<td>{{$division->companies->where('category_id',$data->id)->count()}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
				</tr>
			@endforeach
		  </tbody>
		</table>
        <br>
		<hr>
        <br>
		<center>
			<div class="heading">
				<h4>  </h3>
			</div>
		</center>

		<table id="dataTableDist" class="table table-bordered dt-responsive nowrap">
            <thead class="thead-dark">
                <tr>

                  <th scope="col">District</th>
                  <th scope="col">Division</th>
                  <th scope="col">Companies</th>
                </tr>
              </thead>
		  <tbody>

		  </tbody>
		</table>


		<hr>
		<center>
			<div class="heading">
				<h4><br></h3>
			</div>
		</center>
		<table id="dataTableUp" class="table">
            <thead class="thead-dark">
                <tr>

                  <th scope="col">Upazilla</th>
                  <th scope="col">District</th>
                  <th scope="col">Division</th>
                  <th scope="col">Companies</th>
                </tr>
              </thead>
		  <tbody>

		  </tbody>
		</table>



		<hr>
		<center>
			<div class="heading">
				<h4><br></h3>
			</div>
		</center>
		<table id="dataTableUn" class="table">
            <thead class="thead-dark">
                <tr>

                  <th scope="col">Union</th>
                  <th scope="col">Upazilla</th>
                  <th scope="col">District</th>
                  <th scope="col">Division</th>
                  <th scope="col">Companies</th>
                </tr>
              </thead>
		  <tbody>

		  </tbody>
		</table>

<br><br><br><hr><br><br>


	</div>


    <script src="{{ asset('js/backend/jquery.min.js')}}"></script>
	<script>
		var deleteLinks = document.querySelectorAll('.delete');

		for (var i = 0; i < deleteLinks.length; i++) {
			deleteLinks[i].addEventListener('click', function(event) {
				event.preventDefault();

				var choice = confirm(this.getAttribute('data-confirm'));

				if (choice) {
					window.location.href = this.getAttribute('href');
				}
			});
		}
		</script>

	@endsection
@section('scripts')

<script type="text/javascript">
	$(document).ready(function() {
		$('#dataTableDiv').DataTable({
			responsive: true,
			'aoColumnDefs': [{
                'bSortable': false,
                'aTargets': [-1,-2, -3]
            }]
		});
	});
</script>


<script>
    $(document).ready(function() {
    let datatable = $('#dataTableDist').DataTable({
       language: {
           "sEmptyTable": "No data available in table",
           "sInfo": "{{ __('Showing') }} _START_ {{ __('to') }} _END_ {{ __('of') }} _TOTAL_ {{ __('entries') }}",
           "sInfoEmpty": "{{ __('Showing') }} 0 to 0 of 0 {{ __('entries') }}",
           "sInfoFiltered": "(filtered from _MAX_ total entries)",
           "sInfoPostFix": "",
           "sInfoThousands": ",",
           "sLengthMenu": "_MENU_",
           "sLoadingRecords": "Loading...",
           "sProcessing": "Loading...",
           "searchPlaceholder": "{{ __('Search') }}..",
           "search": "",
           "sZeroRecords": "No matching records found",
           "oPaginate": {
               "sFirst": "First",
               "sLast": "Last",
               "sNext": "{{ __('Next') }}",
               "sPrevious": "{{ __('Previous') }}"
           },
           "oAria": {
               "sSortAscending": ": activate to sort column ascending",
               "sSortDescending": ": activate to sort column descending"
           },

       },
       serverSide: true,
       processing: true,
       ajax: {
           url: "{{route('admin.api.dist.get',$data->id)}}",
           type: 'GET'
       },
       autoWidth: false,
       buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'],
       lengthMenu: [
           [10, 20, 50],
           [10, 20, 50]
       ],
       columns: [

           {
               data: 'district',
               searchable: true,
               sortable: true
           },
           {
               data: 'division',
               searchable: true,
               sortable: true
           }
           ,
           {
               data: 'companies',
               searchable: true,
               sortable: false
           }
       ],
       responsive: true,
       drawCallback: () => {
           $('[data-toggle="tooltip"]').tooltip();
       },
       dom: "<'row'<'col-sm-12 col-md-6'<'row'<'col-auto'B><'col-auto'l>>><'col-sm-12 col-md-6'f>>" +
           "<'table-responsive table-custom-container my-3'tr>" +
           "<'row'<'col-sm-12 col-md-5 text-muted'i><'col-sm-12 col-md-7'p>>"
   });


   let datatable2 = $('#dataTableUp').DataTable({
       language: {
           "sEmptyTable": "No data available in table",
           "sInfo": "{{ __('Showing') }} _START_ {{ __('to') }} _END_ {{ __('of') }} _TOTAL_ {{ __('entries') }}",
           "sInfoEmpty": "{{ __('Showing') }} 0 to 0 of 0 {{ __('entries') }}",
           "sInfoFiltered": "(filtered from _MAX_ total entries)",
           "sInfoPostFix": "",
           "sInfoThousands": ",",
           "sLengthMenu": "_MENU_",
           "sLoadingRecords": "Loading...",
           "sProcessing": "Loading...",
           "searchPlaceholder": "{{ __('Search') }}..",
           "search": "",
           "sZeroRecords": "No matching records found",
           "oPaginate": {
               "sFirst": "First",
               "sLast": "Last",
               "sNext": "{{ __('Next') }}",
               "sPrevious": "{{ __('Previous') }}"
           },
           "oAria": {
               "sSortAscending": ": activate to sort column ascending",
               "sSortDescending": ": activate to sort column descending"
           },

       },
       serverSide: true,
       processing: true,
       ajax: {
           url: "{{route('admin.api.upz.get',$data->id)}}",
           type: 'GET'
       },
       autoWidth: false,
       buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'],
       lengthMenu: [
           [10, 20, 50],
           [10, 20, 50]
       ],
       columns: [
        //    {
        //        data: 'id',
        //        searchable: false,
        //        sortable: false
        //    },
           {
               data: 'upazilla',
               searchable: true,
               sortable: true
           },
           {
               data: 'district',
               searchable: true,
               sortable: true
           },
           {
               data: 'division',
               searchable: true,
               sortable: true
           }
           ,
           {
               data: 'companies',
               searchable: true,
               sortable: false
           }
       ],
       responsive: true,
       drawCallback: () => {
           $('[data-toggle="tooltip"]').tooltip();
       },
       dom: "<'row'<'col-sm-12 col-md-6'<'row'<'col-auto'B><'col-auto'l>>><'col-sm-12 col-md-6'f>>" +
           "<'table-responsive table-custom-container my-3'tr>" +
           "<'row'<'col-sm-12 col-md-5 text-muted'i><'col-sm-12 col-md-7'p>>"
   });

   let datatable3 = $('#dataTableUn').DataTable({
       language: {
           "sEmptyTable": "No data available in table",
           "sInfo": "{{ __('Showing') }} _START_ {{ __('to') }} _END_ {{ __('of') }} _TOTAL_ {{ __('entries') }}",
           "sInfoEmpty": "{{ __('Showing') }} 0 to 0 of 0 {{ __('entries') }}",
           "sInfoFiltered": "(filtered from _MAX_ total entries)",
           "sInfoPostFix": "",
           "sInfoThousands": ",",
           "sLengthMenu": "_MENU_",
           "sLoadingRecords": "Loading...",
           "sProcessing": "Loading...",
           "searchPlaceholder": "{{ __('Search') }}..",
           "search": "",
           "sZeroRecords": "No matching records found",
           "oPaginate": {
               "sFirst": "First",
               "sLast": "Last",
               "sNext": "{{ __('Next') }}",
               "sPrevious": "{{ __('Previous') }}"
           },
           "oAria": {
               "sSortAscending": ": activate to sort column ascending",
               "sSortDescending": ": activate to sort column descending"
           },

       },
       serverSide: true,
       processing: true,
       ajax: {
           url: "{{route('admin.api.unn.get',$data->id)}}",
           type: 'GET'
       },
       autoWidth: false,
       buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'],
       lengthMenu: [
           [10, 20, 50],
           [10, 20, 50]
       ],
       columns: [

           {
               data: 'union',
               searchable: true,
               sortable: true
           },
           {
               data: 'upazilla',
               searchable: true,
               sortable: true
           },
           {
               data: 'district',
               searchable: true,
               sortable: true
           },
           {
               data: 'division',
               searchable: true,
               sortable: true
           }
           ,
           {
               data: 'companies',
               searchable: true,
               sortable: false
           }
       ],
       responsive: true,
       drawCallback: () => {
           $('[data-toggle="tooltip"]').tooltip();
       },
       dom: "<'row'<'col-sm-12 col-md-6'<'row'<'col-auto'B><'col-auto'l>>><'col-sm-12 col-md-6'f>>" +
           "<'table-responsive table-custom-container my-3'tr>" +
           "<'row'<'col-sm-12 col-md-5 text-muted'i><'col-sm-12 col-md-7'p>>"
   });
});
</script>
@endsection
