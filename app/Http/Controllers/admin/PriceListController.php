<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\admin\PriceList;
use Illuminate\Http\Request;
use App\traits\ResonseTrait;
use App\Http\Controllers\admin\FirebaseController;
use Illuminate\Support\Facades\Validator;

class PriceListController extends Controller
{
    use ResonseTrait;

      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:عرض قائمة الأسعار|إضافة قائمة أسعار|تعديل قائمة أسعار|حذف قائمة أسعار', ['only' => ['index','show']]);
         $this->middleware('permission:إضافة قائمة أسعار', ['only' => ['create','store']]);
         $this->middleware('permission:تعديل قائمة أسعار', ['only' => ['edit', 'update']]);
         $this->middleware('permission:حذف قائمة أسعار', ['only' => ['delete']]);
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $priceLists = PriceList::orderBy('id','DESC')->paginate(PAGINATION);
        return view("admin.setting.priceLists.index", compact("priceLists"));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $price = PriceList::latest()->first();
        return view('admin.setting.priceLists.add', compact("price"));
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
        $validator = Validator::make($input, [
            'name' => 'required|unique:price_lists,name',
            'kilo_price' => 'required',
            'minute_price' => 'required',
            'start_price' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->returnError($validator->errors()->first());
        }
        // $this->validate($request, [
        //     'name' => 'required|unique:price_lists,name',
        //     'kilo_price' => 'required',
        //     'minute_price' => 'required',
        //     'start_price' => 'required',

        // ]);
    
        $priceLists = PriceList::create($request->all());
        
        ///----- Store in Firebase Database ----
        // $database = FirebaseController::connectionToFirebase();
        // $testRef = $database->collection('PriceLists')->document($priceLists->id);
        // $testRef->set([
        //     'id' =>$priceLists->id,
        //     'name' =>$priceLists->name,
        //     'kilo_price' =>$priceLists->kilo_price,
        //     'minute_price' =>$priceLists->minute_price,
        //     'start_price' =>$priceLists->start_price,
            
        // ]);
        $request->session()->flash('message', '  تم إضافة قائمةأسعار جديدة بنجاح');
        $request->session()->flash('message-type', 'success');
        return $this->returnSuccess('تم حفظ البيانات ');

        // return redirect()->route('priceLists.index')
        //                 ->with('success','تم إضافة قائمةأسعار جديدة بنجاح');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $priceList = PriceList::find($id);
    
        return view('admin.setting.priceLists.show',compact('priceList'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $priceList = PriceList::find($id);   
        return view('admin.setting.priceLists.edit',compact('priceList'));
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
        // $this->validate($request, [
        //     'name' => 'required',
        //     'kilo_price' => 'required',
        //     'minute_price' => 'required',
        //     'start_price' => 'required',
        // ]);
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'kilo_price' => 'required',
            'minute_price' => 'required',
            'start_price' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->returnError($validator->errors()->first());
        }
    
        $priceList = PriceList::find($request->input('id'));
        $priceList->update([
            "name" => $request->input('name'),
            "kilo_price" => $request->input('kilo_price'),
            "minute_price" => $request->input('minute_price'),
            "start_price" => $request->input('start_price')
        ]);
        $priceList->save();
    


         ///----- Edit in Firebase Database ----
        //  $database = FirebaseController::connectionToFirebase();
        //  $testRef = $database->collection('PriceLists')->document($priceList->id);
        //  $testRef->set([
        //      'id' =>$priceList->id,
        //      'name' =>$priceList->name,
        //      'kilo_price' =>$priceList->kilo_price,
        //      'minute_price' =>$priceList->minute_price,
        //      'start_price' =>$priceList->start_price,
             
        //  ]);

        $request->session()->flash('message', '  تم إضافة قائمةأسعار جديدة بنجاح');
        $request->session()->flash('message-type', 'success');
        return $this->returnSuccess('تم تعديل البيانات البيانات ');
        // return redirect()->route('priceLists.index')
        //                 ->with('success','تم تعديل قائمة الأسعار بنجاح ');
    }
}
