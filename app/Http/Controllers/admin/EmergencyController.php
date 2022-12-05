<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Emergency;
use Illuminate\Http\Request;

class EmergencyController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:عرض حالات الطوارئ', ['only' => ['index']]);
        $this->middleware('permission:تتبع الرحلة', ['only' => ['show']]);
    }


    public function index()
    {
        $emergencies = Emergency::orderBy('id', 'DESC')->paginate(PAGINATION);
        return view("admin.emergencies.index", compact("emergencies"));
    }

    public function getAllEmergencies()
    {
        try {
            $emergencies = Emergency::query()->orderByDesc("created_at")->get()->values();
            return  response(["status" => true, "data" => $emergencies, "error" => ""]);
        } catch (\Throwable $e) {
            return response(['status' => false, "data" => [], "error" => $e->getMessage()]);
        }
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $emergency = Emergency::where('id', $id)->first();
        return view("admin.emergencies.show", compact("emergency"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
