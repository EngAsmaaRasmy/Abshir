<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Imports\MarkersImport;
use App\Models\VehiclesMarker;
use App\traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class AdminCarMarkersController extends Controller
{
    use ImageTrait;

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:عرض ماركات السيارات|إضافة ماركة سيارة|تعديل ماركة سيارة|حذف ماركة سيارة', ['only' => ['index','show']]);
         $this->middleware('permission:إضافة ماركة سيارة', ['only' => ['add','save']]);
         $this->middleware('permission:تعديل ماركة سيارة', ['only' => ['edit','update']]);
         $this->middleware('permission:حذف ماركة سيارة', ['only' => ['delete']]);
    }
    public function import() 
    {
        try {
            Excel::import(new MarkersImport,request()->file('file'));  
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
            }
        }
        return redirect()->back();
    }

    public function index()
    {
        $car_markers = VehiclesMarker::select('vehicles_markers.*')->paginate(25);
        return view('admin.setting.carMarkers.index',compact('car_markers'));
    }
    public function add()
    {
        return view('admin.setting.carMarkers.add');
    }
    public function save(Request $request)
    {   
        $image = $this->saveImage($request->image,"settings/carMarkers",null);

        // $file = $request->file("image");
        // $filename = Str::random(6) . '_' . time() . '_' . $file->getClientOriginalName();
        // $path = 'settings/carMarkers';
        // $file->move($path, $filename);
        // $image = $path . '/' . $filename;

        if( VehiclesMarker::create($request->only('marker') + ['image'
        => $image])){

            return redirect()->route('carMarkers.index');
        }
        

    }
    public function edit($id)
    {
        $car_markers = VehiclesMarker::where('id',$id)->first();
        return view('admin.setting.carMarkers.edit',compact('car_markers'));

    }
    public function update(Request $request)
    {
        $image = $this->saveImage($request->image,"settings/carMarkers",null);

        // $file = $request->file("image");
        // $filename = Str::random(6) . '_' . time() . '_' . $file->getClientOriginalName();
        // $path = 'settings/carMarkers';
        // $file->move($path, $filename);
        // $image = $path . '/' . $filename;

        
        $car_markers = VehiclesMarker::where('id',$request->id)->update($request->only('marker') + ['image'=>$image]);
        if($car_markers)
        {
            return redirect()->route('carMarkers.index');
        }
    }
    public function delete($id)
    {

        $car_markers = VehiclesMarker::where('id',$id)->delete();
        if($car_markers){
            return redirect()->route('carMarkers.index');

        }
    }
}
