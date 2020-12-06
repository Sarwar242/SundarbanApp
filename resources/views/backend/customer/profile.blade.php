@extends('backend.layouts.master')
@section('title',$customer->username)

@section('contents')
@include('backend.layouts.sidebar')
<br>
    <div class="container emp-profile content">
        <form method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img id="admin_img" src="{{ asset('storage/customer')}}/{{$customer->image}}" alt="" style="width:100%;max-width:300px"/>
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
                                &nbsp; &nbsp; &nbsp;  {{$customer->first_name}} {{$customer->last_name}}
                            </h5>
                            <div class="col-md-12">
                                <div class="profile-work">
                                    <p><strong>About</strong></p>
                                    <textarea class="description" maxlength="150" rows="3" cols="30" name="description" disabled>{{$customer->about}}</textarea>

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
                                        <p>{{$customer->username}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>First Name</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$customer->first_name}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Last Name</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$customer->last_name}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Email</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$customer->user->email}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Phone</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$customer->user->phone}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Phone(2)</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$customer->phone}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Contact Status</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if($customer->phone_hide==1) <p>Hidden</p> @else <p>Shown</p> @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Deate of Birth</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$customer->dob}}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label>NID Number</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$customer->nid}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Gender</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$customer->gender}}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Location</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$customer->location}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Street</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$customer->street}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Zip Code</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$customer->zipcode}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Division</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($customer->division))
                                            <p>{{$customer->division->name}}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>District</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($customer->district))
                                            <p>{{$customer->district->name}}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Upazilla</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($customer->upazilla))
                                            <p>{{$customer->upazilla->name}}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Union</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($customer->union))
                                            <p>{{$customer->union->name}}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Added by</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($customer->admin))
                                            <p onclick="window.location.href='{{route('admin.profile', $customer->admin->username)}}'" style="cursor: pointer">{{$customer->admin->username}}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Joined </label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($customer->created_at))
                                            <p>{{$customer->created_at->format('M Y') }}</p>
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
