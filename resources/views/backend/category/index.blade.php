@extends('backend.layouts.master')
@section('title','Categories')

@section('contents')
@include('backend.layouts.sidebar')
<div class="content">
    <center>
        <div class="heading">
            <h4>All the Categories are here</h4>
        </div>
    </center>
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Name in Bangla</th>
          <th scope="col">Description</th>
          <th scope="col">Description in Bangla</th>
          <th scope="col">Image</th>
          <th scope="col" colspan="2">Edit</th>
        </tr>
      </thead>
      <tbody>
          @foreach (App\Models\Category::categoies() as $category)
            <tr>
                <th scope="row">{{$loop->index+1}}</th>
                <td>{{$category->name}}</td>
                <td>{{$category->bn_name}}</td>
                <td>{{$category->description}}</td>
                <td>{{$category->bn_description}}</td>
                <td><img src="{{ asset('storage/category')}}/{{$category->image}}" 
                    style="width:30px;" class="user-image" alt="Category Image"></td>    
                <td><a href="{{route('admin.category.update',$category->id)}}">Edit</a></td>
                <td><a class="delete" data-confirm="Are you sure to delete this item?" 
                    href="{{route('admin.category.delete',$category->id)}}">Delete</a></td>
            </tr>
          @endforeach
      </tbody>
    </table>
    {!! App\Models\Category::categoies()->render() !!}
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