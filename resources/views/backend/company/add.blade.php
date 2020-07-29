@extends('backend.layouts.master')


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
              <h2>Add Company</h2>
            </div>
          </div>

            <form  method="POST" action="{{ route('admin.user.create.submit') }}" enctype="multipart/form-data" novalidate="novalidate">
              @csrf
              <div class="form-group">
                <label for="exampleFormControlInput1">Company Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="Name Here">
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
                <input type="text" name="bn_name" class="form-control @error('bn_name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="">
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
                <label for="exampleFormControlInput1">Owner's Name</label>
                <input type="text" name="owners_name" class="form-control @error('owners_name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="128vxc">
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
                <label for="exampleInputUsername">Email</label>
                <input type="email" name="email" class="form-control" required autocomplete="email" >
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
                <label for="exampleInputPassword1">Password</label>
                <input type="password"  name="password" class="form-control @error('password') is-invalid @enderror" required>
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
                <input type="password"  name="password_confirmation" class="form-control @error('password') is-invalid @enderror" required>
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

@endsection