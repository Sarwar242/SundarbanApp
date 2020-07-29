
@extends('backend.layouts.master')


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
		<center>
			<div class="heading">
				<h4>All your products details are here</h3>
			</div>
		</center>
		<table class="table">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">Name</th>
		      <th scope="col">Code</th>
		      <th scope="col">Description</th>
		      <th scope="col">Price</th>
		      <th scope="col">Quantity</th>
		      <th scope="col" colspan="2">Edit</th>
		    </tr>
		  </thead>
		  <tbody>
			@foreach(App\Models\Product::products() as $product)
				<tr>
					<th scope="row">{{$loop->index+1}}</th>
					<td>{{$product->name}}</td>
					<td>{{$product->code}}</td>
					<td>{{$product->description}}</td>
					<td>{{$product->price}}</td>
					<td>{{$product->quantity}}</td>
					<td><a href="{{route('admin.product.update',$product->id)}}">Edit</a></td>
					<td><a class="delete" data-confirm="Are you sure to delete this item?" href="{{route('admin.product.delete',$product->id)}}">Delete</a></td>
				</tr>
			@endforeach
		  </tbody>
		</table>
		{!! App\Models\Product::products()->render() !!}




		<center>
			<div class="heading">
				<h4>All your Categories details are here</h3>
			</div>
		</center>

		<table class="table">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">Name</th>
		      <th scope="col">Name In Bangla</th>
		      <th scope="col">Description</th>
		      <th scope="col">Description In Bangla</th>
		      <th scope="col" colspan="2">Edit</th>
		    </tr>
		  </thead>
		  <tbody>
			@foreach(App\Models\Category::categoies() as $category)
				<tr>
					<th scope="row">{{$loop->index+1}}</th>
					<td>{{$category->name}}</td>
					<td>{{$category->bn_name}}</td>
					<td>{{$category->description}}</td>
					<td>{{$category->bn_description}}</td>
					<td><a href="{{route('admin.category.update',$category->id)}}">Edit</a></td>
					<td><a class="delete" data-confirm="Are you sure to delete this item?" 
						href="{{route('admin.category.delete',$category->id)}}">Delete</a></td>
				</tr>
			@endforeach
		  </tbody>
		</table>
		{!! App\Models\Category::categoies()->render() !!}



		
		<center>
			<div class="heading">
				<h4>All your Subcategories details are here</h3>
			</div>
		</center>

		<table class="table">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">Name</th>
		      <th scope="col">Name In Bangla</th>
		      <th scope="col">Category</th>
			  <th scope="col">Description</th>
		      <th scope="col">Description In Bangla</th>
		      <th scope="col" colspan="2">Edit</th>
		    </tr>
		  </thead>
		  <tbody>
			@foreach(App\Models\Subcategory::subcategoies() as $subcategory)
				<tr>
					<th scope="row">{{$loop->index+1}}</th>
					<td>{{$subcategory->name}}</td>
					<td>{{$subcategory->bn_name}}</td>
					<td>{{$subcategory->category->name}}</td>
					<td>{{$subcategory->description}}</td>
					<td>{{$subcategory->bn_description}}</td>
					<td><a href="{{route('admin.subcategory.update',$subcategory->id)}}">Edit</a></td>
					<td><a class="delete" data-confirm="Are you sure to delete this item?" 
						href="{{route('admin.subcategory.delete',$subcategory->id)}}">Delete</a></td>
				</tr>
			@endforeach
		  </tbody>
		</table>
		{!! App\Models\Subcategory::subcategoies()->render() !!}		


		<center>
			<div class="heading">
				<h4>All your Companies details are here</h3>
			</div>
		</center>

		<table class="table">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">Name</th>
		      <th scope="col">Name In Bangla</th>
		      <th scope="col">Owners Name</th>
		      <th scope="col">Phone(1)</th>
		      <th scope="col">Email</th>
		      <th scope="col" colspan="2">Edit</th>
		    </tr>
		  </thead>
		  <tbody>
			@foreach(App\Models\Company::companies() as $company)
				<tr>
					<th scope="row">{{$loop->index+1}}</th>
					<td>{{$company->name}}</td>
					<td>{{$company->bn_name}}</td>
					<td>{{$company->owners_name}}</td>
					<td>{{$company->phone1}}</td>
					<td>{{$company->user->email}}</td>
					<td><a href="{{route('admin.company.update',$company->id)}}">Edit</a></td>
					<td><a href="#">Delete</a></td>
				</tr>
			@endforeach
		  </tbody>
		</table>
		{!! App\Models\Company::companies()->render() !!}



		<center>
			<div class="heading">
				<h4>All your Customers details are here</h3>
			</div>
		</center>

		<table class="table">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">First Name</th>
		      <th scope="col">Last Name</th>
		      <th scope="col">Email</th>
		      <th scope="col">Phone</th>
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
					<td>{{$customer->phone}}</td>
					<td><a href="#">Edit</a></td>
					<td><a href="#">Delete</a></td>
				</tr>
			@endforeach
		  </tbody>
		</table>
		{!! App\Models\Customer::customers()->render() !!}


		<center>
			<div class="heading">
				<h4>All your Admins details are here</h3>
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