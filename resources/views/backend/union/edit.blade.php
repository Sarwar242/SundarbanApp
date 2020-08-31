@extends('backend.layouts.master')
@section('title','Edit Union')

@section('contents')
@include('backend.layouts.sidebar')
  <section class="container-fluid">
    <section class="row justify-content-center">
      <section class="col-12 col-sm-6 col-md-3">
        <div class="form-container">
          <div class="container">
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
            <div class="text-center">
              <h2>Edit Union</h2>
            </div>
          </div>

            <form method="POST" action="{{ route('admin.union.update.submit', $union->id) }}" enctype="multipart/form-data" novalidate="novalidate">
              @csrf
              <div class="form-group">
                <label for="Name">Name</label>
                <input type="text" value="{{$union->name}}" name="name" class="form-control @error('name') is-invalid @enderror"
                 id="exampleFormControlInput1" placeholder="Name Here">
                @error('name')
                  <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">
                      x
                    </button>
                    <strong>
                        {!! $message !!}
                    </strong>
                  </div>
                @enderror
              </div>

              <div class="form-group">
                <label for="exampleFormControlInput1">Name in Bangla</label>
                <input type="text" value="{{$union->bn_name}}"  name="bn_name" class="form-control  @error('bn_name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="">
                @error('bn_name')
                  <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">
                      x
                    </button>
                    <strong>
                        {!! $message !!}
                    </strong>
                  </div>
               @enderror
              </div>
              <div class="form-group">
                <label for="exampleFormControlInput1">Longitude</label>
                <input type="text" value="{{$union->longitude}}"  class="form-control @error('longitude') is-invalid @enderror" name="longitude"  id="exampleFormControlInput1" placeholder="">
                @error('longitude')
                <div class="alert alert-danger alert-block">
                  <button type="button" class="close" data-dismiss="alert">
                    x
                  </button>
                  <strong>
                      {!! $message !!}
                  </strong>
                </div>
                @enderror
              </div>

              <div class="form-group">
                <label for="Latitude">Latitude</label>
                <input type="text" value="{{$union->latitude}}"  class="form-control @error('latitude') is-invalid @enderror" name="latitude"  id="exampleFormControlInput1" placeholder="">
                @error('latitude')
                <div class="alert alert-danger alert-block">
                  <button type="button" class="close" data-dismiss="alert">
                    x
                  </button>
                  <strong>
                      {!! $message !!}
                  </strong>
                </div>
                @enderror
              </div>
              <div class="form-group">
                <label for="Division">Division</label>
                <select name="division_id" id="division_id" class="select2 form-control" id="exampleFormControlSelect1">
                  @if(!is_null($union->upazilla))
                    @if(!is_null($union->upazilla->district))
                      @if(!is_null($union->upazilla->district->division))
                        @foreach(App\Models\Division::all() as $division)
                          @if($union->upazilla->district->division->id==$division->id)
                          <option value="{{ $division->id }}" selected>
                              {{$division->name}}</option>
                          @else
                          <option value="{{ $division->id }}">
                              {{ $division->name}}</option>
                          @endif
                        @endforeach
                      @else
                        <option value="" selected='selected' disabled>
                          Select a Division</option>
                        @foreach(App\Models\Division::all() as $division)
                          <option value="{{$division->id}}">{{$division->name}}</option>
                        @endforeach
                      @endif
                    @else
                      <option value="" selected='selected' disabled>
                        Select a Division</option>
                      @foreach(App\Models\Division::all() as $division)
                        <option value="{{$division->id}}">{{$division->name}}</option>
                      @endforeach
                    @endif
                    @else
                    <option value="" selected='selected' disabled>
                      Select a Division</option>
                    @foreach(App\Models\Division::all() as $division)
                      <option value="{{$division->id}}">{{$division->name}}</option>
                    @endforeach
                  @endif
                </select>
              </div>

              <div class="form-group">
                <label for="District">District</label>
                <select class="select2 form-control" name="district_id" id="district_id">
                  @if(!is_null($union->upazilla))
                    @if(!is_null($union->upazilla->district))
                      <option value="{{$union->upazilla->district->id}}" selected>
                              {{$union->upazilla->district->name}}</option>
                    @endif
                  @endif
                </select>
              </div>

              <div class="form-group">
                <label for="Upazilla">Upazila</label>
                <select class="select2 form-control @error('upazilla_id') is-invalid @enderror" name="upazilla_id" id="upazilla_id">
                  @if(!is_null($union->upazilla))
                      <option value="{{$union->upazilla->id}}" selected>
                              {{$union->upazilla->name}}</option>
                    @endif
                </select>
                @error('upazilla_id')
                <div class="alert alert-danger alert-block">
                  <button type="button" class="close" data-dismiss="alert">
                    x
                  </button>
                  <strong>
                      {!! $message !!}
                  </strong>
                </div>
                @enderror
              </div>

              <center>
                <input type="submit" class="btn btn-success btn-block" value="Submit">
                <a href="{{route('admin.union.create')}}" class="btn btn-primary btn-block">Add More</a>
              </center>
            </form>
          </form>
        </section>
      </section>
    </section>


    
    <script src="{{ asset('js/backend/jquery.min.js')}}"></script>
    <script>
       $(document).on('change','#division_id',function(){
        var category = $("#division_id").val();
        $("#district_id").html("");
        var option = " ";
    //send an ajax req to servers
        $.get(""+myapplink+"/admin/get-district/" +
        category,
        function(data) {
          option = "<option selected disabled>Select one</option>";
            var d = JSON.parse(data);
            d.forEach(function(element) {
                console.log(element.id);
                option += "<option value='" + element.id + "'>" + element.name + "</option>";
            });

            $("#district_id").html(option);
        }); 
    });

    $(document).on('change','#district_id',function(){
        var category = $("#district_id").val();
        $("#upazilla_id").html("");
        var option = " ";
    //send an ajax req to servers
        $.get(""+myapplink+"/admin/get-upazilla/" +
        category,
        function(data) {
            option = "<option selected disabled>Select one</option>";
            var d = JSON.parse(data);
            d.forEach(function(element) {
              
                console.log(element.id);
                option += "<option value='" + element.id + "'>" + element.name + "</option>";
            });

            $("#upazilla_id").html(option);
        }); 
    });
    </script>
@endsection