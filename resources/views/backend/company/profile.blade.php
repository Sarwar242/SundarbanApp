@extends('backend.layouts.master')
@section('title',$company->name)

@section('contents')
@include('backend.layouts.sidebar')
<br>
    <div class="container emp-profile content">
        <form method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img id="admin_img" src="{{ asset('storage/company')}}/{{$company->image}}" alt="" style="width:100%;max-width:300px"/>
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
                                &nbsp; &nbsp; &nbsp; &nbsp;    {{$company->name}}
                            </h5>
                            <div class="col-md-12">
                                <div class="profile-work">
                                    <p><strong>Description</strong></p>
                                    <textarea class="description" maxlength="150" rows="3" cols="30" name="description" disabled>{{$company->description}}</textarea>

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
                                        <label>Code</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$company->code}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Company Owner</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$company->owners_name}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Company Owner's NID</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$company->owners_nid}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Company Email</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$company->user->email}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Company Phone</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$company->user->phone}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Contact No1</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$company->phone1}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Contact No2</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$company->phone2}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Contact Status</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if($company->phone_hide==1) <p>Hidden</p> @else <p>Shown</p> @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Company Type</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$company->type}}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Location</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$company->location}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Street</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$company->street}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Zip Code</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$company->zipcode}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Division</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($company->division))
                                            <p>{{$company->division->name}}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>District</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($company->district))
                                            <p>{{$company->district->name}}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Upazilla</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($company->upazilla))
                                            <p>{{$company->upazilla->name}}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Union</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($company->union))
                                            <p>{{$company->union->name}}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Added by</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($company->admin))
                                            <p onclick="window.location.href='{{route('admin.profile', $company->admin->username)}}'" style="cursor: pointer">{{$company->admin->username}}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Added</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($company->created_at))
                                            <p>{{$company->created_at->format('M Y') }}</p>
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
