@extends('backend.layouts.master')
@section('title','News')

@section('contents')
@include('backend.layouts.sidebar')
<body>

	<div class="content">
		@if(Session::has('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" style="top: 0 !important;" data-dismiss="alert">
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
				<h4>News Links</h4>
			</div>
		</center>
        <div class="float-md-right">
            <button class="btn btn-sm btn-success" data-toggle="modal" style="cursor: pointer;"  id="mod" data-target="#modal1">Add New</button>
        </div>
		<table id="dataTable" class="table">
		  <thead class="thead-dark">
			<tr>
				<th scope="col">#</th>
				{{-- <th scope="col">Title</th> --}}

				<th scope="col">URL</th>
				<th scope="col">Created</th>
                <th scope="col">Admin</th>
				<th scope="col">Update</th>
				<th scope="col">Delete</th>
                <th scope="col"></th>
			  </tr>
		  </thead>
		  <tbody>
            @foreach (App\Models\News::latest()->get() as $news)
				<tr>
					<th scope="row">{{$loop->index+1}}</th>
					{{-- <td>{{$news->title}}</td> --}}

					<td style="max-width:260px; word-break: break-all;">{{$news->url}}</td>
					<td>
                        <small class="d-inline-block ml-1">{{$news->created_at->format('g:ia')}}</small>
                        @if (\Carbon\Carbon::parse($news->created_at)->toDateString() === date('Y-m-d')) {{ __('Today') }}
                        @elseif (\Carbon\Carbon::parse($news->created_at)->toDateString() === date('Y-m-d', strtotime('-1 day'))){{ __('Yesterday') }}
                        @else {{$news->created_at->format('d M, Y')}}
                        @endif

                    </td>
                    <td>{{$news->admin ? $news->admin->username: 'Not Available'}}</td>
					<td><a href="{{route('admin.news.update',$news->id)}}" class="text-info" style="cursor: pointer;">Update</a></td>

					<td><a class="delete"  data-confirm="Are you sure to delete the News Link?" href="{{route('admin.news.delete',$news->id)}}">Delete</a></td>
                    <td></td>

				</tr>

            @endforeach
		  </tbody>
		</table>
		{{-- {!! App\Models\Company::companies()->render() !!} --}}
	</div>
    <div class="modal" id="modal1" tabindex="-1" data-backdrop="false" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Add URL</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            {{-- <form method="POST" name="form1">
                @csrf --}}
                <div class="modal-body">
                    <input type="url" name="url" id="url"
                    placeholder="https://example.com" size="30"
                    required>
                </div>
                <div class="modal-footer">
                <button type="submit" id="submit" class="btn btn-primary">Add</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            {{-- </form> --}}
          </div>
        </div>
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
            $('#url').trigger('focus');
        });

	</script>
    <script>
        $(document).ready(function() {

        $('span[data-toggle=modal], button[data-toggle=modal]').click(function () {

        var url = '';
        $('#submit').on('click', function() {
            url =$('#url').val();
            console.log(url);
            $.get(""+myapplink+"/admin/news/create/",
                {
                    '_token': $('meta[name=csrf-token]').attr('content'),
                    'url':url,
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
