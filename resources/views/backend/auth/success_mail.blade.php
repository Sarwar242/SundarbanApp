<!DOCTYPE html>
<html>
<head>
  <title>Email Sent!</title>

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
            <div class="text-center">
              <h2>A link has been sent to your E-mail.</h2>
              <h4> Please check and follow the instructions.</h4>
            </div>
          </div>
            <form>
              <center>
                <a href="{{route('admin.login')}}" class="btn btn-primary">Go to Log In</a>
              </center>

              <center>

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
