

@extends('backend.layouts.master')
@section('title','Products')

@section('contents')
@include('backend.layouts.sidebar')

	<div class="content">
		<center>
			<div class="heading">
				<h4>All your products details are here</h4>
			</div>
		</center>
		<table id="dataTable" class="table">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">Name</th>
		      <th scope="col">Code</th>
		      <th scope="col">Price</th>
			  <th scope="col">Quantity</th>
			  <th scope="col">Category</th>
			  <th scope="col">Subcategory</th>
			  <th scope="col">Description</th>
		      <th scope="col">Edit</th>
		      <th scope="col">Action</th>
		    </tr>
		  </thead>
		  <tbody>
			@foreach(App\Models\Product::latest()->get() as $product)
				<tr>
					<th scope="row">{{$loop->index+1}}</th>
					<td onclick="window.location.href='{{route('admin.product.show', $product->slug)}}'" style="cursor: pointer">{{$product->name}}</td>
					<td onclick="window.location.href='{{route('admin.product.show', $product->slug)}}'" style="cursor: pointer">{{$product->code}}</td>

					<td>{{$product->price}}</td>
					<td>{{$product->quantity}}</td>
					@if(!is_null($product->category))
						<td>{{$product->category->name}}</td>
					@else
						<td></td>
					@endif

					@if(!is_null($product->subcategory))
						<td>{{$product->subcategory->name}}</td>
					@else
						<td></td>
					@endif

					<td>{{substr($product->description, 0,  100)}}</td>
					<td><a href="{{route('admin.product.update',$product->id)}}">Edit</a></td>
					<td><a class="delete" data-confirm="Are you sure to delete this item?" href="{{route('admin.product.delete',$product->id)}}">Delete</a></td>
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
