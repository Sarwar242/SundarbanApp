

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