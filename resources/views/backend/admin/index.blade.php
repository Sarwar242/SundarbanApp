@extends('backend.layouts.master')
@section('title','Admins')

@section('contents')
@include('backend.layouts.sidebar')
<body>

	<div class="content">
		<center>
			<div class="heading">
				<h4>All The Admins are here</h4>
			</div>
		</center>
		<table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col" colspan="2">Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach(App\Models\Admin::admins() as $admin)
                  <tr>
                      <th scope="row">{{$loop->index+1}}</th>
                      <td>{{$admin->first_name}}</td>
                      <td>{{$admin->last_name}}</td>
                      <td>{{$admin->username}}</td>
                      <td>{{$admin->email}}</td>
                      <td>{{$admin->phone1}}</td>
                      <td><a href="#">Edit</a></td>
                      <td><a href="#">Delete</a></td>
                  </tr>
              @endforeach
            </tbody>
          </table>
          {!! App\Models\Admin::admins()->render() !!}
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