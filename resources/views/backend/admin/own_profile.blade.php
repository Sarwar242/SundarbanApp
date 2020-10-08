@extends('backend.layouts.master')
@section('title','Admin Profile')

@section('contents')
@include('backend.layouts.sidebar')
<br>
    <div class="container emp-profile content">
        <form method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img id="admin_img" src="{{ asset('storage/admin')}}/{{$admin->image}}" alt="" style="width:100%;max-width:300px"/>
                        <div id="admin_modal" class="modal">
                            <span class="close">&times;</span>
                                <img class="modal-content" id="img01">
                            <div id="caption"></div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="profile-head">
                            <h5>
                                &nbsp; &nbsp; &nbsp; &nbsp;    {{$admin->first_name}} {{$admin->last_name}}
                            </h5>
                            <div class="col-md-12">
                                <div class="profile-work">
                                    <p><strong>About</strong></p>
                                    <textarea class="description" maxlength="150" rows="3" cols="30" name="description" disabled>{{$admin->about}}</textarea>

                                </div>
                            </div>
                        </div>
                    </div> 
                    {{-- <div class="col-md-1">
                        <label class="switch">
                            <input type="checkbox">
                            <span class="slider round"></span>
                        </label>
                    </div>   --}}
                </div>

<br>
<br>
<br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Username</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$admin->username}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>First Name</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$admin->first_name}}</p>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Last Name</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$admin->last_name}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Email</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$admin->email}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Phone</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$admin->phone1}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Phone(2)</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$admin->phone2}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Type</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$admin->type}}</p>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>NID Number</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$admin->nid}}</p>
                                    </div>
                                </div>    
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Location</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$admin->location}}</p>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Street</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$admin->street}}</p>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Zip Code</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$admin->zipcode}}</p>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Division</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($admin->division))
                                            <p>{{$admin->division->name}}</p>
                                        @endif
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>District</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($admin->district))
                                            <p>{{$admin->district->name}}</p>
                                        @endif
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Upazilla</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($admin->upazilla))
                                            <p>{{$admin->upazilla->name}}</p>
                                        @endif
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Union</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($admin->union))
                                            <p>{{$admin->union->name}}</p>
                                        @endif
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Added by</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($admin->admin))
                                            <p onclick="window.location.href='{{route('admin.profile', $admin->admin->username)}}'" style="cursor: pointer">{{$admin->admin->username}}</p>
                                        @endif
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Working Since</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($admin->created_at))
                                            <p>{{$admin->created_at->format('M Y') }}</p>
                                        @endif
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </form>           
    </div>
    <script>
            
        var modal = document.getElementById("admin_modal");

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var img = document.getElementById("admin_img");
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");
        img.onclick = function(){
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.alt;
        }

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
        modal.style.display = "none";
        }

    </script>
@endsection