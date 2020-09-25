@extends('backend.layouts.master')
@section('title','Add Customer')

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
                  {!! session('success')!!}   @php Session::forget('success') @endphp &nbsp;&nbsp; 
                  @if(!is_null($profile))<a href="{{route('admin.customer.update',$profile)}}">Edit</a>@endif
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
              <h2>Add Customer</h2>
            </div>
          </div>

            <form  method="POST" action="{{ route('admin.user.create.submit') }}" enctype="multipart/form-data" novalidate="novalidate">
              @csrf
              <div class="form-group">
                <label for="exampleFormControlInput1">First Name</label>
                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="First Name Here">
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
                <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="Last Name Here">
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
                <label for="exampleFormControlInput1">Phone</label>
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="exampleFormControlInput1" placeholder="Pease type a valid phone no...">
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
                <label for="exampleInputUsername">Email</label>
                <input type="email" name="email" placeholder="Type an Email [Optional]" class="form-control" required autocomplete="email" >
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

              <input type="hidden" name="is_company" value="0">

              <center>
                <input type="submit" class="btn btn-success btn-block" value="Submit">
                <a href="{{route('admin.customer.create')}}" class="btn btn-primary btn-block">Add New</a>
              </center>
            </form>
          </div>
        </section>
      </section>
    </section>

@endsection