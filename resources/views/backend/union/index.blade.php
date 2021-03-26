@extends('backend.layouts.master')
@section('title','Unions')

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
	  <hr>
		<center>
			<div class="heading">
				<h4>All the Union details are here</h4>
			</div>
		</center>
		<table id="dataTable"  class="table">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">Name</th>
		      <th scope="col">Name in Bangla</th>
		      <th scope="col">Upazila</th>
		      <th scope="col">District</th>
		      <th scope="col">Division</th>
		      <th scope="col">Longitude</th>
			  <th scope="col">Lattitude</th>
              <th scope="col">Companies</th>
		      <th scope="col">Customers</th>
			  <th scope="col"></th>
		      <th scope="col">Edit</th>
		      <th scope="col">Action</th>
		    </tr>
		  </thead>
		  <tbody>

		   @foreach(App\Models\Union::latest()->get() as $union)
		    <tr>
		      <th scope="row">{{$loop->index+1}}</th>
		      <td style="cursor: pointer;" onclick="window.location.href='{{route('admin.union.show',$union->id)}}'">{{$union->name}}</td>
			  <td style="cursor: pointer;" onclick="window.location.href='{{route('admin.union.show',$union->id)}}'">{{$union->bn_name}}</td>
			  @if(!is_null($union->upazilla))
				<td style="cursor: pointer;" onclick="window.location.href='{{route('admin.upazilla.show',$union->upazilla->id)}}'">{{$union->upazilla->name}}</td>
				@if(!is_null($union->upazilla->district))
					<td style="cursor: pointer;" onclick="window.location.href='{{route('admin.district.show',$union->upazilla->district->id)}}'">{{$union->upazilla->district->name}}</td>
					@if(!is_null($union->upazilla->district->division))
						<td style="cursor: pointer;" onclick="window.location.href='{{route('admin.division.show',$union->upazilla->district->division->id)}}'">{{$union->upazilla->district->division->name}}</td>
					@else
						<td></td>
					@endif
				@else
					<td></td>
					<td></td>
				@endif
			  @else
				<td></td>
				<td></td>
				<td></td>
			  @endif
			  <td>{{$union->longitude}}</td>
			  <td>{{$union->latitude}}</td>
              <td class="text-center">{{$union->companies ? count($union->companies) : 0}}</td>
			  <td class="text-center">{{$union->customers ? count($union->customers) : 0}}</td>
			  <td></td>
			  <td><a href="{{route('admin.union.update',$union->id)}}">Edit</a></td>
			  <td><a class="delete" data-confirm="Are you sure to delete this item?"
				  href="{{route('admin.union.delete',$union->id)}}">Delete</a></td>
			</tr>
			@endforeach
		  </tbody>
		</table>
		{{-- {!! App\Models\Union::unions()->render() !!} --}}
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
