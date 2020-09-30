@extends('backend.layouts.master')
@section('title','Edit Upazilla')

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
              <h2>Edit Upazzila</h2>
            </div>
          </div>

            <form method="POST" action="{{ route('admin.upazilla.update.submit',$upazilla->id ) }}" enctype="multipart/form-data" novalidate="novalidate">
              @csrf
              <div class="form-group">
                <label for="Name">Name</label>
                <input type="text" value="{{$upazilla->name}}" name="name" class="form-control @error('name') is-invalid @enderror"
                 id="exampleFormControlInput1" placeholder="Barishal Sadar">
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
                <label for="Bangla Name">Name in Bangla</label>
                <input type="text" value="{{$upazilla->bn_name}}" name="bn_name" class="form-control  @error('bn_name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="">
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
                <label for="Longitude">Longitude</label>
                <input type="text" value="{{$upazilla->longitude}}" class="form-control @error('longitude') is-invalid @enderror" name="longitude"  id="exampleFormControlInput1" placeholder="">
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
                <input type="text" value="{{$upazilla->latitude}}" class="form-control @error('latitude') is-invalid @enderror" name="latitude"  id="exampleFormControlInput1" placeholder="">
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
                <select class="select2 form-control" name="division_id" id="division_id">
                  @if(!is_null($upazilla->district))
                    @if(!is_null($upazilla->district->division))
                      @foreach(App\Models\Division::all() as $division)
                        @if($upazilla->district->division->id==$division->id)
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
                </select>
              </div>

              <div class="form-group">
                <label for="District">District</label>
                <select class="select2 form-control @error('district_id') is-invalid @enderror" name="district_id" id="district_id">
                  @if(!is_null($upazilla->district))
                    <option value="{{$upazilla->district->id}}" selected>
                      {{$upazilla->district->name}}</option>
                  @endif
                </select>
                @error('district_id')
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
                <a href="{{ route('admin.upazilla.create') }}" class="btn btn-primary btn-block">Add More</a>
              </center>
            </form>
          </div>
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
     
      </script>

@endsection