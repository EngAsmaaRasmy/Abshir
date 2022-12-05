<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\DiscountSetting;

class DiscountSettingsController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:عرض إعدادات الخصم|إضافة خصم|تعديل خصم|حذف خصم ', ['only' => ['index','show']]);
         $this->middleware('permission:إضافة خصم', ['only' => ['create','store']]);
         $this->middleware('permission:تعديل خصم', ['only' => ['edit', 'update']]);
         $this->middleware('permission:حذف خصم', ['only' => ['delete']]);
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $discounts = DiscountSetting::orderBy('id','DESC')->paginate(PAGINATION);
        return view("admin.setting.discount.index", compact("discounts"));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.setting.discount.add');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'name' => 'required|unique:discount_settings,name',
            'discount_value' => 'required',

        ]);
        $discount = DiscountSetting::create($request->all());

        return redirect()->route('discountSettings.index')
                        ->with('success','تم إضافة إعدادات خصم جديدة بنجاح');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $discount = DiscountSetting::find($id);
    
        return view('admin.setting.discount.show',compact('discount'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $discount = DiscountSetting::find($id);   
        return view('admin.setting.discount.edit',compact('discount'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'discount_value' => 'required',
        ]);
        $discount = DiscountSetting::find($request->input('id'));
        $discount->update([
            "name" => $request->input('name'),
            "discount_value" => $request->input('discount_value'),
        ]);
        $discount->save();
        return redirect()->route('discountSettings.index')
                        ->with('success','تم تعديل إعدادات خصم بنجاح ');
    }
}
