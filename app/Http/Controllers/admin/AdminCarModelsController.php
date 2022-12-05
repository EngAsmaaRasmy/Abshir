<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Imports\ModelsImport;
use App\Models\VehiclesMarker;
use App\Models\VehiclesModel;
use Illuminate\Http\Request;
use App\traits\ImageTrait;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class AdminCarModelsController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:عرض موديلات السيارات|إضافة موديل سيارة|تعديل موديل سيارة|حذف موديل سيارة', ['only' => ['index','show']]);
         $this->middleware('permission:إضافة موديل سيارة', ['only' => ['add','save']]);
         $this->middleware('permission:تعديل موديل سيارة', ['only' => ['edit','update']]);
         $this->middleware('permission:حذف موديل سيارة', ['only' => ['delete']]);
    }
    public function import() 
    {
        try {
            Excel::import(new ModelsImport,request()->file('file'));  
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
        $car_models = VehiclesModel::select('vehicles_models.*','vehicles_markers.marker')
        ->leftjoin('vehicles_markers','vehicles_markers.id','vehicles_models.marker_id')
        ->paginate(25);
        return view('admin.setting.carModels.index',compact('car_models'));
    }
    public function add()
    {
        $markers = VehiclesMarker::select('id','marker')->get();
        
        return view('admin.setting.carModels.add',compact('markers'));
    }
    public function save(Request $request)
    {
        $image = $this->saveImage($request->image,"settings/carMarkers",null);

        // $file = $request->file("image");
        // $filename = Str::random(6) . '_' . time() . '_' . $file->getClientOriginalName();
        // $path = 'settings/carMarkers';
        // $file->move($path, $filename);
        // $image = $path . '/' . $filename;

        if( VehiclesModel::create($request->only('model','marker_id') + ['image'=>$image])){

            return redirect()->route('carModels.index');
        }
        

    }
    public function edit($id)
    {
        $markers = VehiclesMarker::select('id','marker')->get();
        $car_model = VehiclesModel::where('id',$id)->first();
        return view('admin.setting.carModels.edit',compact('car_model','markers'));

    }
    public function update(Request $request)
    {
        $image = $this->saveImage($request->image,"settings/carMarkers",null);

        // $file = $request->file("image");
        // $filename = Str::random(6) . '_' . time() . '_' . $file->getClientOriginalName();
        // $path = 'settings/carMarkers';
        // $file->move($path, $filename);
        // $image = $path . '/' . $filename;

        $car_models = VehiclesModel::where('id',$request->id)->update($request->only('model','marker_id')+['image'=>$image]);
        if($car_models)
        {
            return redirect()->route('carModels.index');
        }
    }
    public function delete($id)
    {

        $car_models = VehiclesModel::where('id',$id)->delete();
        if($car_models){
            return redirect()->route('carModels.index');

        }
    }
}
