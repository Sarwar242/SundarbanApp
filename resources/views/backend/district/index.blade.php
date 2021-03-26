@extends('backend.layouts.master')
@section('title','Districts')

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
				<h4>All your Districts details are here</h4>
			</div>
		</center>
		<table id="dataTable" class="table">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">Name</th>
		      <th scope="col">Name in Bangla</th>
		      <th scope="col">Division</th>
		      <th scope="col">Website</th>
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
			@foreach(App\Models\District::latest()->get() as $district)
		    <tr>
		      <th scope="row">{{$loop->index+1}}</th>
			  <td  style="cursor: pointer;" onclick="window.location.href='{{route('admin.district.show',$district->id)}}'">{{$district->name}}</td>
			  <td  style="cursor: pointer;" onclick="window.location.href='{{route('admin.district.show',$district->id)}}'">{{$district->bn_name}}</td>
			  @if(!is_null($district->division))
			  	<td style="cursor: pointer;" onclick="window.location.href='{{route('admin.division.show',$district->division->id)}}'">{{$district->division->name}}</td>
			  @else
			  	<td>N/A</td>
			  @endif
			  <td>{{$district->website}}</td>
			  <td>{{$district->longitude}}</td>
			  <td>{{$district->latitude}}</td>
              <td class="text-center">{{$district->companies ? count($district->companies) : 0}}</td>
			  <td class="text-center">{{$district->customers ? count($district->customers) : 0}}</td>
			  <td></td>
		      <td><a href="{{route('admin.district.update',$district->id)}}">Edit</a></td>
			  <td><a class="delete" data-confirm="Are you sure to delete this item?"
				  href="{{route('admin.district.delete',$district->id)}}">Delete</a></td>
			</tr>
			@endforeach
		  </tbody>
		</table>
		{{-- {!! App\Models\District::districts()->render() !!} --}}
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
