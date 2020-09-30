@extends('backend.layouts.master')
@section('title','Edit Unit')

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
              <h2>Edit Unit</h2>
            </div>
          </div>

            <form  method="POST" action="{{route('admin.unit.update.submit',$unit->id) }}" enctype="multipart/form-data" novalidate="novalidate">
              @csrf
              <div class="form-group">
                <label for="Name">Name</label>
                <input type="text" value="{{$unit->name}}" name="name" class="form-control @error('name') is-invalid @enderror"
                 id="name" placeholder="Kilogram">
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
                <input type="text" value="{{$unit->bn_name}}" name="bn_name" class="form-control  @error('bn_name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="">
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
              <center>
                <input type="submit" class="btn btn-success btn-block" value="Submit">
                <a href="{{ route('admin.unit.create') }}" class="btn btn-primary btn-block">Add More</a>
              </center>
            </form>
          </div>
        </section>
      </section>
    </section>

    @endsection