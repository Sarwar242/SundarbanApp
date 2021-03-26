@extends('backend.layouts.master')
@section('title','Companies in '.$data['location'])

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
				<h4 class="jumbotron jumbotron-fluid py-3">Companies in Category: {{$data['category']}} @if($data['subcategory']!='' && !is_null($data['subcategory']))> Subcategory: {{$data['subcategory']}} @endif  at {{$data['location']}}.</h4>
			</div>
		</center>
		<table id="dataTable" class="table">
		  <thead class="thead-dark">
			<tr>
				<th scope="col">#</th>
				<th scope="col">Code</th>
				<th scope="col">Name</th>
				<th scope="col">Name In Bangla</th>
				<th scope="col">Owners Name</th>
				<th scope="col">Phone</th>
                <th scope="col">Priority</th>
				<th scope="col">Logo</th>
				<th scope="col">Edit</th>
			  </tr>
		  </thead>
		  <tbody>
		    @foreach($companies as $company)
				<tr>
					<th scope="row">{{$loop->index+1}}</th>
					<td>{{$company->code}}</td>
                    @if(!is_null($company->slug))
					    <td style="cursor: pointer;" onclick="window.location.href='{{route('admin.company.profile',$company->slug)}}'">{{$company->name}}</td>
                    @else
					    <td style="cursor: pointer;" onclick="window.location.href='{{route('admin.company.profile',$company->id)}}'">{{$company->name}}</td>
                    @endif
					@if(!is_null($company->slug))
					    <td style="cursor: pointer;" onclick="window.location.href='{{route('admin.company.profile',$company->slug)}}'">{{$company->bn_name}}</td>
                    @else
					    <td style="cursor: pointer;" onclick="window.location.href='{{route('admin.company.profile',$company->id)}}'">{{$company->bn_name}}</td>
                    @endif
					<td>{{$company->owners_name}}</td>
					<td>{{$company->user->phone}}</td>
                    <td>
                        <select id="priority{{$company->id}}" name="priority{{$company->id}}" onChange="priorityToggle({{$company->id}})">
                                <option value="{{ is_null($company->priority) ? 12 : $company->priority}}" disabled selected>{{ is_null($company->priority) ? 12 : $company->priority}}</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                        </select>
                    </td>
					<td><img src="{{ asset('storage/company')}}/{{$company->image}}"
                        style="width:30px;" alt="company Image"></td>
					<td><a href="{{route('admin.company.update',$company->id)}}">Edit</a></td>

				</tr>
			@endforeach
		  </tbody>
		</table>
		{{-- {!! App\Models\Company::companies()->render() !!} --}}
	</div>


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

    @section('scripts')

    <script>
        function priorityToggle(id){
            var e = $("#priority"+id+" :selected").val();
            // console.log( e);
            $.get(""+myapplink+"/admin/api/company/priority", {id:id, priority:e})
            .done(function(data) {
                data = JSON.parse(data);
                // console.log(data);
                if (data.status == 'success') {
                    $("#priority").load(window.location.href + " #priority");
                }
            });
        }
    </script>
    @endsection
