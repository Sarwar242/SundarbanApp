@extends('backend.layouts.master')
@section('title','Companies')

@section('contents')
@include('backend.layouts.sidebar')
<body>

	<div class="content">
		<center>
			<div class="heading">
				<h4>All The Companies are here</h4>
			</div>
		</center>
		<table id="dataTable" class="table">
		  <thead class="thead-dark">
			<tr>
				<th scope="col">#</th>
				<th scope="col">Name</th>
				<th scope="col">Name In Bangla</th>
				<th scope="col">Owners Name</th>
				<th scope="col">Phone</th>
				<th scope="col">Email</th>
				<th scope="col">Description</th>
				<th scope="col">Logo</th>
				<th scope="col">Edit</th>
			  </tr>
		  </thead>
		  <tbody>
		    @foreach(App\Models\Company::latest()->get() as $company)
				<tr>
					<th scope="row">{{$loop->index+1}}</th>
					<td>{{$company->name}}</td>
					<td>{{$company->bn_name}}</td>
					<td>{{$company->owners_name}}</td>
					<td>{{$company->user->phone}}</td>
					<td>{{$company->user->email}}</td>
					<td>{{$company->description}}</td>
					<td><img src="{{ asset('storage/company')}}/{{$company->image}}" 
                        style="width:30px;" alt="company Image"></td>
					<td><a href="{{route('admin.company.update',$company->id)}}">Edit</a></td>
				
				</tr>
			@endforeach
		  </tbody>
		</table>
		{{-- {!! App\Models\Company::companies()->render() !!} --}}
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