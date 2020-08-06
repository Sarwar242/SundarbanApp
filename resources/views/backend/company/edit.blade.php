@extends('backend.layouts.master')
@section('title','Company')

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
              <h2>Edit Company</h2>
            </div>
          </div>

            <form  method="POST" action="{{ route('admin.company.update.submit',$company->id) }}" enctype="multipart/form-data" novalidate="novalidate">
              @csrf
              <div class="form-group">
                <label for="exampleFormControlInput1">Company Name</label>
                <input type="text" name="name"  value="{{$company->name}}" class="form-control @error('name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="Name Here">
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
                <label for="exampleFormControlInput1">Company Name in Bangla</label>
                <input type="text" name="bn_name" value="{{$company->bn_name}}" class="form-control @error('bn_name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="">
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
                <label for="exampleFormControlInput1">Company Email(*)</label>
                <input type="text" name="email" value="{{$company->user->email}}"  class="form-control @error('email') is-invalid @enderror" placeholder="This must be given!">
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
                <label for="exampleFormControlInput1">Owner's Name</label>
                <input type="text" name="owners_name"  value="{{$company->owners_name}}"  class="form-control @error('owners_name') is-invalid @enderror" placeholder="">
                @error('owners_name')
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
                <label for="exampleFormControlInput1">Owner's Nid</label>
                <input type="text" name="owners_nid"  value="{{$company->owners_nid}}"  class="form-control @error('owners_nid') is-invalid @enderror" placeholder="">
                @error('owners_nid')
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
                <label for="Phone Number">Phone Number(1)</label>
                <input type="text" name="phone1"  value="{{$company->phone1}}"  class="form-control @error('phone1') is-invalid @enderror" placeholder="+8801.........">
                @error('phone1')
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
                <label for="Phone Number">Phone Number(2)</label>
                <input type="text" name="phone2"  value="{{$company->phone2}}"  class="form-control @error('phone2') is-invalid @enderror" placeholder="+8801.........">
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
                <label for="exampleFormControlTextarea1">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                name="description" rows="3" placeholder="Write something about the Company...">{!!$company->description!!}</textarea>
                @error('description')
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
                <label for="Phone Number">Location</label>
                <input type="text" name="location"  value="{{$company->location}}"  class="form-control @error('location') is-invalid @enderror" placeholder="Exact Location of the company ..">
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
                <label for="Phone Number">Street</label>
                <input type="text" name="location"  value="{{$company->street}}"  class="form-control @error('street') is-invalid @enderror" placeholder="Street name if remain ...">
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
                <label for="Phone Number">Website</label>
                <input type="text" name="website"  value="{{$company->website}}"  class="form-control @error('website') is-invalid @enderror" placeholder="If the company have website...">
                @error('website')
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
                <label for="business_type">Provided Business type</label>
                 <select class="form-control @error('business_type') is-invalid @enderror"
                  name="business_type" >
                    @if(!is_null($company->business_type))
                      <option value="{{$company->business_type}}" disabled selected>
                          {{$company->business_type}}</option>
                      <option value="Service">
                            Service</option> 
                      <option value="Product">
                            Product</option>
                    @else
                    <option value="" selected='selected' disabled>
                      Select one</option>
                      <option value="Service">
                          Service</option> 
                      <option value="Product">
                          Product</option>
                    @endif
                 
                </select>
                @error('business_type')
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
                <label for="type">Type of Business</label>
                 <select class="form-control @error('type') is-invalid @enderror"
                  name="type" >
                    @if(!is_null($company->type))
                      <option value="{{$company->type}}" selected  disabled>
                          {{$company->type}}</option>
                      <option value="Wholesale">
                        Wholesale</option> 
                      <option value="Retail">Retail</option>
                      <option value="Export">Export</option>
                      <option value="Import">Import</option>
                    @else
                    <option value="" selected='selected' disabled>
                      Select one</option>
                      <option value="Wholesale">
                        Wholesale</option> 
                      <option value="Retail">Retail</option>
                      <option value="Export">Export</option>
                      <option value="Import">Import</option>
                    @endif
                
                </select>
                @error('type')
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
                <input type="text" name="zipcode"  value="{{$company->zipcode}}"  
                  class="form-control @error('zipcode') is-invalid @enderror" placeholder="If the company have website...">
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
                <label for="Division">Division</label>
                <select name="division_id" id="division_id" class="form-control">
                  @if(!is_null($company->division))
                    @foreach(App\Models\Division::all() as $division)
                      @if($company->division->id==$division->id)
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
                <label for="exampleFormControlSelect1">District</label>
                <select class="form-control" name="district_id" id="district_id">
                  @if(!is_null($company->district))
                    <option value="{{$company->district->id}}" selected>
                      {{$company->district->name}}</option>
                  @endif
                </select>
              </div>

              <div class="form-group">
                <label for="exampleFormControlSelect1">Upazila</label>
                <select class="form-control @error('upazilla_id') is-invalid @enderror" name="upazilla_id" id="upazilla_id">
                  @if(!is_null($company->upazilla))
                    <option value="{{$company->upazilla->id}}" selected>
                     {{$company->upazilla->name}}</option>
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
                <select class="form-control @error('union_id') is-invalid @enderror" name="union_id" id="union_id">
                  @if(!is_null($company->union))
                    <option value="{{$company->union->id}}" selected>
                     {{$company->union->name}}</option>
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


              <input type="hidden" name="is_company" value="1">

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
        var division = $("#division_id").val();
        $("#district_id").html("");
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