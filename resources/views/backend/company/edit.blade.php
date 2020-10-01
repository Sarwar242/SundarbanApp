@extends('backend.layouts.master')
@section('title','Edit Company')

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
                <input type="text" name="name"  value="{{$company->name}}" class="form-control @error('name') is-invalid @enderror" id="namefield" placeholder="Name Here">
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
                <input type="text" name="bn_name" value="{{$company->bn_name}}" class="form-control @error('bn_name') is-invalid @enderror" id="bn_namefield" placeholder="">
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
                <label for="">Phone(*)</label>
                <input type="text" name="phone" value="{{$company->user->phone}}" class="form-control @error('phone') is-invalid @enderror" placeholder="Pease type a valid phone no...">
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
                <label for="Code">Code(*)</label>
                <input type="text" name="code" value="{{$company->code}}" class="form-control @error('code') is-invalid @enderror" placeholder="Please type a numeric code...">
                @error('code')
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
                <label for="exampleFormControlInput1">Company Email</label>
                <input type="text" name="email" value="{{$company->user->email}}"  class="form-control @error('email') is-invalid @enderror" placeholder="This is optional...">
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
                <label for="image">Company Logo</label>
                <div class="preview">
                  <img style="display:block; max-width: 200px; padding-left: 10px;padding-bottom: 3px; margin-left: 60px;" src="{{ asset('storage/company')}}/{{$company->image}}" >
                </div>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="image"
                accept="image/*" onchange="showImgPreview(event);"> <span>[max size: <strong>1mb</strong>
                   & resolution: <strong>400*300px]</strong> </span>
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
                
                <div class="preview">
                  <img id="img-preview">
                </div>
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
                <label for="exampleFormControlInput1">Owner's NID</label>
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
                <label for="Phone Number">Phone Number(1) [Optional]</label>
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
                <label for="Phone Number">Phone Number(2) [Optional]</label>
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
                <label for="Description">Description in Bangla</label>
                <textarea class="form-control @error('bn_description') is-invalid @enderror" 
                name="bn_description" rows="3" placeholder="Write something about the Company...">{!!$company->bn_description!!}</textarea>
                @error('bn_description')
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
                <label for="Location">Location in Bangla</label>
                <input type="text" name="bn_location"  value="{{$company->bn_location}}"  class="form-control @error('bn_location') is-invalid @enderror" placeholder="Exact Location of the company ..">
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
                <label for="Open">Openning Time</label>
                <input type="time" name="open"  value="{{$company->open}}"  class="form-control @error('open') is-invalid @enderror">
                @error('open')
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
                <label for="Close">Closing Time</label>
                <input type="time" name="close"  value="{{$company->close}}"  class="form-control @error('close') is-invalid @enderror">
                @error('close')
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
                <label for="Off_Day">Off Day</label>
                 <select class="select2 form-control @error('off_day') is-invalid @enderror"
                  name="off_day" >
                    @if(!is_null($company->off_day))
                      <option value="{{$company->off_day}}" disabled selected>
                          {{$company->off_day}}</option>
                      <option value="Sunday">
                        Sunday</option> 
                      <option value="Monday">
                        Monday</option> 
                      <option value="Tuesday">
                        Tuesday</option>
                      <option value="Wednesday">
                        Wednesday</option>
                      <option value=Thursday">
                        Thursday</option>
                      <option value="Friday">
                        Friday</option>
                      <option value="Saturday">
                        Saturday</option>
                    @else
                    <option value="" selected='selected' disabled>
                      Select one</option>
                      <option value="Sunday">
                        Sunday</option> 
                      <option value="Monday">
                        Monday</option> 
                      <option value="Tuesday">
                        Tuesday</option>
                      <option value="Wednesday">
                        Wednesday</option>
                      <option value=Thursday">
                        Thursday</option>
                      <option value="Friday">
                        Friday</option>
                      <option value="Saturday">
                        Saturday</option>
                    @endif
                 
                </select>
                @error('off_day')
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
                <input type="text" name="street"  value="{{$company->street}}"  class="form-control @error('street') is-invalid @enderror" placeholder="Street name if remain ...">
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
                <label for="Street">Street in Bangla</label>
                <input type="text" name="bn_street"  value="{{$company->bn_street}}"  class="form-control @error('bn_street') is-invalid @enderror" placeholder="Street name if remain ...">
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
                <label for="exampleFormControlSelect1">Category</label>
                <select class="select2 form-control @error('category_id') is-invalid @enderror" name="category_id"  id="category_id" >
                  @if(!is_null($company->category))
                  @foreach(App\Models\Category::all() as $category)
                    @if($company->category->id==$category->id)
                    <option value="{{ $category->id }}" selected>
                        {{$category->name}}</option>
                    @else
                    <option value="{{ $category->id }}">
                        {{ $category->name}}</option>
                    @endif
                  @endforeach
                  @else
                    <option value="" selected='selected' disabled>
                      Select a Category</option>
                    @foreach(App\Models\Category::all() as $category)
                      <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                  @endif
                </select>
                @error('category_id')
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
                <label for="exampleFormControlSelect1">Sub-Category</label>
                <select  name="select2 subcategory_id"  class="form-control @error('subcategory_id') is-invalid @enderror" id="subcategory_id" >
                  @if(!is_null($company->subcategory))
                    <option value="{{$company->subcategory->id}}" selected >
                      {{$company->subcategory->name}}</option>
                  @endif
                </select>
                @error('subcategory_id')
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
                 <select class="select2 form-control @error('business_type') is-invalid @enderror"
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
                 <select class="select2 form-control @error('type') is-invalid @enderror"
                  name="type" >
                    @if(!is_null($company->type))
                      <option value="{{$company->type}}" selected="selected"  disabled>
                          {{$company->type}}</option>
                      <option value="Wholesale">
                        Wholesale</option> 
                      <option value="Retailer">Retailer</option>
                      <option value="Manufacturer">Manufacturer</option>
                      <option value="Export">Export</option>
                      <option value="Import">Import</option>
                    @else
                    <option value="" selected='selected' disabled>
                      Select one</option>
                      <option value="Wholesale">
                        Wholesale</option> 
                      <option value="Retailer">Retailer</option>
                      <option value="Manufacturer">Manufacturer</option>
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
                <select name="division_id" id="division_id" class="select2 form-control">
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
                <select class="select2 form-control" name="district_id" id="district_id">
                  @if(!is_null($company->district))
                    <option value="{{$company->district->id}}" selected>
                      {{$company->district->name}}</option>
                  @endif
                </select>
              </div>

              <div class="form-group">
                <label for="exampleFormControlSelect1">Upazila</label>
                <select class="select2 form-control @error('upazilla_id') is-invalid @enderror" name="upazilla_id" id="upazilla_id">
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
                <select class="select2 form-control @error('union_id') is-invalid @enderror" name="union_id" id="union_id">
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
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
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
                <label for="Password Confirm">Password Confirm</label>
                <input type="password"  name="password_confirmation" placeholder="Type the password again..." class="form-control @error('password') is-invalid @enderror" required>
              </div>


              <input type="hidden" name="is_company" value="1">

              <center>
                <input type="submit" class="btn btn-success btn-block" value="Update">
                <a href="{{route('admin.company.create')}}" class="btn btn-primary btn-block">Add New</a>
              </center>
            </form>
          </div>
        </section>
      </section>
    </section>


    
    
    <script src="{{ asset('js/backend/jquery.min.js')}}"></script>
    <script>
        $(document).on('change','#category_id',function(){
          var category = $("#category_id").val();
          $("#subcategory_id").html("");
          var option = " ";
          //send an ajax req to servers
          $.get(""+myapplink+"/admin/get-subcategories/" +
          category,
          function(data) {
            option = "<option selected disabled>Select one</option>";
              var d = JSON.parse(data);
              d.forEach(function(element) {
                  console.log(element.id);
                  option += "<option value='" + element.id + "'>" + element.name + "</option>";
              });

              $("#subcategory_id").html(option);
          }); 
    });

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