

@extends('backend.layouts.master')


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
                    {!! session('success') !!}
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
              <h2>Edit Product</h2>
            </div>
          </div>

            <form  method="POST" action="{{ route('admin.product.update.submit',$product->id) }}" enctype="multipart/form-data" novalidate="novalidate">
              @csrf
              <div class="form-group">
                <label for="Name">Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
              value="{{$product->name}}" placeholder="Xiaomi Note 7 Pro">
                @error('name')
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
                <label for="exampleFormControlInput1">Name in Bangla</label>
                <input type="text" name="bn_name" value="{{$product->bn_name}}" class="form-control  @error('bn_name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="">
                @error('bn_name')
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
                <label for="exampleFormControlInput1">Code</label>
                <input type="text" name="code"  value="{{$product->code}}"  class="form-control @error('code') is-invalid @enderror" placeholder="Product Code">
                @error('code')
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
                <label for="exampleFormControlInput1">Price</label>
                <input type="number" name="price" value="{{$product->price}}"  class="form-control @error('price') is-invalid @enderror"  placeholder="">
                @error('price')
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
                <label for="exampleFormControlInput1">Quantity</label>
                <input type="number" name="quantity" value="{{$product->quantity}}"  class="form-control @error('quantity') is-invalid @enderror" placeholder="">
                @error('quantity')
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
                <label for="exampleFormControlInput1">Discount</label>
                <input type="number" name="discount" value="{{$product->discount}}"  class="form-control @error('discount') is-invalid @enderror" placeholder="">
                @error('discount')
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
                <label for="exampleFormControlSelect1">In Unit</label>
                <select class="form-control @error('unit_id') is-invalid @enderror" name="unit_id">
  
                  @foreach(App\Models\Unit::all() as $unit)

                  @if($product->unit->id==$unit->id)
                  <option value="{{$unit->id}}" selected>
                      {{$unit->name}}</option>
                  @else
                  <option value="{{$unit->id}}">
                      {{ $unit->name}}</option>
                  @endif
                @endforeach
                </select>
                @error('unit_id')
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
                <label for="exampleFormControlSelect1">Category</label>
                <select class="form-control @error('category_id') is-invalid @enderror" name="category_id"  id="category_id" >
                  @foreach(App\Models\Category::all() as $category)
                    @if($product->category->id==$category->id)
                    <option value="{{ $category->id }}" selected>
                        {{$category->name}}</option>
                    @else
                    <option value="{{ $category->id }}">
                        {{ $category->name}}</option>
                    @endif
                  @endforeach
                </select>
                @error('category_id')
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
                <label for="exampleFormControlSelect1">Sub-Category</label>
                <select class="form-control @error('subcategory_id') is-invalid @enderror" id="subcategory_id" >
                  @if(!is_null($product->subcategory))
                    <option value="{{$product->subcategory->id}}" selected>
                      {{$product->subcategory->name}}</option>
                  @endif
                </select>
                @error('subcategory_id')
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
                <label for="exampleFormControlSelect1">Company</label>
                <select class="form-control @error('company_id') is-invalid @enderror" name="company_id">
                  @if(!is_null($product->company))
                    @foreach(App\Models\Company::all() as $company)

                      @if($product->company->id==$company->id)
                      <option value="{{$company->id}}" selected>
                          {{$company->name}}</option>
                      @else
                      <option value="{{$company->id}}">
                          {{ $company->name}}</option>
                      @endif
                    @endforeach
                  @else
                    <option value="" selected='selected' disabled>
                      Optional</option>
                    @foreach(App\Models\Company::all() as $company)
                    <option value="{{$company->id}}">{{$company->name}}</option>
                    @endforeach
                  @endif
                </select>
                @error('company_id')
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

              {{-- <div class="form-group">
                <label for="exampleFormControlFile1">Upload Image</label>
                <input type="file" name="image[]" class="form-control @error('image') is-invalid @enderror" multiple >
              
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
              </div> --}}
              
              <div class="form-group">
                <label for="exampleFormControlTextarea1">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                name="description" rows="3" placeholder="Write something about Product...">{!!$product->description!!}</textarea>
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

              <div class="form-group">
                <label for="exampleFormControlTextarea1">Description in Bangla</label>
                <textarea class="form-control @error('bn_description') is-invalid @enderror"
                 name="bn_description"  value="{{$product->bn_description}}"  rows="3" placeholder="Write something about Product...">{!!$product->bn_description!!}</textarea>
              
                @error('bn_description')
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
                <input type="submit" value="Submit" class="btn btn-success btn-block">
                <a href="#" class="btn btn-primary btn-block">Add More</a>
              </center>
            </form>
          </div>
        </section>
      </section>
    </section>


    <script src="{{ asset('js/backend/jquery.min.js')}}"></script>
    <script>
       $(document).on('change','#category_id',function(){

        var category = $("#category_id").val();
        $("#subcategory_id").html("");
        var option = " ";
    //send an ajax req to servers
        $.get(""+myapplink+"/admin/get-subcategories/" +
        category,
        function(data) {
          option = "<option selected disabled>Select one</option>";
            var d = JSON.parse(data);
            d.forEach(function(element) {
                console.log(element.id);
                option += "<option value='" + element.id + "'>" + element.name + "</option>";
            });

            $("#subcategory_id").html(option);
        }); 
    });
     
      </script>
      
      @endsection