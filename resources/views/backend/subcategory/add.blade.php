

@extends('backend.layouts.master')
@section('title','Subcategory')

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
              <h2>Add Sub-Category</h2>
            </div>
          </div>

            <form  method="POST" action="{{ route('admin.subcategory.create.submit') }}" enctype="multipart/form-data" novalidate="novalidate">
              @csrf
              <div class="form-group">
                <label for="Name">Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                 id="exampleFormControlInput1" placeholder="Name Here">
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
                <label for="Category">Category</label>
                <select class="select2 form-control @error('category_id') is-invalid @enderror"  name="category_id" id="exampleFormControlSelect1">
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
                <label for="image">Upload Image</label>
                <input type="file"  name="image"  class="form-control @error('image') is-invalid @enderror" id="exampleFormControlFile1">
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
                <label for="description">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" name="description"  id="exampleFormControlTextarea1" rows="3" placeholder="Write something about the Category..."></textarea>
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
                <textarea class="form-control @error('bn_description') is-invalid @enderror" name="bn_description"  id="exampleFormControlTextarea1" rows="3" placeholder="Write something about the Category..."></textarea>
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

    @endsection