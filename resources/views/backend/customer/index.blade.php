@extends('backend.layouts.master')
@section('title','Customers')

@section('contents')
@include('backend.layouts.sidebar')
<body>

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
				<h4>All your Customers details are here</h4>
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
				<th scope="col"></th>
				<th scope="col">Edit</th>
				<th scope="col">Action</th>
			  </tr>
			</thead>
			<tbody>
			  @foreach(App\Models\Customer::latest()->get() as $customer)
				  <tr>
					  <th scope="row">{{$loop->index+1}}</th>
					  <td onclick="window.location.href='{{route('admin.customer.profile', $customer->username)}}'" style="cursor: pointer">{{$customer->first_name}}</td>
					  <td onclick="window.location.href='{{route('admin.customer.profile', $customer->username)}}'" style="cursor: pointer">{{$customer->last_name}}</td>
					  <td>{{$customer->user->email}}</td>
					  <td>{{$customer->user->phone}}</td>
					  <td><img src="{{ asset('storage/customer')}}/{{$customer->image}}" 
						style="width:30px;" alt="customer Image"></td>
						<td></td>
					  <td><a href="{{route('admin.customer.update',$customer->id)}}">Edit</a></td>
					  <td>
						<input id="customerId" type="hidden" value="{{$customer->id}}">
						<input id="ban" type="checkbox" @if($customer->ban==0||is_null($customer->ban)) checked @endif data-toggle="toggle" data-size="xs" 
						 data-on="Enabled"
						 data-off="Disabled"
						 data-onstyle="success" data-offstyle="danger" onChange="banFunc({{$customer->id}})" >
				  	  </td>
				  </tr>
			  @endforeach
			</tbody>
		</table>
		  {{-- {!! App\Models\Customer::customers()->render() !!} --}}	  
	</div>

	{{-- <script src="{{asset('js/backend/jquery.min.js')}}"></script> --}}

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

	<script>
		function banFunc(id){
			$.get(""+myapplink+"/admin/customer/ban", {id:id})
			.done(function(data) {
                data = JSON.parse(data);
				console.log(data);
                if (data.status == 'success') {
					$("#ban").load(window.location.href + " #ban");
                }
            });
		}
  </script> 
	@endsection