@extends('backend.layouts.master')
@section('title','Admins')

@section('contents')
@include('backend.layouts.sidebar')
	<div class="content">
      @if(Session::has('success'))
              <div class="alert alert-success alert-block">
                  <button type="button" class="close" data-dismiss="alert">
                      x
                  </button>
                  <strong>
                    {!! session('success')!!}   @php Session::forget('success') @endphp
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
		<center>
			<div class="heading">
				<h4>All The Admins are here</h4>
			</div>
		</center>
		<table id="dataTable" class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Type</th>
                <th scope="col">Phone(1)</th>
                <th scope="col">Phone(2)</th>
                <th scope="col"></th>
                <th scope="col">Image</th>
                <th scope="col">Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach(App\Models\Admin::latest()->get() as $admin)
                  <tr>
                      <th scope="row">{{$loop->index+1}}</th>
                      <td  onclick="window.location.href='{{route('admin.profile', $admin->username)}}'" style="cursor: pointer">{{$admin->first_name}}</td>
                      <td  onclick="window.location.href='{{route('admin.profile', $admin->username)}}'" style="cursor: pointer">{{$admin->last_name}}</td>
                      <td onclick="window.location.href='{{route('admin.profile', $admin->username)}}'" style="cursor: pointer">{{$admin->username}}</td>
                      <td>{{$admin->email}}</td>
                      <td>{{$admin->type}}</td>
                      <td>{{$admin->phone1}}</td>
                      <td>{{$admin->phone2}}</td>
                      <td></td>
                      <td><img src="{{ asset('storage/admin')}}/{{$admin->image}}"
                        style="width:30px;" alt="Admin Image"></td>
                      <td><a href="{{route('admin.admin.update',$admin->id)}}">Edit</a></td>
                  </tr>
              @endforeach
            </tbody>
          </table>
          {{-- {!! App\Models\Admin::admins()->render() !!} --}}
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
