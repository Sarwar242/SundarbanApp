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
use Illuminate\Support\Facades\Log;
use Auth;
use DB;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        // $slug=Category::slugComplete();
        // dd($slug);
        return view('backend.category.index');
    }

    public function create(){
        return view('backend.category.add');
    }

    public function store(Request  $request)
    {

        $this->validate($request,[
            'name' => 'sometimes|string',
            'bn_name' => 'nullable|string',
            'description' => 'nullable|string',
            'bn_description' => 'nullable|string',
            'image' => 'nullable|file|image|max:100',
        ]);
        try{
            $category= new Category;
            $category->name =$request->name;
            $category->bn_name =$request->bn_name;
            if(is_null($request->description)){
                $category->description ="N/A";
            }else{
                $category->description =$request->description;
            }
            if(is_null($request->bn_description)){
                $category->bn_description ="N/A";
            }else{
                $category->bn_description =$request->bn_description;
            }
            $category->admin_id=Auth::guard('admin')->user()->id;
            if(is_null($request->image)){
                $category->image="default.png";
            }else if(request()->hasFile('image')){
                $imageName = time().'.'.$request->image->extension();
                $request->image->storeAs('/category',$imageName,'public');
                $category->image=$imageName;
            }

            $slug = Str::slug(str_replace( ' ', '-', $request->name));
            $i = 0;
            while(Category::whereSlug($slug)->exists())
            {
                $i++;
                $slug = $slug ."-". $i;
            }
            $category->slug =$slug;

            $category->save();

            session()->flash('success', 'New Category Added!!');
            return view('backend.category.add')->with('category',$category->id);
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.category.create');
        }
    }

    public function show(Request  $request)
    {
        try{
            $category = Category::find($request->id);
            if(is_null($category))
            return response()->json([
                "sucess"  => false,
                "message" => "No Category Found!",

            ]);

            return response()->json([
                "sucess"  => true,
                "category" => $category,
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
        $category= Category::find($id);
        return view('backend.category.edit')->with('category',$category);
    }



    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'sometimes|string',
            'bn_name' => 'nullable|string',
            'description' => 'nullable|string',
            'bn_description' => 'nullable|string',
            'image' => 'nullable|file|image|max:100',
        ]);
        $category = Category::find($id);
        $slug_change=0;
        if($category->name!=$request->name){
            $slug_change=1;
        }
        $category->name =$request->name;
        $category->bn_name =$request->bn_name;
        $category->description =$request->description;
        $category->bn_description =$request->bn_description;
        if(request()->hasFile('image') && !is_null($request->file('image'))){
            if(!is_null($category->image) && $category->image !="default.png" &&  $category->image !="default.jpg"){
                $exists = Storage::disk('public')->exists('category/'.$category->image);
                if($exists)
                    Storage::disk('public')->delete('category/'.$category->image);
            }
            $imageName = time().'.'.$request->image->extension();
            $request->image->storeAs('/category',$imageName,'public');
            $category->image=$imageName;
        }

        if($slug_change==1){
            $slug = Str::slug(str_replace( ' ', '-', $request->name));
            $i = 0;
            while(Category::whereSlug($slug)->exists())
            {
                $i++;
                $slug = $slug ."-". $i;
            }
            $category->slug =$slug;
        }
        $category->save();

        session()->flash('success', 'Category has been updated!!');
        return redirect()->route('admin.category.update',$category->id);
    }


    public function destroy($id)
    {
        try{
            $category = Category::find($id);
            if(is_null($category)){
            session()->flash('failed', 'No category found !!!');
            return redirect()->route('admin.categories');
        }
            if (!is_null($category->image) && $category->image !="default.png" &&  $category->image !="default.jpg") {
                $exists = Storage::disk('public')->exists('category/'.$category->image);
                if($exists)
                   Storage::disk('public')->delete('category/'.$category->image);
            }
            $category->delete();
            session()->flash('success', 'A Category has been Deleted!!');
            return redirect()->route('admin.categories');
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.dashboard');
        }
    }

    public function featuredFunc(Request $request){
        try{
            $category=Category::find($request->id);

            if(is_null($category))
                return json_encode([
                    "sucess"  => false,
                    "message" => "No category Found!",
                ]);

            if($category->featured==1){
                $category->featured = 0;
                $category->save();

                return json_encode([
                    'success'=>true,
                    'message'=> "The category has been unfeatured!",
                    ]);
            }
            else{
                $category->featured = 1;
                $category->save();
                return json_encode([
                    'success'=>true,
                    'message'=> "The category has been featured!",
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
            $category=Category::find($request->id);

            if(is_null($category))
                return json_encode([
                    "sucess"  => false,
                    "message" => "No category Found!",
                ]);


            $category->priority = $request->priority;
            $category->save();

            return json_encode([
                'success'=>true,
                'message'=> "The category priority has been set to ".$request->priority."!",
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


        $category=Category::find($id);
        if(is_null($category))
            return json_encode([
                "sucess"  => false,
                "message" => "No category Found!",
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
            $cps= Company::where('category_id',$id)
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


        $category=Category::find($id);
        if(is_null($category))
            return json_encode([
                "sucess"  => false,
                "message" => "No category Found!",
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
            $cps= Company::where('category_id',$id)
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


        $category=Category::find($id);
        if(is_null($category))
            return json_encode([
                "sucess"  => false,
                "message" => "No category Found!",
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
            $cps= Company::where('category_id',$id)
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
        $category=Category::find($id);

        if(is_null($category))
            return json_encode([
                "sucess"  => false,
                "message" => "No category Found!",
            ]);

        // $divisions=Division::join('companies', 'companies.division_id', '=', 'divisions.id' )
        //                         ->where('companies.category_id','=',$id)
        //                         ->distinct()
        //                         ->get(['divisions.*']);
        $data=$category;
        return view('backend.category.companiesbylocations', compact(['data']));
    }
}
