@extends('backend.layouts.master')
@section('title','Unions')

@section('contents')
@include('backend.layouts.sidebar')

	<div class="content">
		<center>
			<div class="heading">
				<h4>All your Union details are here</h4>
			</div>
		</center>
		<table class="table">
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
		      <th scope="col" colspan="2">Edit</th>
		    </tr>
		  </thead>
		  <tbody>

		   @foreach(App\Models\Union::unions() as $union)
		    <tr>
		      <th scope="row">{{$loop->index+1}}</th>
		      <td>{{$union->name}}</td>
			  <td>{{$union->bn_name}}</td>
			  @if(!is_null($union->upazilla))
				<td>{{$union->upazilla->name}}</td>
				<td>{{$union->upazilla->district->name}}</td>
				<td>{{$union->upazilla->district->division->name}}</td>
			  @endif
			  <td>{{$union->longitude}}</td>
			  <td>{{$union->latitude}}</td>
		      <td><a href="#">Edit</a></td>
		      <td><a href="#">Delete</a></td>
			</tr>
			@endforeach
		  </tbody>
		</table>
		{!! App\Models\Union::unions()->render() !!}
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