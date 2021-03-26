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
              <th scope="col">Companies</th>
		      <th scope="col">Customers</th>
			  {{-- <th scope="col"></th> --}}
		      <th scope="col">Edit</th>
		      <th scope="col">Delete</th>
		    </tr>
		  </thead>
		  <tbody>
			@foreach(App\Models\Division::latest()->get() as $division)
		    <tr>
		      <th scope="row" class="text-center">{{$loop->index+1}}</th>
			  <td class="text-center" style="cursor: pointer;" onclick="window.location.href='{{route('admin.division.show',$division->id)}}'">{{$division->name}}</td>
			  <td class="text-center" style="cursor: pointer;" onclick="window.location.href='{{route('admin.division.show',$division->id)}}'">{{$division->bn_name}}</td>
			  <td class="text-center">{{$division->longitude}}</td>
			  <td class="text-center">{{$division->latitude}}</td>
			  <td class="text-center">{{$division->companies ? count($division->companies) : 0}}</td>
			  <td class="text-center">{{$division->customers ? count($division->customers) : 0}}</td>
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
