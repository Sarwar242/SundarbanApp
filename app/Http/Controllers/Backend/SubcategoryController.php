<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Models\Category;
use App\Models\Company;
use App\Models\District;
use App\Models\Division;
use App\Models\Upazilla;
use App\Models\Union;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Auth;
use DB;

class SubcategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
        // $slug=Subcategory::slugComplete();
        // dd($slug);
        return view('backend.subcategory.index');
    }
    public function test(){
        $categories=Category::all();
        return view('test')->with('categories',$categories);
    }


    public function create(){
        return view('backend.subcategory.add');
    }

    public function store(Request  $request)
    {
        $this->validate($request,[
            'name' => 'required|string',
            'bn_name' => 'nullable|string',
            'description' => 'nullable|string',
            'bn_description' => 'nullable|string',
            'image' => 'nullable|file|image|max:100',
            'category_id' => 'required',
        ]);

        try{
            $subcategory= new Subcategory;
            $subcategory->name =$request->name;
            $subcategory->bn_name =$request->bn_name;

            if(is_null($request->description)){
                $subcategory->description ="N/A";
            }else{
                $subcategory->description =$request->description;
            }
            if(is_null($request->bn_description)){
                $subcategory->bn_description ="N/A";
            }else{
                $subcategory->bn_description =$request->bn_description;
            }
            $subcategory->category_id =$request->category_id;
            if(is_null($request->image)){
                $subcategory->image="default.png";
            }else if(request()->hasFile('image')){
                $imageName = time().'.'.$request->image->extension();
                $request->image->storeAs('/subcategory',$imageName,'public');
                $subcategory->image=$imageName;
            }


            $subcategory->admin_id=Auth::guard('admin')->user()->id;

            $slug = Str::slug(str_replace( ' ', '-', $request->name));
            $i = 0;
            while(Subcategory::whereSlug($slug)->exists())
            {
                $i++;
                $slug = $slug ."-". $i;
            }
            $subcategory->slug =$slug;

            $subcategory->save();

            session()->flash('success', 'New Subcategory Added!!');
            return view('backend.subcategory.add')->with('subcategory', $subcategory->id);
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.subcategory.create');
        }
    }

    public function show(Request  $request)
    {
        try{
            $subcategory = Subcategory::find($request->id);
            if(is_null($subcategory))
            return response()->json([
                "sucess"  => false,
                "message" => "No Subcategory Found!",

            ]);

            return response()->json([
                "sucess"  => true,
                "subcategory" => $subcategory,
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> ''.$e,
            ]);
        }
    }


    public function edit($id){
        $subcategory= Subcategory::find($id);
        return view('backend.subcategory.edit')->with('subcategory',$subcategory);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required|string',
            'bn_name' => 'nullable|string',
            'description' => 'required|string',
            'bn_description' => 'required|string',
            'image' => 'nullable|file|image|max:100',
            'category_id' => 'required',
        ]);


        $subcategory = Subcategory::find($id);
        $slug_change=0;
        if($subcategory->name!=$request->name){
            $slug_change=1;
        }
        $subcategory->name =$request->name;
        $subcategory->bn_name =$request->bn_name;
        $subcategory->description =$request->description;

        if(is_null($request->bn_description)){
            $subcategory->bn_description ="N/A";
        }else{
            $subcategory->bn_description =$request->bn_description;
        }

        if(request()->hasFile('image')){
            if(!is_null($subcategory->image) && $subcategory->image !="default.png" &&  $subcategory->image !="default.jpg"){
                $exists = Storage::disk('public')->exists('subcategory/'.$subcategory->image);
                if($exists)
                    Storage::disk('public')->delete('subcategory/'.$subcategory->image);
                //dd(unlink(public_path('/storage/subcategory/'.$subcategory->image)));
            }
            $imageName = time().'.'.$request->image->extension();
            $request->image->storeAs('/subcategory',$imageName,'public');
            $subcategory->image=$imageName;
        }
        $subcategory->category_id =$request->category_id;

        if($slug_change==1){
            $slug = Str::slug(str_replace( ' ', '-', $request->name));
            $i = 0;
            while(Subcategory::whereSlug($slug)->exists())
            {
                $i++;
                $slug = $slug ."-". $i;
            }
            $subcategory->slug =$slug;
        }
        $subcategory->save();

        session()->flash('success', 'Subcategory has been updated!!');
        return redirect()->route('admin.subcategory.update',$subcategory->id);
    }


    public function destroy($id)
    {
        try{
            $subcategory = Subcategory::find($id);
            if(is_null($subcategory)){
                session()->flash('failed', 'No Subcategory found !!!');
                return redirect()->route('admin.subcategories');
            }
            if (!is_null($subcategory->image) && $subcategory->image !="default.png" &&  $subcategory->image !="default.jpg") {
                $exists = Storage::disk('public')->exists('subcategory/'.$subcategory->image);
                if($exists)
                    Storage::disk('public')->delete('subcategory/'.$subcategory->image);
            }
            $subcategory->delete();
            session()->flash('success', 'A Subcategory has been Deleted!!');
            return redirect()->route('admin.subcategories');
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.dashboard');
        }
    }


    public function featuredFunc(Request $request){
        try{
            $subcategory=Subcategory::find($request->id);

            if(is_null($subcategory))
                return json_encode([
                    "sucess"  => false,
                    "message" => "No subcategory Found!",
                ]);

            if($subcategory->featured==1){
                $subcategory->featured = 0;
                $subcategory->save();

                return json_encode([
                    'success'=>true,
                    'message'=> "The subcategory has been unfeatured!",
                    ]);
            }
            else{
                $subcategory->featured = 1;
                $subcategory->save();
                return json_encode([
                    'success'=>true,
                    'message'=> "The subcategory has been featured!",
                    ]);
            }
        }catch(\Exception $e){
            return json_encode([
                'success'=>false,
                'message'=> ''.$e,
            ]);
        }
    }

    public function priorityFunc(Request $request){
        try{
            $subcategory=Subcategory::find($request->id);

            if(is_null($subcategory))
                return json_encode([
                    "sucess"  => false,
                    "message" => "No subcategory Found!",
                ]);


            $subcategory->priority = $request->priority;
            $subcategory->save();

            return json_encode([
                'success'=>true,
                'message'=> "The subcategory priority has been set to ".$request->priority."!",
                ]);
        }catch(\Exception $e){
            return json_encode([
                'success'=>false,
                'message'=> ''.$e,
            ]);
        }
    }



    public function dataTableDist(Request $request,$id)
    {

        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = District::select('count(*) as allcount')->count();
        $totalRecordswithFilter = District::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->count();


        $subcategory=Subcategory::find($id);
        if(is_null($subcategory))
            return json_encode([
                "sucess"  => false,
                "message" => "No subcategory Found!",
            ]);

        $records=District::Where('districts.name', 'like', '%' . $searchValue . '%')
                            ->orWhere('divisions.name', 'like', '%' . $searchValue . '%')
                            ->select('districts.name as district', 'divisions.name as division','districts.id as id')
                            ->leftJoin('divisions', 'districts.division_id', '=', 'divisions.id')
                            ->orderBy($columnName, $columnSortOrder)
                            ->skip($start)
                            ->take($rowperpage)
                            ->get();
                            // dd($records);
        $data_arr = array();
        foreach ($records as  $key=>$record) {
            $key = $key+1;
            $division = $record->division;
            $district = $record->district;
            $cps= Company::where('subcategory_id',$id)
                            ->where('district_id',$record->id)
                            ->get();
            // $companies = $cps['total']?$cps['total']:0;
            $data_arr[] = array(
                "id" => $record->id,
                "district" => $district,
                'division' => $division,
                "companies" => count($cps),
            );
        }
        // dd($data_arr);
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        return  $response;
    }
    // DB::raw('(SELECT COUNT(*) FROM companies WHERE companies.district_id = districts.id) as aggregate')



    public function dataTableUpz(Request $request,$id)
    {

        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Upazilla::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Upazilla::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->count();


        $subcategory=Subcategory::find($id);
        if(is_null($subcategory))
            return json_encode([
                "sucess"  => false,
                "message" => "No subcategory Found!",
            ]);

        $records=Upazilla::Where('upazillas.name', 'like', '%' . $searchValue . '%')
                            ->orWhere('districts.name', 'like', '%' . $searchValue . '%')
                            ->orWhere('divisions.name', 'like', '%' . $searchValue . '%')
                            ->select('upazillas.name as upazilla', 'districts.name as district', 'divisions.name as division','upazillas.id as id')
                            ->leftJoin('districts', 'districts.id', '=', 'upazillas.district_id')
                            ->leftJoin('divisions', 'districts.division_id', '=', 'divisions.id')
                            ->orderBy($columnName, $columnSortOrder)
                            ->skip($start)
                            ->take($rowperpage)
                            ->get();

        $data_arr = array();
        foreach ($records as  $key=>$record) {
            $key = $key+1;
            $upazilla = $record->upazilla;
            $division = $record->division;
            $district = $record->district;
            $cps= Company::where('subcategory_id',$id)
                            ->where('upazilla_id',$record->id)
                            ->get();

            $data_arr[] = array(
                "id" => $record->id,
                "upazilla" => $upazilla,
                "district" => $district,
                'division' => $division,
                "companies" => count($cps),
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        return  $response;
    }




    public function dataTableUnn(Request $request,$id)
    {

        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Union::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Union::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->count();


        $subcategory=Subcategory::find($id);
        if(is_null($subcategory))
            return json_encode([
                "sucess"  => false,
                "message" => "No subcategory Found!",
            ]);

        $records=Union::Where('unions.name', 'like', '%' . $searchValue . '%')
                            ->orWhere('upazillas.name', 'like', '%' . $searchValue . '%')
                            ->orWhere('districts.name', 'like', '%' . $searchValue . '%')
                            ->orWhere('divisions.name', 'like', '%' . $searchValue . '%')
                            ->select('unions.name as union' ,'upazillas.name as upazilla', 'districts.name as district', 'divisions.name as division','unions.id as id')
                            ->leftJoin('upazillas', 'upazillas.id', '=', 'unions.upazilla_id')
                            ->leftJoin('districts', 'districts.id', '=', 'upazillas.district_id')
                            ->leftJoin('divisions', 'divisions.id', '=', 'districts.division_id')
                            ->orderBy($columnName, $columnSortOrder)
                            ->skip($start)
                            ->take($rowperpage)
                            ->get();

        $data_arr = array();
        foreach ($records as  $key=>$record) {
            $key = $key+1;
            $union = $record->union;
            $upazilla = $record->upazilla;
            $division = $record->division;
            $district = $record->district;
            $cps= Company::where('subcategory_id',$id)
                            ->where('union_id',$record->id)
                            ->get();

            $data_arr[] = array(
                "id" => $record->id,
                "union" => $union,
                "upazilla" => $upazilla,
                "district" => $district,
                'division' => $division,
                "companies" => count($cps),
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        return  $response;
    }



    public function companiesByLocation($id)
    {
        $subcategory=Subcategory::find($id);
        if(is_null($subcategory))
            return json_encode([
                "sucess"  => false,
                "message" => "No subcategory Found!",
            ]);

        $data=$subcategory;
        return view('backend.subcategory.companiesbylocations', compact(['data']));
    }
}
