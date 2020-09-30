@extends('backend.layouts.master')
@section('title','Edit District')

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
              <h2>Edit District</h2>
            </div>
          </div>

            <form method="POST" action="{{ route('admin.district.update.submit',$district->id) }}" enctype="multipart/form-data" novalidate="novalidate">
              @csrf
              <div class="form-group">
                <label for="Name">Name</label>
                <input type="text" value="{{$district->name}}" name="name" class="form-control @error('name') is-invalid @enderror"
                 id="exampleFormControlInput1" placeholder="Jhalokathi">
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
                <input type="text" name="bn_name" value="{{$district->bn_name}}" class="form-control  @error('bn_name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="">
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
                <label for="exampleFormControlInput1">Website</label>
                <input type="text" name="website" value="{{$district->website}}" class="form-control  @error('website') is-invalid @enderror" 
                    id="exampleFormControlInput1" placeholder="www.barishal.com">
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
                <label for="exampleFormControlInput1">Longitude</label>
                <input type="text" value="{{$district->longitude}}" class="form-control @error('longitude') is-invalid @enderror" name="longitude"  id="exampleFormControlInput1" placeholder="">
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
                <input type="text" value="{{$district->latitude}}" class="form-control @error('latitude') is-invalid @enderror" name="latitude"  id="exampleFormControlInput1" placeholder="">
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
                <select name="division_id" class="select2 form-control @error('division_id') is-invalid @enderror" id="exampleFormControlSelect1">
                  @if(!is_null($district->division))
                    @foreach(App\Models\Division::all() as $division)
                      @if($district->division->id==$division->id)
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
                </select>
                @error('division_id')
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
                <a href="{{route('admin.district.create')}}" class="btn btn-primary btn-block">Add More</a>
              </center>
            </form>
          </div>
        </section>
      </section>
    </section>

@endsection