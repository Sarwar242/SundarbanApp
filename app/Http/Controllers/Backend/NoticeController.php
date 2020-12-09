<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notice;
use App\Models\Admin;
use App\Models\User;
use App\Models\Customer;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;
use App\Notifications\AdminNotice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Auth;

class NoticeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('backend.notice.index');
    }

    public function create(){
        return view('backend.notice.add');
    }


    public function store(Request  $request)
    {

        $this->validate($request,[
            'title' => 'required',
            'description' => 'nullable',
            'type' => 'nullable|string',
            'for' => 'nullable|string',
            'user_id' => 'nullable',
        ]);

        try{
            $notice= new Notice;
            $notice->title =$request->title;
            $notice->description =$request->description;
            $notice->type =$request->type;
            $notice->for =$request->for;
            $notice->user_id =$request->user_id;
            $notice->admin_id=Auth::guard('admin')->user()->id;
            $notice->save();

/*
|--------------------------------------------------------------------------
| Notify Recipiants
|--------------------------------------------------------------------------
*/
            if(!is_null($notice->user_id)){
                if($notice->for == "Customer"){
                    $customer = Customer::find($notice->user_id);
                    $user=$customer->user;
                    $user->notify(new AdminNotice($notice));
                }
                else if($notice->for == "Company"){
                    $company = Company::find($notice->user_id);
                    $user = $company->user;
                    $user->notify(new AdminNotice($notice));
                }
                else if($notice->for == "Admin"){
                    $admin = Admin::find($notice->user_id);
                    $admin->notify(new AdminNotice($notice));
                }
            }else{
                if($notice->for == "Customers"){
                    $users = User::where('is_company','=','0')->get();
                    Notification::send($users, new AdminNotice($notice));
                }
                else if($notice->for == "Companies"){
                    $users = User::where('is_company','=','1')->get();
                    Notification::send($users, new AdminNotice($notice));
                }else if($notice->for == "Admins"){
                    $admins = Admin::all();
                    Notification::send($admins, new AdminNotice($notice));
                }else if($notice->for == "Users"){
                    $users = User::all();
                    Notification::send($users, new AdminNotice($notice));
                }
            }



/*
|--------------------------------------------------------------------------
| Notify   Ends
|--------------------------------------------------------------------------
*/
            session()->flash('success', 'A notice has been Added!!');
            return view('backend.notice.add')->with('notice', $notice->id);
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.notice.create');
        }
    }

    public function show($id)
    {
        $notice = notice::find($id);
        if(is_null($notice)){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->back();
        }
        $recipiant="";
        if(!is_null($notice->user_id)){
            if($notice->for == "Customer"){
                $recipiant = Customer::find($notice->user_id)->username;
            }
            else if($notice->for == "Company"){
                $recipiant = Company::find($notice->user_id)->name;
            }
            else if($notice->for == "Admin"){
                $recipiant = Admin::find($notice->user_id)->username;
            }
            if(!is_null($recipiant)){
                return view('backend.notice.view')->with('notice',$notice)->with('recipiant',$recipiant);
            }else{
                return view('backend.notice.view')->with('notice',$notice);
            }
        }
        return view('backend.notice.view')->with('notice',$notice);
    }



    public function edit($id){
        $notice= Notice::find($id);
        $recipiant="";
        if(!is_null($notice->user_id)){
            if($notice->for == "Customer"){
                $recipiant = Customer::find($notice->user_id)->username;
            }
            else if($notice->for == "Company"){
                $recipiant = Company::find($notice->user_id)->name;
            }
            else if($notice->for == "Admin"){
                $recipiant = Admin::find($notice->user_id)->username;
            }
            if(!is_null($recipiant)){
                return view('backend.notice.edit')->with('notice',$notice)->with('recipiant',$recipiant);
            }else{
                return view('backend.notice.edit')->with('notice',$notice);
            }
        }
        return view('backend.notice.edit')->with('notice',$notice);
    }



    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title' => 'required',
            'description' => 'nullable',
            'type' => 'nullable|string',
            'for' => 'nullable|string',
            'user_id' => 'nullable',
        ]);

        try{
            $notice = Notice::find($id);
            if(request()->has('title'))
                $notice->title =$request->title;
            if(request()->has('description'))
                $notice->description =$request->description;
            if(request()->has('type'))
                $notice->type =$request->type;
            if(request()->has('for'))
                $notice->for =$request->for;
            if(request()->has('user_id'))
                $notice->user_id =$request->user_id;
            $notice->save();

            session()->flash('success', 'The Notice has been Updated!!');
            return redirect()->route('admin.notice.update',$notice->id);
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.notice.update',$notice->id);
        }
    }


    public function destroy($id)
    {
        try{
            $notice = Notice::find($id);

            if(is_null($notice)){
                session()->flash('failed', 'No notice found');
                return redirect()->route('admin.notices');
            }
            $notifications = DB::table('notifications')
                                ->where('data->notice_id','=', $notice->id)
                                ->delete();

            $notice->delete();
            session()->flash('success', 'The Notice has been Deleted!!');
            return redirect()->route('admin.notices');
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.notices');
        }
    }
}
