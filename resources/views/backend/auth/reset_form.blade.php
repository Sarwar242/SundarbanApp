<!DOCTYPE html>
<html>
<head>
  <title>Reset Password</title>
  <link rel="stylesheet" href="{{ asset('css/backend/bootstrap.css') }}?ver=1.1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="{{asset('css/backend/sidebar.css')}}?ver=1.1">
  <link rel="stylesheet" type="text/css" href="{{asset('css/backend/global.css')}}?ver=1.1">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
</head>
<body>


  <section class="container-fluid">

    <section class="row justify-content-center">

      <section class="col-12 col-sm-6 col-md-3">

          <form id="loginform" class="form-container" method="post" action="{{ route('admin.password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="container">
                <div class="text-center">
                    <h2>Reset Your Password</h2>
                    @if(Session::has('failedx'))
                        <div class="alert alert-error alert-block">
                            <button type="button" class="close" data-dismiss="alert">
                                x
                            </button>
                            <strong>
                                {!! session('failedx') !!} @php Session::forget('failedx') @endphp
                            </strong>
                        </div>
                    @endif
                </div>
                <p class="text-center">Enter your e-mail address and new Password and Confirm password to reset your
                    password..</p>
            </div>
            <div class="form-group">
                <label for="Email">Email</label>
                <input type="email" name="email" placeholder="Email"
                    value="{{ $email ?? old('email') }}" class="form-control @error('email') is-invalid @enderror" required autocomplete="email" autofocus />
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="Password">Password</label>
                <input type="password"
                    name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" />
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
             <div class="form-group">
                <label for="Password Confirmation">Confirm Password</label>
                <input type="password" class="form-control "
                            name="password_confirmation" placeholder="Confirm Password" />
             </div>
             <button type="submit" class="btn btn-success btn-block">Reset Password</button>
             <center>
                <div class="form-group form-writings">
                    <a class="btn btn-warning btn-block" style="color: white" href="{{route('admin.login')}}">Back to login</a>
                </div>
            </center>
        </form>
          </div>
        </section>
      </section>
    </section>

<!-- JS, Popper.js, and jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>
</html>
