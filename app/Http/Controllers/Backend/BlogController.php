<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('backend.blog.index');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'nullable|string',
            'url' => 'required|url',
            'descriptions' => 'nullable|string',
        ]);
        try{
            $blog= new Blog;
            $blog->title =$request->title;
            $blog->url =$request->url;
            $blog->admin_id=Auth::guard('admin')->user()->id;
            $blog->save();

            session()->flash('success', 'New blog Added!!');
            return response(['success',true],200);
        }catch(Exception $e){
            return response(['success',false],500);
        }
    }

    public function edit($id)
    {
        $blog= Blog::find($id);
        return view('backend.blog.edit')->with('blog',$blog);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title' => 'nullable|string',
            'url' => 'required|url',
            'descriptions' => 'nullable|string',
        ]);
        try{
            $blog= Blog::find($id);
            $blog->title =$request->title;
            $blog->url =$request->url;
            $blog->admin_id=Auth::guard('admin')->user()->id;
            $blog->save();

            session()->flash('success', 'A blog has been updated!!');
            return redirect()->route('admin.blogs');
        }catch(\Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return back();
        }
    }


    public function destroy($id)
    {
        $blog= Blog::find($id);
        $blog->delete();
        session()->flash('success', 'A blog has been deleted!!');
        return back();
    }
}
