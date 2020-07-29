
<!DOCTYPE html>
<html>
<head>
	<title>Log In as Admin</title>
	<link rel="stylesheet" href="{{ asset('css/backend/bootstrap.css') }}?ver=1.1">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/backend/global.css') }}?ver=1.1">
</head>
<body>
	

	<section class="container-fluid">
		<section class="row justify-content-center">
			<section class="col-12 col-sm-6 col-md-3">
				<form class="form-container" method="POST" action="{{ route('admin.login.submit') }}">
					@csrf
					<div class="container">
						<div class="text-center">
							<h2>Welcome to Sundarban LTD</h2>
						</div>
					</div>
				  	
				  	<div class="form-group">
				   		<label for="exampleInputUsername">Email</label>
						<input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
						 value="{{ old('email') }}" required autocomplete="email" autofocus>
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
						<input type="password"  name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password">
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
				  	
				  	<div class="form-group form-check">
				    	<input type="checkbox" class="form-check-input" id="exampleCheck1">
				    	<label class="form-check-label" for="exampleCheck1">Keep me logged in</label>
				  	</div>
				 
				  	<button type="submit" class="btn btn-success btn-block">Log In</button>

				  	<center>
					  	<div class="form-group form-writings">
					  		<a class="btn btn-danger btn-block" href="password_recover.html">Forgot your password?</a>
					  	</div>
				  	</center>
				</form>
			</section>
		</section>
	</section>


	



	<!-- JS, Popper.js, and jQuery -->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>