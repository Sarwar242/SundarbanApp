

@extends('backend.layouts.master')
@section('title','Category')

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
              <h2>Edit Category</h2>
            </div>
          </div>

            <form  method="POST" action="{{ route('admin.category.update.submit',$category->id) }}" enctype="multipart/form-data" novalidate="novalidate">
              @csrf
              <div class="form-group">
                <label for="Name">Name</label>
              <input type="text" name="name" value="{{$category->name}}" class="form-control @error('name') is-invalid @enderror"
                 id="exampleFormControlInput1" placeholder="Electronics">
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
                <input type="text" name="bn_name" value="{{$category->bn_name}}" class="form-control  @error('bn_name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="">
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
                <label for="Category Image">Category Image :</label>
                <div class="preview">
                  <img style="display:block; max-width: 200px; padding-left: 10px;padding-bottom: 3px; margin-left: 60px;" src="{{ asset('storage/category')}}/{{$category->image}}" >
                </div>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="image" accept="image/*" onchange="showImgPreview(event);">
                <span>[max size: <strong>100kb</strong>
                    & resolution: <strong>100*85px]</strong> </span>
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
                <div class="preview">
                  <img id="img-preview">
                </div>
              </div>

              <div class="form-group">
                <label for="exampleFormControlTextarea1">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror"
                name="description" id="exampleFormControlTextarea1" rows="3"
                placeholder="Write something about the Category...">{!!$category->description!!}</textarea>
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
                <textarea class="form-control @error('bn_description') is-invalid @enderror" name="bn_description" id="exampleFormControlTextarea1" rows="3" placeholder="Write something about the Category...">{!!$category->bn_description!!}</textarea>
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
                <input type="submit" class="btn btn-success btn-block" value="Update">
                <a href="#" class="btn btn-primary btn-block">Add More</a>
              </center>
            </form>
          </div>
        </section>
      </section>
    </section>
    @endsection
