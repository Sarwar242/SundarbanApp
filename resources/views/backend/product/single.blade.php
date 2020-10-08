@extends('backend.layouts.master')
@section('title',$product->name)

@section('contents')
@include('backend.layouts.sidebar')
<br>
    <div class="container emp-profile content" style="position: relative;">
        <div>
            @if(!is_null($product->images))
            
            <div class="row" id="gallery" data-toggle="modal" data-target="#exampleModal">    
                @foreach ($product->images as $image)

                <div class="col-12 col-sm-6 col-lg-3">
                    <img  class="w-100" src="{{asset('storage/product')}}/{{$image->image}}"  data-slide-to="{{$loop->index}}">
                    <button type="button" class="pimg delete" data-confirm="Are you sure to delete this item?" href="{{route('admin.product.image.delete', $image->id)}}"> 
                        <i class="fa fa-trash"></i></button>
                </div>
                
                @endforeach     
            </div>
            @endif
        <br>
        <br>
                <form method="post" action="{{ route('admin.product.image.store', $product->id) }}" enctype="multipart/form-data" novalidate="novalidate">
                    @csrf
                    <div>
                        <Strong>Upload Image:</Strong> 
                        <input type="file" name="image[]" class="@error('image') is-invalid @enderror" multiple >
                        <input type="submit" value="Upload" class="btn btn-success">
                        @error('image')
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
                </form>
         
<br>
<br>
<br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Product Name</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$product->name}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Product Code</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$product->code}}</p>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Price</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$product->price}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Quantity</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$product->quantity}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Type</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$product->type}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Product Unit</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($product->unit))
                                            <p>{{$product->unit->name}}</p>
                                        @endif
                                    </div>
                                </div> 
                            
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Product Category</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($product->category))
                                            <p>{{$product->category->name}}</p>
                                        @endif
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Product Subcategory</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($product->subcategory))
                                            <p>{{$product->subcategory->name}}</p>
                                        @endif
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Company</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($product->company))
                                            <p>{{$product->company->name}}</p>
                                        @endif
                                    </div>
                                </div> 
                              
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Added by</label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($product->admin))
                                            <p onclick="window.location.href='{{route('admin.profile', $product->admin->username)}}'" style="cursor: pointer">{{$product->admin->username}}</p>
                                        @endif
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Added </label>
                                    </div>
                                    <div class="col-md-6">
                                        @if(!is_null($product->created_at))
                                            <p>{{$product->created_at->format('d M Y') }}</p>
                                        @endif
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-work">
                            <h4><strong>Description</strong></h4>
                            <textarea class="description" maxlength="150" rows="3" cols="30" name="description" disabled>{{$product->description}}</textarea>

                        </div>
                    </div>
                </div>
        </div>         
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