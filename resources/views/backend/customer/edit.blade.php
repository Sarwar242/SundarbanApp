@extends('backend.layouts.master')
@section('title','Edit Customer')

@section('contents')
@include('backend.layouts.sidebar')
  <section class="container-fluid">

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
              <h2>Edit Customer</h2>
            </div>
          </div>

            <form  method="POST" action="{{ route('admin.customer.update.submit',$customer->id) }}" enctype="multipart/form-data" novalidate="novalidate">
              @csrf
              <div class="form-group">
                <label for="exampleFormControlInput1">First Name</label>
                <input type="text" name="first_name"  value="{{$customer->first_name}}" class="form-control @error('first_name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="First Name Here">
                @error('first_name')
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
                <label for="exampleFormControlInput1">Last Name</label>
                <input type="text" name="last_name"  value="{{$customer->last_name}}" class="form-control @error('last_name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="Last Name Here">
                @error('last_name')
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
                <label for="exampleFormControlInput1">Phone(*)</label>
                <input type="text" name="phone" value="{{$customer->user->phone}}" class="form-control @error('phone') is-invalid @enderror" placeholder="Pease type a valid phone no...">
                @error('phone')
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
                <label for="exampleFormControlInput1">Email</label>
                <input type="text" name="email" value="{{$customer->user->email}}"  class="form-control @error('email') is-invalid @enderror" placeholder="This must be given!">
                @error('email')
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
                <label for="NID">NID</label>
                <input type="text" name="nid"  value="{{$customer->nid}}"  class="form-control @error('nid') is-invalid @enderror" placeholder="">
                @error('nid')
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
                <label for="Phone Number">Phone Number[Optional]</label>
                <input type="text" name="phone2"  value="{{$customer->phone}}"  class="form-control @error('phone2') is-invalid @enderror" placeholder="+8801.........">
                @error('phone2')
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
                <label for="Phone Number">Date of Birth</label>
                <input type="date" name="dob" placeholder="dd-mm-yyyy" 
                 min="1997-01-01" max="2030-12-31"  value="{{$customer->dob}}" 
                  class="form-control @error('dob') is-invalid @enderror">
                @error('dob')
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
                <label for="business_type">Gender</label>
                 <select class="form-control @error('gender') is-invalid @enderror"
                  name="gender" >
                    @if(!is_null($customer->gender))
                      <option value="{{$customer->gender}}" disabled selected>
                          {{$customer->gender}}</option>
                      <option value="Male">
                            Male</option> 
                      <option value="Female">
                            Female</option>       
                      <option value="Other">
                            Other</option>
                    @else
                    <option value="" selected='selected' disabled>
                      Select one</option>
                      <option value="Male">
                        Male</option> 
                  <option value="Female">
                        Female</option>       
                  <option value="Other">
                        Other</option>
                    @endif
                 
                </select>
                @error('gender')
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
                <label for="image">Upload Image</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="image">
                @error('image')
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
                <label for="about">About</label>
                <textarea class="form-control @error('about') is-invalid @enderror" 
                name="about" rows="3" placeholder="About the Customer...">{!!$customer->about!!}</textarea>
                @error('about')
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
                <label for="bn_about">About in Bangla</label>
                <textarea class="form-control @error('bn_about') is-invalid @enderror" 
                name="bn_about" rows="3" placeholder="About the Customer in BD...">{!!$customer->bn_about!!}</textarea>
                @error('bn_about')
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
                <label for="Zip Code">Zip Code</label>
                <input type="text" name="zipcode"  value="{{$customer->zipcode}}"  
                  class="form-control @error('zipcode') is-invalid @enderror" placeholder="Zipcode...">
                @error('zipcode')
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
                <label for="Location">Location/Village</label>
                <input type="text" name="location"  value="{{$customer->location}}"  class="form-control @error('location') is-invalid @enderror" placeholder="Exact Location- ..">
                @error('location')
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
                <label for="Location">Location/Village in Bangla</label>
                <input type="text" name="bn_location"  value="{{$customer->bn_location}}"  class="form-control @error('bn_location') is-invalid @enderror" placeholder="Exact Location in Bangla ...">
                @error('bn_location')
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
                <label for="Street">Street</label>
                <input type="text" name="street"  value="{{$customer->street}}"  class="form-control @error('street') is-invalid @enderror" placeholder="Street name if remain ...">
                @error('street')
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
                <label for="Street in Bangla">Street in Bangla</label>
                <input type="text" name="bn_street"  value="{{$customer->bn_street}}"  class="form-control @error('bn_street') is-invalid @enderror" placeholder="Street name in bangla if remain ...">
                @error('bn_street')
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
                <label for="Holding Number">Holding Number</label>
                <input type="text" name="hn"  value="{{$customer->hn}}"  class="form-control @error('hn') is-invalid @enderror" placeholder="Holding Number of home...">
                @error('hn')
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
                <select name="division_id" id="division_id" class="select2 form-control">
                  @if(!is_null($customer->division))
                    @foreach(App\Models\Division::all() as $division)
                      @if($customer->division->id==$division->id)
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
                   
                      <option value="{{ $division->id }}">
                          {{ $division->name}}</option>
                    @endforeach
                  @endif
                </select>
              </div>

              <div class="form-group">
                <label for="district_id">District</label>
                <select class="select2 form-control" name="district_id" id="district_id">
                  @if(!is_null($customer->district))
                    <option value="{{$customer->district->id}}" selected>
                      {{$customer->district->name}}</option>
                  @endif
                </select>
              </div>

              <div class="form-group">
                <label for="exampleFormControlSelect1">Upazila</label>
                <select class="select2 form-control @error('upazilla_id') is-invalid @enderror" name="upazilla_id" id="upazilla_id">
                  @if(!is_null($customer->upazilla))
                    <option value="{{$customer->upazilla->id}}" selected>
                     {{$customer->upazilla->name}}</option>
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

              <div class="form-group">
                <label for="Union">Union</label>
                <select class="select2 form-control @error('union_id') is-invalid @enderror" name="union_id" id="union_id">
                  @if(!is_null($customer->union))
                    <option value="{{$customer->union->id}}" selected>
                     {{$customer->union->name}}</option>
                  @endif
                </select>
                @error('union_id')
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
                <label for="password">Password</label>
                <input type="password"  name="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')
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
                <label for="exampleInputPassword1">Password Confirm</label>
                <input type="password"  name="password_confirmation" placeholder="Type the password again..." class="form-control @error('password') is-invalid @enderror" required>
              </div>


              <center>
                <input type="submit" class="btn btn-success btn-block" value="Update">
                <a href="{{route('admin.customer.create')}}" class="btn btn-primary btn-block">Add New</a>
              </center>
            </form>
          </div>
        </section>
      </section>
    </section>


    
    
    <script src="{{ asset('js/backend/jquery.min.js')}}"></script>
    <script>
       $(document).on('change','#division_id',function(){
        var division = $("#division_id").val();
        $("#district_id").html("");
        $("#upazilla_id").html("");
        $("#union_id").html("");
        var option = " ";
    //send an ajax req to servers
        $.get(""+myapplink+"/admin/get-district/" +
        division,
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
        var district = $("#district_id").val();
        $("#upazilla_id").html("");
        $("#union_id").html("");
        var option = " ";
    //send an ajax req to servers
        $.get(""+myapplink+"/admin/get-upazilla/" +
        district,
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

    $(document).on('change','#upazilla_id',function(){
        var upazilla = $("#upazilla_id").val();
        $("#union_id").html("");
        var option = " ";
    //send an ajax req to servers
        $.get(""+myapplink+"/admin/get-union/" +
        upazilla,
        function(data) {
          option = "<option selected disabled>Select one</option>";
            var d = JSON.parse(data);
            d.forEach(function(element) {
                console.log(element.id);
                option += "<option value='" + element.id + "'>" + element.name + "</option>";
            });

            $("#union_id").html(option);
        }); 
    });
    </script>

@endsection