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
          <th scope="col">Priority</th>
          <th scope="col">featured</th>
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
                <td>
                    <select id="priority{{$subcategory->id}}" name="priority{{$subcategory->id}}" onChange="priorityToggle({{$subcategory->id}})">
                            <option value="{{ is_null($subcategory->priority) ? 12 : $subcategory->priority}}" disabled selected>{{ is_null($subcategory->priority) ? 12 : $subcategory->priority}}</option>
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
                    <input id="subcategoryId" type="hidden" value="{{$subcategory->id}}">
                    <input id="featured" type="checkbox" @if($subcategory->featured==1 && !is_null($subcategory->featured) && $subcategory->featured!=0) checked @endif data-toggle="toggle" data-size="xs"
                     data-on="Enabled"
                     data-off="Disabled"
                     data-onstyle="success" data-offstyle="danger" onChange="featuredToggle({{$subcategory->id}})" >
                </td>
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
@section('scripts')
<script>
    function featuredToggle(id){
        $.get(""+myapplink+"/admin/api/subcategory/featured", {id:id})
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
        $.get(""+myapplink+"/admin/api/subcategory/priority", {id:id, priority:e})
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
