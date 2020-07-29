@extends('backend.layouts.master')


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
              <h2>Add Upazila</h2>
            </div>
          </div>

            <form method="POST" action="{{ route('admin.upazilla.create.submit') }}" enctype="multipart/form-data" novalidate="novalidate">
              @csrf
              <div class="form-group">
                <label for="Name">Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
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
                <label for="exampleFormControlInput1">Name in Bangla</label>
                <input type="text" name="bn_name" class="form-control  @error('bn_name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="">
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
                <input type="text" class="form-control @error('longitude') is-invalid @enderror" name="longitude"  id="exampleFormControlInput1" placeholder="">
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
                <label for="exampleFormControlInput1">Latitude</label>
                <input type="text" class="form-control @error('latitude') is-invalid @enderror" name="latitude"  id="exampleFormControlInput1" placeholder="">
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
                <label for="exampleFormControlSelect1">Division</label>
                <select class="form-control" name="division_id" id="division_id">
                  <option value="" selected='selected' disabled>
                    Select a Division</option>
                  @foreach(App\Models\Division::all() as $division)
                    <option value="{{$division->id}}">{{$division->name}}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label for="exampleFormControlSelect1">District</label>
                <select class="form-control @error('district_id') is-invalid @enderror" name="district_id" id="district_id">
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
                <a href="#" class="btn btn-primary btn-block">Add More</a>
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