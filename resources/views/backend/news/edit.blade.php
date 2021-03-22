@extends('backend.layouts.master')
@section('title','Edit News')

@section('contents')
@include('backend.layouts.sidebar')
<br>
<br>
<br>
  <section class="container-fluid">
    <section class="row justify-content-center">
      <section class="col-12 col-sm-6 col-md-3">
          <br>
          <br>
          <br>
          <br>
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
              <h2>Edit News</h2>
            </div>
          </div>

            <form method="POST" action="{{ route('admin.news.update.submit', $news->id) }}" enctype="multipart/form-data" novalidate="novalidate">
              @csrf
              <div class="form-group">
                <label for="url">URL</label>
                <input type="url" name="url" value="{{$news->url}}" class="form-control @error('url') is-invalid @enderror"
                    id="url">
                @error('url')
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
              </center>
            </form>
          </div>
        </section>
      </section>
    </section>

 @endsection
