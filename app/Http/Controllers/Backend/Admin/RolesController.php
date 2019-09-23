<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Helper\ResponseHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use App\Models\{Role, Permission};
use App\Http\Requests\{StoreRole, UpdateRole};

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::where('guard_name', $request->guard);

            return DataTables::of($roles)
                        ->addColumn('action', function($role) use ($request) {
                            $detail_btn = '<a class="edit text text-primary mr-3" href="' . route('admin.roles.show', ['role' => $role->id]) . '?guard=' . $request->guard . '"><i class="fas fa-info-circle fa-lg"></i></a>';;
                            $edit_btn = '<a class="edit text text-primary mr-3" href="' . route('admin.roles.edit', ['role' => $role->id]) . '?guard=' . $request->guard . '"><i class="far fa-edit fa-lg"></i></a>';
                            // $trash_or_delete_btn = '<a class="destroy text text-danger mr-2" href="#" data-id="' . $role->id . '"><i class="fa fa-minus-circle fa-lg"></i></a>';

                            return "${detail_btn} ${edit_btn}";
                        })
                        ->addColumn('plus-icon', function($role) {
                            return null;
                        })
                        ->rawColumns(['action', 'plus-icon'])
                        ->make(true);
        }

        return view('backend.admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $permissions = Permission::where('guard_name', $request->guard)->get();
        return view('backend.admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRole $request)
    {
        $created = Role::firstOrCreate(['name' => $request->name, 'guard_name' => $request->guard]);

        if($created) {
            $created->syncPermissions($request->permissions);
            return redirect(config('app.prefix_admin_url') . '/admin/roles?guard=' . $request->guard)->with('success', 'New Role Successfully Created.');
        }
        return back()->withErrors(['error' => 'New Role Create Failed !'])->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('backend.admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Role $role)
    {
        $permissions = Permission::where('guard_name', $request->guard)->get();
        return view('backend.admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRole $request, Role $role)
    {
        $updated = $role->update([
            'name' => $request->name
        ]);
        if($updated) {
            $role->syncPermissions($request->permissions);
            return redirect(config('app.prefix_admin_url') . '/admin/roles?guard=' . $request->guard)->with('success', 'Successfully Updated.');    
        }
        return back()->withErrors(['error' => 'Role Update Failed !'])->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        // $role->delete();
        // return ResponseHelper::success();
    }
}
