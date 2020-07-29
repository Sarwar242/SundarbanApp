<!DOCTYPE html>
<html>
<head>
	<title>Sundarban - Homepage</title>
	<link rel="stylesheet" href="{{ asset('css/backend/bootstrap.css') }}?ver=1.1">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/backend/global.css') }}?ver=1.1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/backend/sidebar.css') }}?ver=1.1">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"></script>
	{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script> --}}
	<script type="text/javascript">
		const myapplink = "http://192.168.43.131:8000";
	</script>
	<script src="{{ asset('js/backend/jquery.min.js') }}" ></script>
	{{-- <script src="{{ asset('js/backend/jquery-3.3.1.min.js')}}"></script> --}}
</head>
<body>

	<input type="checkbox" id="check">

	<header>
		<label for="check">
			<i class="fa fa-bars" id="sidebar-btn"></i>
		</label>
		<div class="left-area">
			<h3>Sundarban<span>.com</span></h3>
		</div>

		<div class="right-area">
			
			<a href="{{route('admin.logout')}}" class="btn btn-primary btn-sm">Logout</a>

			<div class="user">
				<img src="{{ asset('storage/admin')}}/{{Auth::guard('admin')->user()->image}}" class="user-image" alt=" ">
			<h4 class="user-name">{{Auth::guard('admin')->user()->username}}</h4>
			</div>
			
		</div>
	</header>


    @yield('contents')
	
	
	<!-- JS, Popper.js, and jQuery -->
	
	{{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> --}}
	
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

	
</body>
</html>
