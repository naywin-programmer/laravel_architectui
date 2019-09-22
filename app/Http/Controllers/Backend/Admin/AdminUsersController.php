<?php

namespace App\Http\Controllers\Backend\Admin;

use Hash;
use App\Helper\ResponseHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use App\Models\{Role, AdminUser};
use App\Http\Requests\{StoreAdminUser, UpdateAdminUser};

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $admin_users = AdminUser::anyTrash($request->trash);

            return DataTables::of($admin_users)
                ->addColumn('roles', function ($admin_user) {
                    return $admin_user->getRoleNames()->reduce(function($carry, $each) {
                        return "${carry}<span class='badge badge-primary mr-1'>${each}</span>";
                    });
                })
                ->addColumn('action', function ($admin_user) use ($request) {
                    $detail_btn = '';
                    $restore_btn = '';
                    $edit_btn = '<a class="edit text text-primary mr-2" href="' . route('admin.admin-users.edit', ['admin_user' => $admin_user->id]) . '"><i class="far fa-edit fa-lg"></i></a>';

                    if ($request->trash == 1) {
                        $restore_btn = '<a class="restore text text-warning mr-2" href="#" data-id="' . $admin_user->id . '"><i class="fa fa-trash-restore fa-lg"></i></a>';
                        $trash_or_delete_btn = '<a class="destroy text text-danger mr-2" href="#" data-id="' . $admin_user->id . '"><i class="fa fa-minus-circle fa-lg"></i></a>';
                    } else {
                        $trash_or_delete_btn = '<a class="trash text text-danger mr-2" href="#" data-id="' . $admin_user->id . '"><i class="fas fa-trash fa-lg"></i></a>';
                    }

                    return "${detail_btn} ${edit_btn} ${restore_btn} ${trash_or_delete_btn}";
                })
                ->addColumn('plus-icon', function () {
                    return null;
                })
                ->rawColumns(['roles', 'action', 'plus-icon'])
                ->make(true);
        }
        
        return view('backend.admin.admin_users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('guard_name', config('custom_guards.default.admin'))->get();
        return view('backend.admin.admin_users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdminUser $request)
    {
        $created = AdminUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $created->syncRoles($request->roles);

        return redirect()->route('admin.admin-users.index')->with('success', 'New Admin User Successfully Created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(AdminUser $admin_user)
    {
        return view('backend.admin.admin_users.show', compact('admin_user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminUser $admin_user)
    {
        $roles = Role::where('guard_name', config('custom_guards.default.admin'))->get();
        return view('backend.admin.admin_users.edit', compact('admin_user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminUser $request, AdminUser $admin_user)
    {
        $admin_user->name = $request->name;
        $admin_user->email = $request->email;
        if(! empty($request->password)) {
            $admin_user->password = Hash::make($request->password);
        }
        $admin_user->save();
        $admin_user->syncRoles($request->roles);

        return redirect()->route('admin.admin-users.index')->with('success', 'Successfully Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminUser $admin_user)
    {
        $admin_user->delete();
        return ResponseHelper::success();
    }

    public function trash(AdminUser $admin_user)
    {
        $admin_user->trash();
        return ResponseHelper::success();
    }

    public function restore(AdminUser $admin_user)
    {
        $admin_user->restore();
        return ResponseHelper::success();
    }
}
