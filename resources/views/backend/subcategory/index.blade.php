@extends('backend.layouts.master')
@section('title','Subcategories')

@section('contents')
@include('backend.layouts.sidebar')
<div class="content">
    <center>
        <div class="heading">
            <h4>All the Subcategories are here</h4>
        </div>
    </center>
    <table id="dataTable" class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Name in Bangla</th>
          <th scope="col">Category</th>
          <th scope="col">Description</th>
          <th scope="col">Description in Bangla</th>
          <th scope="col">Image</th>
          <th scope="col">Edit</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach(App\Models\Subcategory::latest()->get() as $subcategory)
            <tr>
                <th scope="row">{{$loop->index+1}}</th>
                <td>{{$subcategory->name}}</td>
                <td>{{$subcategory->bn_name}}</td>
                @if(!is_null($subcategory->category))
					<td>{{$subcategory->category->name}}</td>
                @else
                    <td>N/A</td>
                @endif
                <td>{{substr($subcategory->bn_description, 0,  100)}}</td>
                <td>{{substr($subcategory->bn_description, 0,  100)}}</td>
                <td><img src="{{ asset('storage/subcategory')}}/{{$subcategory->image}}"
                    style="width:30px;" alt="Subcategory Image"></td>
                <td><a href="{{route('admin.subcategory.update',$subcategory->id)}}">Edit</a></td>
                <td><a class="delete" data-confirm="Are you sure to delete this item?"
                    href="{{route('admin.subcategory.delete',$subcategory->id)}}">Delete</a></td>
            </tr>
        @endforeach
      </tbody>
    </table>
    {{-- {!! App\Models\Subcategory::subcategoies()->render() !!}	 --}}
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
