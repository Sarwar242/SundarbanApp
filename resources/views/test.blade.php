@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" novalidate="novalidate" action="{{ route('api.test') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="" type="text" class="form-control" name="name" value="{{ old('email') }}" autocomplete="email" autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>

                            <div class="col-md-6">
                                <input id="" type="text" class="form-control" name="description" value="{{ old('email') }}"autocomplete="email" autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bn_description" class="col-md-4 col-form-label text-md-right">Bn Description</label>

                            <div class="col-md-6">
                                <input id="" type="text" class="form-control" name="bn_description" value="{{ old('email') }}" autocomplete="email" autofocus>
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <label for="image" class="col-md-4 col-form-label text-md-right">Image</label>

                            <div class="col-md-6">
                                <input type="file" class="form-control" name="image">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Product Category</label>
                            <select name="category_id" id="category_id" style="margin:20px;">
                                <option value="" selected='selected' disabled>
                                    Select a Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create') }}
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
