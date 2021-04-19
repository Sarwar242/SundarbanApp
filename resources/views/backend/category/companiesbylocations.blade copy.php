
@extends('backend.layouts.master')

@section('title','Companies in Category by Locations')
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
		      <th scope="col">#</th>
		      <th scope="col">Division</th>
		      <th scope="col">Companies</th>
		    </tr>
		  </thead>
		  <tbody>
			@foreach(App\Models\Division::orderBy('name', 'asc')->get() as $division)
				<tr>
					<th scope="row">{{$loop->index+1}}</th>
			    	<td>{{$division->name}}</td>
					<td>{{$division->companies->where('category_id',$data->id)->count()}}</td>
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

		<table id="dataTableDist" class="table">
            <thead class="thead-dark">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">District</th>
                  <th scope="col">Division</th>
                  <th scope="col">Companies</th>
                </tr>
              </thead>
		  <tbody>
			@foreach(App\Models\District::orderBy('division_id', 'asc')->get() as $district)
				<tr>
					<th scope="row">{{$loop->index+1}}</th>
			    	<td>{{$district->name}}</td>
			    	<td>{{$district->division ? $district->division->name : ''}}</td>
					<td>{{$district->companies->where('category_id',$data->id)->count()}}</td>
				</tr>
			@endforeach
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
                  <th scope="col">#</th>
                  <th scope="col">Upazilla</th>
                  <th scope="col">District</th>
                  <th scope="col">Division</th>
                  <th scope="col">Companies</th>
                </tr>
              </thead>
		  <tbody>
			@foreach(App\Models\Upazilla::orderBy('district_id', 'asc')->get() as $upazilla)
				<tr>
					<th scope="row">{{$loop->index+1}}</th>
			    	<td>{{$upazilla->name}}</td>
			    	<td>{{ $upazilla->district ? $upazilla->district->name : ''}}</td>
			    	<td>{{ $upazilla->district && $upazilla->district->division ? $upazilla->district->division->name : ''}}</td>
					<td>{{count($upazilla->companies->where('category_id',$data->id))}}</td>
				</tr>
			@endforeach
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
                  <th scope="col">#</th>
                  <th scope="col">Union</th>
                  <th scope="col">Upazilla</th>
                  <th scope="col">District</th>
                  <th scope="col">Division</th>
                  <th scope="col">Companies</th>
                </tr>
              </thead>
		  <tbody>
			@foreach(App\Models\Union::orderBy('upazilla_id', 'asc')->get() as $union)
				<tr>
					<th scope="row">{{$loop->index+1}}</th>
			    	<td>{{$union->name}}</td>
			    	<td>{{ $union->upazilla ? $union->upazilla->name : ''}}</td>
			    	<td>{{ $union->upazilla && $union->upazilla->district  ? $union->upazilla->district->name : ''}}</td>
			    	<td>{{$union->upazilla && $union->upazilla->district && $union->upazilla->district->division ? $union->upazilla->district->division->name : ''}}</td>
					<td>{{$union->companies->where('category_id',$data->id)->count()}}</td>
				</tr>
			@endforeach
		  </tbody>
		</table>




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
{{-- <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js" integrity="sha512-CEiA+78TpP9KAIPzqBvxUv8hy41jyI3f2uHi7DGp/Y/Ka973qgSdybNegWFciqh6GrN2UePx2KkflnQUbUhNIA==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js" integrity="sha512-d8F1J2kyiRowBB/8/pAWsqUl0wSEOkG5KATkVV4slfblq9VRQ6MyDZVxWl2tWd+mPhuCbpTB4M7uU/x9FlgQ9Q==" crossorigin="anonymous"></script>
<script>
    $('.counter').counterUp({
    delay: 10,
    time: 1500
});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#dataTableDiv').DataTable({
			responsive: true,
			'aoColumnDefs': [{
                'bSortable': false,
            }]
		});


        $('#dataTableDist').DataTable({
			responsive: true,
			'aoColumnDefs': [{
                'bSortable': false,
            }]
		});

        $('#dataTableUp').DataTable({
			responsive: true,
			'aoColumnDefs': [{
                'bSortable': false,
            }]
		});

        $('#dataTableUn').DataTable({
			responsive: true,
			'aoColumnDefs': [{
                'bSortable': false,
            }]
		});
	});
</script>

@endsection
