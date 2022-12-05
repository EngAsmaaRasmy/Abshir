<?php

namespace App\Http\Controllers\admin;

use App\Governorate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GovernoratesController extends Controller
{

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // function __construct()
    // {
    //      $this->middleware('permission:عرض ماركات السيارات|إضافة ماركة سيارة|تعديل ماركة سيارة|حذف ماركة سيارة', ['only' => ['index','show']]);
    //      $this->middleware('permission:إضافة ماركة سيارة', ['only' => ['add','save']]);
    //      $this->middleware('permission:تعديل ماركة سيارة', ['only' => ['edit','update']]);
    //      $this->middleware('permission:حذف ماركة سيارة', ['only' => ['delete']]);
    // }
    // public function import() 
    // {
    //     try {
    //         Excel::import(new MarkersImport,request()->file('file'));  
    //     } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
    //         $failures = $e->failures();
    //         foreach ($failures as $failure) {
    //             $failure->row(); // row that went wrong
    //             $failure->attribute(); // either heading key (if using heading row concern) or column index
    //             $failure->errors(); // Actual error messages from Laravel validator
    //             $failure->values(); // The values of the row that has failed.
    //         }
    //     }
    //     return redirect()->back();
    // }

    public function index()
    {
        $governorates = Governorate::select('governorates.*')->paginate(25);
        return view('admin.setting.governorate.index',compact('governorates'));
    }
    public function add()
    {
        return view('admin.setting.governorate.add');
    }
    public function save(Request $request)
    {   
        if( Governorate::create($request->only('name'))){

            return redirect()->route('governorate.index');
        }
        

    }
    public function edit($id)
    {
        $governorate = Governorate::where('id',$id)->first();
        return view('admin.setting.governorate.edit',compact('governorate'));

    }
    public function update(Request $request)
    {
        $governorate = Governorate::where('id',$request->id)->update($request->only('name'));
        if($governorate)
        {
            return redirect()->route('governorate.index');
        }
    }
    public function delete($id)
    {

        $car_markers = Governorate::where('id',$id)->delete();
        if($car_markers){
            return redirect()->route('governorate.index');

        }
    }
}
