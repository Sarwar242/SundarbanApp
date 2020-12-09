@extends('backend.layouts.master')
@section('title','Notices')

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
				<h4>All your Notice are here</h4>
			</div>
		</center>
		<table id="dataTable"  class="table">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">Title</th>
			  <th scope="col">Description</th>
			  <th scope="col">Type</th>
			  <th scope="col">For</th>
              <th scope="col">Recipiant</th>
              <th scope="col">By</th>

		      <th scope="col">View</th>
		      <th scope="col">Action</th>
		    </tr>
		  </thead>
		  <tbody>
			  @foreach(App\Models\Notice::latest()->get() as $notice)
				<tr>
					<th scope="row">{{$loop->index+1}}</th>
					<td>{{substr($notice->title, 0, 40)}}</td>
					<td>{{substr($notice->description, 0, 80)}}</td>
                    <td>{{$notice->type}}</td>
                    <td>{{$notice->for}}</td>
                    @if($notice->for=="Customer")
                        <td>{{App\Models\Customer::find($notice->user_id)->username}}</td>
                    @elseif($notice->for=="Admin")
                        <td>{{App\Models\Admin::find($notice->user_id)->username}}</td>
                    @elseif($notice->for=="Company")
                        <td>{{App\Models\Company::find($notice->user_id)->slug}}</td>
                    @else
                        <td>-----</td>
                    @endif
                    <td>{{$notice->admin->username}}</td>
					<td><a href="{{route('admin.notice.show',$notice->id)}}">View</a></td>
					<td><a class="delete" data-confirm="Are you sure to delete this item?"
						href="{{route('admin.notice.delete',$notice->id)}}">Delete</a></td>
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
