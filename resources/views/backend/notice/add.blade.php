@extends('backend.layouts.master')
@section('title','Add Notice')

@section('contents')
@include('backend.layouts.sidebar')
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
                    {!! session('success')!!}   @php Session::forget('success') @endphp &nbsp;&nbsp;
                    @if(!is_null($notice)) <a href="{{route('admin.notice.update',$notice)}}">Edit</a> @endif
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
            <div class="text-center">
              <h2>Add Notice</h2>
            </div>
          </div>

            <form  method="POST" action="{{ route('admin.notice.create.submit') }}" enctype="multipart/form-data" novalidate="novalidate">
              @csrf
              <div class="form-group">
                <label for="Title">Title</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                 id="title" placeholder="Title ...">
                @error('title')
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
                <label for="type">Type</label>
                <select class="select2 form-control @error('type') is-invalid @enderror"  name="type" >
                  <option value="" selected='selected' disabled>
                    Select a Type</option>
                    <option value="General">General</option>
                    <option value="Warning">Warning</option>
                    <option value="News">News</option>
                    <option value="Announcement">Announcement</option>
                    <option value="Offer">Offer</option>
                </select>
                @error('type')
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
                <label for="for">For</label>
                <select class="select2 form-control @error('for') is-invalid @enderror" id="for" required name="for" >
                  <option value="" selected='selected' disabled>
                    Notice for</option>
                    <option value="Company">Company</option>
                    <option value="Customer">Customer</option>
                    <option value="Admin">Admin</option>
                    <option value="Users">Users</option>
                    <option value="Companies">Companies</option>
                    <option value="Customers">Customers</option>
                    <option value="Admins">Admins</option>
                    <option value="Non-Registerd">Non-Registerd</option>
                </select>
                @error('type')
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
                <label for="Recipient">Recipient</label>
                <select class="select2 form-control" name="user_id" id="recipient">
                </select>
              </div>

              <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" name="description"  rows="3" placeholder="Write description..."></textarea>
                @error('description')
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
             
              <center>
                <input type="submit" class="btn btn-success btn-block" value="Submit">
                <a href="{{ route('admin.notice.create') }}" class="btn btn-primary btn-block">Add More</a>
              </center>
            </form>
          </div>
        </section>
      </section>
    </section>


    <script src="{{ asset('js/backend/jquery.min.js')}}"></script>
    <script>
       $(document).on('change','#for',function(){
        var for_ = $("#for").val();
        $("#recipient").html("");
        var option = " ";
    //send an ajax req to servers
    if(for_ == "Company"){
        $.get(""+myapplink+"/admin/get-companies",
        function(data) {
            option = "<option selected disabled>select one</option>";
            var d = JSON.parse(data);
            d.forEach(function(element) {
                console.log(element.id);
                option += "<option value='" + element.id + "'>" + element.name + "</option>";
            });

            $("#recipient").html(option);
            }); 
        }
        else if(for_ == "Customer"){
        $.get(""+myapplink+"/admin/get-customers",
        function(data) {
            option = "<option selected disabled>select someone</option>";
            var d = JSON.parse(data);
            d.forEach(function(element) {
                console.log(element.id);
                option += "<option value='" + element.id + "'>" + element.username + "</option>";
            });

            $("#recipient").html(option);
            }); 
        }
        else if(for_ == "Admin"){
        $.get(""+myapplink+"/admin/get-admins",
        function(data) {
            option = "<option selected disabled>select someone</option>";
            var d = JSON.parse(data);
            d.forEach(function(element) {
                console.log(element.id);
                option += "<option value='" + element.id + "'>" + element.username + "</option>";
            });

            $("#recipient").html(option);
            }); 
        }
        else{
    
            option = "<option selected disabled>All "+
                for_+" Selected</option>";
            $("#recipient").html(option);
        }
    });
    </script>

    @endsection
