@extends('backend.layouts.master')
@section('title','Divisions')

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
				<h4>All your Divisions details are here</h4>
			</div>
		</center>
		<table id="dataTable" class="table">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">Name</th>
		      <th scope="col">Name in Bangla</th>
		      <th scope="col">Longitude</th>
			  <th scope="col">Lattitude</th>
			  <th scope="col"></th>
		      <th scope="col">Edit</th>
		      <th scope="col">Delete</th>
		    </tr>
		  </thead>
		  <tbody>
			@foreach(App\Models\Division::latest()->get() as $division)
		    <tr>
		      <th scope="row">{{$loop->index+1}}</th>
			  <td>{{$division->name}}</td>
			  <td>{{$division->bn_name}}</td>
			  <td>{{$division->longitude}}</td>
			  <td>{{$division->latitude}}</td>
			  <td></td>
			  <td><a href="{{route('admin.division.update',$division->id)}}">Edit</a></td>
			  <td><a class="delete" data-confirm="Are you sure to delete this item?" 
				  href="{{route('admin.division.delete',$division->id)}}">Delete</a></td>
			</tr>
			@endforeach
		  </tbody>
		</table>
		{{-- {!! App\Models\Division::divisions()->render() !!} --}}
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