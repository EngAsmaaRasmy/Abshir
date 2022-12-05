<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminWallet;
use App\Models\AdminWalletHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Helpers\WalletHistoryGeneralHelper;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:عرض المستخدمين|إضافة مستخدمين|تعديل مٌستخدم|حذف مُستخدم', ['only' => ['index', 'show']]);
        $this->middleware('permission:إضافة مستخدمين', ['only' => ['create', 'store']]);
        $this->middleware('permission:تعديل مٌستخدم', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف مُستخدم', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $admins = Admin::paginate(PAGINATION);
        return view("admin.admins.index", compact("admins"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('admin.admins.add', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
        $password = Hash::make($request->input("password"));
        $admin = Admin::create([
            "name" => $request->input("name"),
            "email" => $request->input("email"),
            "password" => $password,
            "active" => "1",
        ]);

        $admin->assignRole($request->input('roles'));

        return redirect()->route('admin.index')
            ->with('success', 'تم إضافة مستخدم');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = Admin::find($id);
        return view('users.show', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = Admin::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $adminRole = $admin->roles->pluck('name', 'name')->all();

        return view('admin.admins.edit', compact('admin', 'roles', 'adminRole'));
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
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $admin = Admin::find($id);
        $admin->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $admin->assignRole($request->input('roles'));

        return redirect()->route('admin.index')
            ->with('success', 'تم تعديل بيانات المستخدم بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::find($id)->delete();
        return redirect()->route('admin.index')
            ->with('success', 'تم حذف المستخدم بنجاح');
    }
    public function getWallet($admin_id)
    {
        $wallet = AdminWallet::select('id', 'wallet_balance', 'admin_id')->where('admin_id', $admin_id)->first();
        if (!$wallet) {
            $wallet = new AdminWallet();
            $wallet->wallet_balance = '0';
            $wallet->admin_id = $admin_id;
            $wallet->save();
        }
        $wallet_history = AdminWalletHistory::select('admin_wallet_histories.*', 'admins.name as adminName', 'customers.name as customerName')
            ->leftjoin('admins', 'admins.id', 'admin_wallet_histories.added_by')
            ->leftjoin('customers', 'customers.id', 'admin_wallet_histories.added_by')
            ->where('wallet_id', $wallet->id)
            ->paginate(100);

        return view('admin.admins.admin_wallet', compact('wallet', 'wallet_history'));
    }

    public function updateWallet(Request $request)
    {
        $wallet = AdminWallet::where('id', $request->wallet_id)->first();
        if ($request->type == "Add") {
            $wallet_balance = $request->wallet_balance + $request->value;
            $wallet->wallet_balance = $wallet_balance;
            $wallet->save();
            WalletHistoryGeneralHelper::addAdminWalletHistory($request->value, "Admin", "Add", Auth::id(), $request->wallet_id);
        } else if ($request->type == "Minus") {
            $wallet_balance = $request->wallet_balance - $request->value;
            $wallet->wallet_balance = $wallet_balance;
            $wallet->save();
            WalletHistoryGeneralHelper::addAdminWalletHistory($request->value, "Admin", "Minus", Auth::id(), $request->wallet_id);
        }

        return redirect()->route('admin.index');
    }
}
