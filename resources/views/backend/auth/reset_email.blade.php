<!DOCTYPE html>
<html>
<head>
  <title>Recover Password</title>
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
        <div class="form-container">
          <div class="container">
            @if(Session::has('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">
                    x
                </button>
                <strong>
                  {!! session('success')!!}   @php Session::forget('success') @endphp
                </strong>
            </div>
        @endif
        @if(Session::has('failed'))

            <div class="alert alert-error alert-block">
                <button type="button" class="close" data-dismiss="alert">
                    x
                </button>
                <strong>
                    {!! session('failed') !!}  @php Session::forget('failed') @endphp
                </strong>
            </div>
        @endif
            <div class="text-center">
              <h2>Recover your password</h2>
            </div>
          </div>

            <form method="POST" action="{{ route('admin.password.email') }}">
              @csrf
              <div class="form-group">
                <label for="exampleFormControlInput1">E-mail</label>
                <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="Ex : someone@gmail.com">
              </div>

              <center>
                <button type="submit" style="color:black;" class="btn btn-primary">Submit</button>
              </center>

              <center>
              <div class="form-group form-writings">
                <a href="{{route('admin.login')}}">Go to Log In</a>
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
