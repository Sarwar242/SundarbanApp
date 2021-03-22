<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('backend.news.index');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'nullable|string',
            'url' => 'required|url',
            'descriptions' => 'nullable|string',
        ]);
        try{
            $news= new News;
            $news->title =$request->title;
            $news->url =$request->url;
            $news->admin_id=Auth::guard('admin')->user()->id;
            $news->save();

            session()->flash('success', 'New News Added!!');
            return response(['success',true],200);
        }catch(Exception $e){
            return response(['success',false],500);
        }
    }

    public function edit($id)
    {
        $news= News::find($id);
        return view('backend.news.edit')->with('news',$news);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title' => 'nullable|string',
            'url' => 'required|url',
            'descriptions' => 'nullable|string',
        ]);
        try{
            $news= News::find($id);
            $news->title =$request->title;
            $news->url =$request->url;
            $news->admin_id=Auth::guard('admin')->user()->id;
            $news->save();

            session()->flash('success', 'A news has been updated!!');
            return redirect()->route('admin.news');
        }catch(\Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return back();
        }
    }


    public function destroy($id)
    {
        $news= News::find($id);
        $news->delete();
        session()->flash('success', 'A news has been deleted!!');
        return back();
    }
}
