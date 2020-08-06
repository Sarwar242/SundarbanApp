

@extends('backend.layouts.master')
@section('title','Product')

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
              <h2>Add Product</h2>
            </div>
          </div>

            <form  method="POST" action="{{ route('admin.product.create.submit') }}" enctype="multipart/form-data" novalidate="novalidate">
              @csrf
              <div class="form-group">
                <label for="Name">Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                 id="exampleFormControlInput1" placeholder="Xiaomi Note 7 Pro">
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
                <input type="text" name="bn_name" class="form-control  @error('bn_name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="">
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
                @if(!is_null(App\Models\Product::generateProductCode()))
                <div class="alert alert-success">
                  <button type="button" class="close" data-dismiss="alert">
                    x
                  </button>
                  <strong>
                     This code is autometically generated!
                  </strong>
                </div>
                @endif
                <input type="text" name="code" value="{{App\Models\Product::generateProductCode()}}" class="form-control @error('code') is-invalid @enderror" placeholder="Product Code">
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
                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"  placeholder="">
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
                <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" placeholder="">
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
                <label for="exampleFormControlSelect1">In Unit</label>
                <select class="form-control @error('unit_id') is-invalid @enderror" name="unit_id">
                  @foreach(App\Models\Unit::all() as $unit)
                    <option value="{{$unit->id}}">{{$unit->name}}</option>
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
                  <option value="" selected='selected' disabled>
                    Select a Category</option>
                  @foreach(App\Models\Category::all() as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
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
                  <option value="" selected='selected' disabled>
                    Optional</option>
                  @foreach(App\Models\Company::all() as $company)
                  <option value="{{$company->id}}">{{$company->name}}</option>
                  @endforeach
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

              <div class="form-group">
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
              </div>
              
              <div class="form-group">
                <label for="exampleFormControlTextarea1">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3" placeholder="Write something about Product..."></textarea>
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
                <textarea class="form-control @error('bn_description') is-invalid @enderror" name="bn_description" rows="3" placeholder="Write something about Product..."></textarea>
              
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