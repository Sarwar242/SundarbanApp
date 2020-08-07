
@extends('backend.layouts.master')

@section('title','Homepage')
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
				<h4>Latest Companies are here</h3>
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
		      <th scope="col">Phone(2)</th>
		      <th scope="col">Email</th>
		      <th scope="col" colspan="2">Edit</th>
		    </tr>
		  </thead>
		  <tbody>
			@foreach(App\Models\Company::latest()->limit(10)->get() as $company)
				<tr>
					<th scope="row">{{$loop->index+1}}</th>
					<td>{{$company->name}}</td>
					<td>{{$company->bn_name}}</td>
					<td>{{$company->owners_name}}</td>
					<td>{{$company->phone1}}</td>
					<td>{{$company->phone2}}</td>
					<td>{{$company->user->email}}</td>
					<td><a href="{{route('admin.company.update',$company->id)}}">Edit</a></td>
					<td><a href="#">Delete</a></td>
				</tr>
			@endforeach
		  </tbody>
		</table>
		<hr>
		<center>
			<div class="heading">
				<h4>New Customers are here</h3>
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
			@foreach(App\Models\Customer::latest()->limit(5)->get() as $customer)
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
		
		<hr>

		<center>
			<div class="heading">
				<h4>New Admins</h3>
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
			@foreach(App\Models\Admin::latest()->limit(5)->get() as $admin)
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

		<hr>
		<center>
			<div class="heading">
				<h4>Latest Products are here</h3>
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
			@foreach(App\Models\Product::latest()->limit(10)->get() as $product)
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
		
		<hr>


		<center>
			<div class="heading">
				<h4>Latest Categories are here</h3>
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
			@foreach(App\Models\Category::latest()->limit(5)->get() as $category)
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
		
		<hr>


		
		<center>
			<div class="heading">
				<h4>Latest Subcategories are here</h3>
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
			@foreach(App\Models\Subcategory::latest()->limit(5)->get() as $subcategory)
				<tr>
					<th scope="row">{{$loop->index+1}}</th>
					<td>{{$subcategory->name}}</td>
					<td>{{$subcategory->bn_name}}</td>
					@if(!is_null($subcategory->category))
					<td>{{$subcategory->category->name}}</td>
					@else
					<td>N/A</td>
					@endif
					<td>{{$subcategory->description}}</td>
					<td>{{$subcategory->bn_description}}</td>
					<td><a href="{{route('admin.subcategory.update',$subcategory->id)}}">Edit</a></td>
					<td><a class="delete" data-confirm="Are you sure to delete this item?" 
						href="{{route('admin.subcategory.delete',$subcategory->id)}}">Delete</a></td>
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