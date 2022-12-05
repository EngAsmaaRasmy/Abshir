<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\LoginRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
    public function showAdminLoginForm()
    {
        return view("admin.login");
    }

    
    public function  showHome(){
        return view("admin");
    }

    public function adminLogin(LoginRequest $request)
    {
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password,"active"=>1], $request->get('remember'))) {
            return  redirect()->to("/admin/home");
        }else{  

            return back()->withErrors(["not-found"=>"عذرا انت غير مسجل فى نظام HMF"])->withInput($request->all());
        }

    }


    public function getEditForm(){
        $user=Admin::find(Auth::id());
        return view("admin.editProfile",compact('user'));
    }


    public function logout(){

        Auth::logout();
        return redirect()->route("admin.login");
    }

    public function update(Request $request){
        $id=  Auth::id();
        $user=Admin::find($id);
        $emailChanged=false;
        $passwordChanged=false;


        if($user->email!=$request->email){
            $emailChanged=true;
        }
        if($request->password!=''&&!Hash::check($request->password,$user->password)){
            $passwordChanged=true;
        }
        if($emailChanged||$passwordChanged){
            if(Hash::check($request->oldPassword,$user->password)){
                if($emailChanged){
                    $user->email=$request->email;
                    $user->save();
                    return redirect()->back()->with(["success"=>"تم تعديل البيانات بنجاح"]);
                }if($passwordChanged){
                    if($request->password==$request->confirmPassword){
                        $user->password=Hash::make($request->password);
                        $user->save();
                        return  redirect()->back()->with(['success'=>"تم تعديل البيانات بنجاح"]);
                    }
                    else{
                        return redirect()->back()->with(['error'=>"كلمتى السر غير متطابقتين"]);
                    }
                }
            }else{
                return redirect()->back()->with(["error"=>"كلمة السر القديمة خاطئه"]);
            }
        }
    }

    //------ Login by user to show driver on map
    public function getUserLogin()
    {
        return view("drivers_on_map.login");
    }
    public function UserLogin(Request $request)
    {
        
        if (Auth::guard('drivers-on-map')->attempt(['name' =>$request->name, 'password' => $request->password,"active"=>1])) {
            return view("drivers_on_map.home");
        }else{  
            return back()->withErrors(["not-found"=>"عذرا انت غير مسجل فى نظام HMF"])->withInput($request->all());
        }

    }
}
