@extends('backend.layouts.master')
@section('title','Boost History')

@section('contents')
@include('backend.layouts.sidebar')
<body>

	<div class="content">
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
                    {!! session('failed') !!}
                </strong>
            </div>
        @endif
		<center>
			<div class="heading">
				<h4>Boost Histories</h4>
			</div>
		</center>
		<table id="dataTable" class="table">
		  <thead class="thead-dark">
			<tr>
				<th scope="col">#</th>
				<th scope="col">Name</th>
				<th scope="col">Days</th>
				<th scope="col">Expiree</th>
				<th scope="col">Activated</th>
				<th scope="col">Admin</th>
				<th scope="col">Message</th>
				<th scope="col">Delete</th>
                <th></th>
			  </tr>
		  </thead>
		  <tbody>
		    @foreach(App\Models\Boost_Record::latest()->get() as $boost)
				<tr>
					<th scope="row">{{$loop->index+1}}</th>
					<td>{{$boost->company? $boost->company->name: ''}}</td>
					<td>{{$boost->days}}</td>
					<td>{{Carbon\Carbon::parse($boost->end_date)->format('d M Y') }}</td>
					<td>{{$boost->created_at->format('d M Y') }}</td>
					<td>{{$boost->admin->username}}</td>
					<td style="max-width:250px;">{!!$boost->message!!}</td>
					<td><a class="delete"  data-confirm="Are you sure to delete this record?" href="{{route('admin.company.record.delete',$boost->id)}}">Delete</a></td>
                    <td></td>
				</tr>

			@endforeach
		  </tbody>
		</table>
	</div>

{{-- @endsection

@section('scripts') --}}
<script src="{{ asset('js/backend/jquery.min.js')}}"></script>
	<script>
		var deleteLinks = document.querySelectorAll('.delete');

		for (var i = 0; i < deleteLinks.length; i++) {
			deleteLinks[i].addEventListener('click', function(event) {
				event.preventDefault();

				var choice = confirm(this.getAttribute('data-confirm'));

				if (choice) {
					window.location.href = this.getAttribute('href');
				}
			});
		}

	</script>
@endsection
