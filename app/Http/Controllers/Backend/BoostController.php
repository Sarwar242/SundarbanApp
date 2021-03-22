<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Boost;
use App\Models\Boost_Record;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

class BoostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function boost(Request $request, $id)
    {
        $this->validate($request,[
            'days' => 'required|numeric',
        ]);

        $days =(int)$request->days;
        $today=Carbon::now();
        $company=Company::find($id);
        if(!$company){
            return back();
        }

        if(!is_null($company->boost)){
            $boost= $company->boost;
            $end = $boost->end_date;
            if(now()>$end){
                $boost->delete();
            }
            else{
                $total=$boost->days+$days;
                $boost->days=$total;
                $start = new Carbon($boost->created_at);
                $boost->end_date = $start->addDays($total);
                $boost->admin_id=Auth::guard('admin')->user()->id;
                $boost->save();
                $boostRecord = new Boost_Record;
                $boostRecord->days= $total;
                $boostRecord->end_date =$start->addDays($total);
                $boostRecord->company_id=$id;
                $boostRecord->message='The Company: '.$company->name.' boosting has been updated to '.$total.' days from '.$start->format('d M Y g:ia').' to '.$start->addDays($total)->format('d M Y g:ia').' by Admin: '.Auth::guard('admin')->user()->username.'.';
                $boostRecord->admin_id=Auth::guard('admin')->user()->id;
                $boostRecord->save();
                return back();
            }
        }
        try{
            $newBoost = new Boost;
            $newBoost->days= $days;
            $newBoost->end_date =$today->addDays($days);
            $newBoost->company_id=$id;
            $newBoost->admin_id=Auth::guard('admin')->user()->id;
            $newBoost->save();
            $boostRecord = new Boost_Record;
            $boostRecord->days= $days;
            $boostRecord->end_date =$today->addDays($days);
            $boostRecord->company_id=$id;
            $boostRecord->message='The Company: '.$company->name.' has been boosted for '.$days.' days from '.$today->format('d M Y g:ia').' to '.$today->addDays($days)->format('d M Y g:ia').' by Admin: '.Auth::guard('admin')->user()->username.'.';
            $boostRecord->admin_id=Auth::guard('admin')->user()->id;
            $boostRecord->save();
        }catch(\Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
        }

        return back();
    }


    public function featured()
    {
        return view('backend.company.featured');
    }


    public function records()
    {
        return view('backend.company.history');
    }

    public function destroy($id)
    {
        $boost=Boost::find($id);
        $boost->delete();
        return back();
    }

    public function recordDelete($id)
    {
        $boost_record=Boost_Record::find($id);
        $boost_record->delete();
        return back();
    }
}
