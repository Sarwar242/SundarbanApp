<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Blogs as BlogResource;
use App\Models\Blog;

class BlogController extends Controller
{
    public function __invoke(Request $request){
        if($request->id){
            return new BlogResource(Blog::findOrFail($request->id));
        }
        return BlogResource::collection(Blog::all());
    }
}
