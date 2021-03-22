@extends('backend.layouts.master')
@section('title','Divisions')

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
				<h4><small class="text-muted">Details for Division: </small>{{$division->name}}</h4>
			</div>
		</center>
		<table id="dataTable" class="table">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col" class="text-center">Category name<br><span  class="text-muted">(Products)</span></th>
		      <th scope="col" class="text-center">Subcategory Name<br> <span  class="text-muted">(Products)</span></th>
		      <th scope="col" class="text-center">Companies<br><span  class="text-muted">[in Subcategory]</span></th>
		      <th scope="col" class="text-center">Companies<br><span  class="text-muted">[in Category]</span></th>
			  <th scope="col"></th>
		    </tr>
		  </thead>
		  <tbody>
			@foreach($categories as $category)
                @foreach ($category->subcategories as $subcategory)
                    <tr>
                        <th scope="row" class="text-center">{{$loop->index+1}}</th>
                        <td class="text-center" style="cursor: pointer;" onclick="window.location.href='{{route('admin.category.show',$category->id)}}'">{!! $category->name==''? $category->bn_name:$category->name !!} <span class="badge badge-pill badge-secondary">{{count($category->products)}}</span></td>
                        <td class="text-center" style="cursor: pointer;" onclick="window.location.href='{{route('admin.subcategory.show',$subcategory->id)}}'">{!! $subcategory->name==''? $subcategory->bn_name:$subcategory->name !!} <span class="badge badge-pill badge-secondary">{{count($subcategory->products)}}</span></td>
                        <td class="text-center">{{count($subcategory->companies)}}</td>
                        <td class="text-center">{{count($category->companies)}}</td>
                        <td class="text-center"> </td>
                        {{-- <td><a href="{{route('admin.division.update',$division->id)}}">Edit</a></td>
                        <td><a class="delete" data-confirm="Are you sure to delete this item?"
                            href="{{route('admin.division.delete',$division->id)}}">Delete</a></td> --}}
                    </tr>
                @endforeach
			@endforeach
		  </tbody>
		</table>
		{!! App\Models\Division::divisions()->render() !!}
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
