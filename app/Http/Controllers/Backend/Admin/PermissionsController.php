<?php

namespace App\Http\Controllers\Backend\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\{StorePermission, UpdatePermission};
use App\Models\{Role, Permission};
use Yajra\DataTables\DataTables;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) { 
            $permissions = Permission::where('guard_name', $request->guard);
            return DataTables::of($permissions)->make(true);
        }

        return view('backend.admin.permissions.index');
    }

    public function create()
    {
        $guards = config('custom_guards.default');
        return view('backend.admin.permissions.create', compact('guards'));
    }

    public function store(StorePermission $request)
    {
        $guards = array_intersect(array_values(config('custom_guards.default')), $request->guards ?? []);
        if(! count($guards)) {
            return back()->with('error', 'Please choose valid guard.')->withInput();
        }

        foreach($guards as $each_guard) {
            Permission::firstOrCreate([
                'name' => $request->name,
                'guard_name' => $each_guard
            ]);
        }
        return redirect()->route('admin.permissions.index')->with('success', 'New Permission Successfully Created.');
    }
}
