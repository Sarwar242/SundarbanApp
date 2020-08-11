

@extends('backend.layouts.master')
@section('title','Customers')

@section('contents')
@include('backend.layouts.sidebar')
<body>

	

	<div class="content">
		<center>
			<div class="heading">
				<h4>All your customers details are here</h4>
			</div>
		</center>
		<table id="dataTable" class="table">
			<thead class="thead-dark">
			  <tr>
				<th scope="col">#</th>
				<th scope="col">First Name</th>
				<th scope="col">Last Name</th>
				<th scope="col">Email</th>
				<th scope="col">Phone</th>
				<th scope="col">Image</th>
				<th scope="col" colspan="2">Edit</th>
			  </tr>
			</thead>
			<tbody>
			  @foreach(App\Models\Customer::customers() as $customer)
				  <tr>
					  <th scope="row">{{$loop->index+1}}</th>
					  <td>{{$customer->first_name}}</td>
					  <td>{{$customer->last_name}}</td>
					  <td>{{$customer->user->email}}</td>
					  <td>{{$customer->user->phone}}</td>
					  <td><img src="{{ asset('storage/customer')}}/{{$customer->image}}" 
                        style="width:30px;" alt="customer Image"></td>
					  <td><a href="{{route('admin.customer.update',$customer->id)}}">Edit</a></td>
					  <td>
						<input type="checkbox" checked data-toggle="toggle" data-size="xs" data-onstyle="success" data-offstyle="danger" data-on="Enabled" data-off="Disabled">
				  	  </td>
				  </tr>
			  @endforeach
			</tbody>
		  </table>
		  {!! App\Models\Customer::customers()->render() !!}
  
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