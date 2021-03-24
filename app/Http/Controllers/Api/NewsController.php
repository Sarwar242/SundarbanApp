<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\News as NewsResource;
use App\Models\News;

class NewsController extends Controller
{
    public function __invoke(Request $request){
        if($request->id){
            return new NewsResource(News::findOrFail($request->id));
        }
        return NewsResource::collection(News::all());
    }
}
