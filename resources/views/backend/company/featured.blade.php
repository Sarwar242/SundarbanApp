@extends('backend.layouts.master')
@section('title','Featured Companies')

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
				<h4>Featured Companies </h4>
			</div>
		</center>
		<table id="dataTable" class="table">
		  <thead class="thead-dark">
			<tr>
				<th scope="col">#</th>
				<th scope="col">Name</th>
				<th scope="col">Days</th>
				<th scope="col">Expiring</th>
				<th scope="col">Activated</th>
				<th scope="col">Admin</th>
				<th scope="col">Update</th>
				<th scope="col">Delete</th>
			  </tr>
		  </thead>
		  <tbody>
		    @foreach(App\Models\Boost::latest()->get() as $boost)
				<tr>
					<th scope="row">{{$loop->index+1}}</th>
					<td>{{$boost->company->name}}</td>
					<td>{{$boost->days}}</td>
					<td>{{Carbon\Carbon::parse($boost->end_date)->format('d M Y') }}</td>
					<td>{{$boost->created_at->format('d M Y') }}</td>
					<td>{{$boost->admin->username}}</td>
					<td><span class="text-info" data-toggle="modal" style=" cursor: pointer;"  data-id="{{$boost->company->id}}"  id="mod{{$boost->id}}" data-target="#modal1">Update</span></td>

					<td><a class="delete"  data-confirm="Are you sure to delete the boost?" href="{{route('admin.company.boost.delete',$boost->id)}}">Delete</a></td>
                    <div class="modal" id="modal1" tabindex="-1" data-backdrop="false" role="dialog">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Add More Days</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            {{-- <form method="POST" name="form1">
                                @csrf --}}
                                <div class="modal-body">
                                <input type="number" style="width: 100%;" name="days" id="days">
                                </div>
                                <div class="modal-footer">
                                <button type="submit" id="submit" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            {{-- </form> --}}
                          </div>
                        </div>
                      </div>
				</tr>

			@endforeach
		  </tbody>
		</table>
		{{-- {!! App\Models\Company::companies()->render() !!} --}}
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

        $('#modal1').on('shown.bs.modal', function () {
            $('#days').trigger('focus');
        });

	</script>
    <script>
        $(document).ready(function() {

        $('span[data-toggle=modal], button[data-toggle=modal]').click(function () {

        var data_id = '';
        var days=0;

        if (typeof $(this).data('id') !== 'undefined') {

            data_id = $(this).data('id');
            console.log(data_id);
        }

        $('#submit').on('click', function() {
            days =$('#days').val();
            console.log(days);
            $.post(""+myapplink+"/admin/company/boost/"+data_id,
                {
                    '_token': $('meta[name=csrf-token]').attr('content'),
                    'days':days,
                })
                .done(
                    function(data) {
                        location.reload();
            });

        });
            });
        });
    </script>
@endsection
