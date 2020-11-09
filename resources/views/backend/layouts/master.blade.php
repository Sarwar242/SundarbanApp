<!DOCTYPE html>
<html>
<head>
	<title>Egol.com.bd || @yield('title')</title>
	<link rel="stylesheet" href="{{ asset('css/backend/bootstrap.css') }}?ver=1.1">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/backend/global.css') }}?ver=1.1">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/backend/profile.css') }}?ver=1.1">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/backend/slider.css') }}?ver=1.1">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/backend/product.css') }}?ver=1.1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/backend/sidebar.css') }}?ver=1.1">
	<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
		<!-- Datatables css-->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/autofill/2.3.5/css/autoFill.bootstrap4.css"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/3.3.1/css/fixedColumns.bootstrap4.min.css"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/scroller/2.0.2/css/scroller.bootstrap4.min.css"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/searchpanes/1.1.1/css/searchPanes.bootstrap4.min.css"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.1/css/select.bootstrap4.min.css"/>
	
	{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"/> --}}
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"></script>
	
	<!-- Select2 css-->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

	<style>.select2-container, .select2-dropdown, .select2-search, .select2-results {
		-webkit-transition: none !important;
		-moz-transition: none !important;
		-ms-transition: none !important;
		-o-transition: none !important;
		transition: none !important;
	}
	</style>

	
	<script src="{{ asset('js/backend/jquery.min.js') }}" ></script>
	<script src="{{ asset('js/server.js') }}" ></script>


	<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
	{{-- <script src="{{ asset('js/backend/jquery-3.3.1.min.js')}}"></script> --}}
</head>
<body>

	<input type="checkbox" id="check">

	<header>
		<label for="check">
			<i class="fa fa-bars" id="sidebar-btn"></i>
		</label>
		<div class="left-area">
			<h3>Egol<span>.com.bd</span></h3>
		</div>

		<div class="right-area">
			
			<a href="{{route('admin.logout')}}" class="btn btn-primary btn-sm">Logout</a>

			<div class="user" onclick="window.location.href='{{route('admin.profile.own')}}'" style="cursor: pointer">
				<img src="{{ asset('storage/admin')}}/{{Auth::guard('admin')->user()->image}}" class="user-image" alt=" ">
			<h4 class="user-name">{{Auth::guard('admin')->user()->username}}</h4>
			</div>
			
		</div>
	</header>


	@yield('contents')
	{{-- image preview --}}
	<script>
		function showImgPreview(event){
		if (event.target.files.length>0) {
			var src = URL.createObjectURL(event.target.files[0]);
			var preview = document.getElementById("img-preview");
			preview.src = src;
			preview.style.display = "block";
			preview.style.maxWidth= "200px";
			preview.style.marginLeft= "60px";
			preview.style.marginTop= "5px";
			preview.style.paddingLeft= "10px";	
		}
	}
	</script>

	
			<!-- Datatables js-->
			

<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/autofill/2.3.5/js/dataTables.autoFill.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/autofill/2.3.5/js/autoFill.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/3.3.1/js/dataTables.fixedColumns.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/scroller/2.0.2/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/searchpanes/1.1.1/js/dataTables.searchPanes.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/searchpanes/1.1.1/js/searchPanes.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>


<script type="text/javascript">
	$(document).ready(function() {
		$('#dataTable').DataTable({
			responsive: true,
			'aoColumnDefs': [{
        'bSortable': false,
        'aTargets': [-1,-2, -3] /* 1st one, start by the right */
    }]
		});
	});
</script>
	<!-- Select2 JS-->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
	$(document).ready(function() {
	  $('.select2').select2({
		theme: "classic"
		//allowClear: true
	});

  });
</script>
  


<!-- JS, Popper.js, and jQuery -->
	
	{{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> --}}
	
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

</body>
</html>
