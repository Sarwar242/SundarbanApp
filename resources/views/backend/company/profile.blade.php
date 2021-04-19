@extends('backend.layouts.master')
@section('title',$company->name)

@section('contents')
@include('backend.layouts.sidebar')
<br>
    <div class="container emp-profile content">
        <div>
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
                <div class="col-md-1"></div>
                <div class="col-md-4 mt-2">
                    <div class="profile-head  mt-4 pt-4">
                        <h3 class="font-weight-bold">
                            &nbsp; &nbsp; &nbsp;    {{$company->name}}
                        </h3>
                    </div>
                </div>

                    <div class="col-md-2 mt-5">
                        @if (!$company->boost || (!is_null($company->boost) && Carbon\Carbon::today() > Carbon\Carbon::parse($company->boost['end_date'])))
                        <form action="{{route('admin.company.boost',$company->id)}}" class="form mt-5" method="post">
                            @csrf
                            <input class="mt-5"  style="width: 88px;" type="number" min="1" max="365" name="days" placeholder="add days" required>
                            <input type="submit" class="btn btn-success btn-sm" value="Boost">
                        </form>
                        @else
                        <label class="switch ml-4 mt-3" data-toggle="tooltip" data-placement="bottom" title="Boosted">
                            <input type="checkbox" checked disabled>
                            <span class="slider round" style="background-color: green !important;"></span>
                        </label>
                        @endif
                    </div>
                    <div class="col-md-1"></div>
                    {{-- <div class="col-md-2">
                        <label class="switch">
                            <input type="checkbox">
                            <span class="slider round"></span>
                        </label>
                    </div> --}}
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
                                        <label>Subcategory</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($company->subcategory))
                                            <p>{{$company->subcategory->name}}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Category</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($company->category))
                                            <p>{{$company->category->name}}</p>
                                        @endif
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
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Edit</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p><a href="{{route('admin.company.update',$company->id)}}">Edit</a></p>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="profile-work my-2 py-2 px-4 mx-2">
                                <h4><strong>Description</strong></h4>
                                <p style="font-size:14px;">{{$company->description}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
