@extends('backend.layouts.master')
@section('title','Units')

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
				<h4>All your Unit details are here</h4>
			</div>
		</center>
		<table class="table">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">Name</th>
		      <th scope="col">Name in Bangla</th>
		      <th scope="col" colspan="2">Edit</th>
		    </tr>
		  </thead>
		  <tbody>
			  @foreach(App\Models\Unit::units() as $unit)
				<tr>
					<th scope="row">{{$loop->index+1}}</th>
					<td>{{$unit->name}}</td>
					<td>{{$unit->bn_name}}</td>
					<td><a href="{{route('admin.unit.update',$unit->id)}}">Edit</a></td>
					<td><a class="delete" data-confirm="Are you sure to delete this item?" 
						href="{{route('admin.unit.delete',$unit->id)}}">Delete</a></td>
				</tr>
				@endforeach
		  </tbody>
		</table>
		{!! App\Models\Unit::units()->render() !!}
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