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
    <table id="dataTable" class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Name in Bangla</th>
          <th scope="col">Description</th>
          <th scope="col">Description in Bangla</th>
          <th scope="col">Priority</th>
          <th scope="col">featured</th>
          <th scope="col">Image</th>
          <th scope="col">Edit</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
          @foreach (App\Models\Category::orderBy('name')->get() as $category)
            <tr>
                <th scope="row">{{$loop->index+1}}</th>
                <td style="width:100px;cursor: pointer;" onclick="window.location.href='{{route('admin.category.locations.companies', $category->id)}}'">{{$category->name}}</td>
                <td style="width:100px;cursor: pointer;" onclick="window.location.href='{{route('admin.category.locations.companies', $category->id)}}'">{{$category->bn_name}}</td>

                <td style="width:120px;">{!!strlen($category->description) > 100 ? substr($category->description,0,50)." .....": $category->description!!}</td>
                <td style="width:120px;">{!!strlen($category->bn_description) > 100 ? substr($category->bn_description,0,50)." ...": $category->bn_description!!}</td>
                <td>
                    <select id="priority{{$category->id}}" name="priority{{$category->id}}" onChange="priorityToggle({{$category->id}})">
                            <option value="{{ is_null($category->priority) ? 12 : $category->priority}}" disabled selected>{{ is_null($category->priority) ? 12 : $category->priority}}</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                    </select>
                </td>
                <td>
                    <input id="categoryId" type="hidden" value="{{$category->id}}">
                    <input id="featured" type="checkbox" @if($category->featured==1 && !is_null($category->featured) && $category->featured!=0) checked @endif data-toggle="toggle" data-size="xs"
                     data-on="Enabled"
                     data-off="Disabled"
                     data-onstyle="success" data-offstyle="danger" onChange="featuredToggle({{$category->id}})" >
                </td>

                <td><img src="{{ asset('storage/category')}}/{{$category->image}}"
                    style="width:30px;" class="user-image" alt="Category Image"></td>
                <td><a href="{{route('admin.category.update',$category->id)}}">Edit</a></td>
                <td><a class="delete" data-confirm="Are you sure to delete this item?"
                    href="{{route('admin.category.delete',$category->id)}}">Delete</a></td>
            </tr>
          @endforeach
      </tbody>
    </table>
    {{-- {!! App\Models\Category::categoies()->render() !!} --}}
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
@section('scripts')
<script>
    function featuredToggle(id){
        $.get(""+myapplink+"/admin/api/category/featured", {id:id})
        .done(function(data) {
            data = JSON.parse(data);
            console.log(data);
            if (data.status == 'success') {
                $("#featured").load(window.location.href + " #featured");
            }
        });
    }

    function priorityToggle(id){
        var e = $("#priority"+id+" :selected").val();
        // console.log( e);
        $.get(""+myapplink+"/admin/api/category/priority", {id:id, priority:e})
        .done(function(data) {
            data = JSON.parse(data);
            console.log(data);
            if (data.status == 'success') {
                $("#priority").load(window.location.href + " #priority");
            }
        });
    }
</script>
@endsection
