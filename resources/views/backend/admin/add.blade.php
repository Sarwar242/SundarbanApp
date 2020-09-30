@extends('backend.layouts.master')
@section('title','Add Admin')

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
                  @if(!is_null($profile))<a href="{{route('admin.admin.update',$profile)}}">Edit</a>@endif
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
              <h2>Add Admin</h2>
            </div>
          </div>

            <form  method="POST" action="{{ route('admin.admin.create.submit') }}" enctype="multipart/form-data" novalidate="novalidate">
              @csrf
              <div class="form-group">
                <label for="exampleFormControlInput1">First Name</label>
                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" id="firstname" placeholder="First Name Here">
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
                <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" id="lastname" placeholder="Last Name Here">
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
                <label for="exampleInputUsername">Email</label>
                <input type="email" name="email" placeholder="Type an Email..." class="form-control" required autocomplete="email" >
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
                <label for="type">Type</label>
                 <select class="form-control @error('type') is-invalid @enderror" name="type" >      
                    <option value="" selected='selected' disabled>
                      Select one</option>
                      <option value="Admin">
                        Admin</option> 
                      <option value="Super Admin">
                        Super Admin</option>      
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
                <label for="Password Confirmation">Password Confirm</label>
                <input type="password"  name="password_confirmation" placeholder="Type the password again..." class="form-control @error('password') is-invalid @enderror" required>
              </div>


              <center>
                <input type="submit" class="btn btn-success btn-block" value="Submit">
                <a href="{{route('admin.admin.create')}}" class="btn btn-primary btn-block">Add New</a>
              </center>
            </form>
          </div>
        </section>
      </section>
    </section>

@endsection