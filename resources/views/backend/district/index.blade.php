@extends('backend.layouts.master')
@section('title','Districts')

@section('contents')
@include('backend.layouts.sidebar')
	<div class="content">
		<center>
			<div class="heading">
				<h4>All your Districts details are here</h4>
			</div>
		</center>
		<table class="table">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">Name</th>
		      <th scope="col">Name in Bangla</th>
		      <th scope="col">Division</th>
		      <th scope="col">Website</th>
		      <th scope="col">Longitude</th>
		      <th scope="col">Lattitude</th>
		      <th scope="col" colspan="2">Edit</th>
		    </tr>
		  </thead>
		  <tbody>
			@foreach(App\Models\District::districts() as $district)
		    <tr>
		      <th scope="row">{{$loop->index+1}}</th>
			  <td>{{$district->name}}</td>
			  <td>{{$district->bn_name}}</td>
			  <td>{{$district->division->name}}</td>
			  <td>{{$district->website}}</td>
			  <td>{{$district->longitude}}</td>
			  <td>{{$district->latitude}}</td>
		      <td><a href="#">Edit</a></td>
		      <td><a href="#">Delete</a></td>
			</tr>
			@endforeach
		  </tbody>
		</table>
		{!! App\Models\District::districts()->render() !!}
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