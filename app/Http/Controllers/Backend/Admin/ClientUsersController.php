<?php

namespace App\Http\Controllers\Backend\Admin;

use Hash;
use App\Helper\ResponseHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use App\Models\{Role, User as ClientUser};
use App\Http\Requests\{StoreClientUser, UpdateClientUser};

class ClientUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $client_users = ClientUser::anyTrash($request->trash);

            return DataTables::of($client_users)
                ->addColumn('roles', function ($client_user) {
                    return $client_user->getRoleNames()->reduce(function ($carry, $each) {
                        return "${carry}<span class='badge badge-primary mr-1'>${each}</span>";
                    });
                })
                ->addColumn('action', function ($client_user) use ($request) {
                    $detail_btn = '';
                    $restore_btn = '';
                    $edit_btn = '<a class="edit text text-primary mr-2" href="' . route('admin.client-users.edit', ['client_user' => $client_user->id]) . '"><i class="far fa-edit fa-lg"></i></a>';

                    if ($request->trash == 1) {
                        $restore_btn = '<a class="restore text text-warning mr-2" href="#" data-id="' . $client_user->id . '"><i class="fa fa-trash-restore fa-lg"></i></a>';
                        $trash_or_delete_btn = '<a class="destroy text text-danger mr-2" href="#" data-id="' . $client_user->id . '"><i class="fa fa-minus-circle fa-lg"></i></a>';
                    } else {
                        $trash_or_delete_btn = '<a class="trash text text-danger mr-2" href="#" data-id="' . $client_user->id . '"><i class="fas fa-trash fa-lg"></i></a>';
                    }

                    return "${detail_btn} ${edit_btn} ${restore_btn} ${trash_or_delete_btn}";
                })
                ->addColumn('plus-icon', function () {
                    return null;
                })
                ->rawColumns(['roles', 'action', 'plus-icon'])
                ->make(true);
        }

        return view('backend.admin.client_users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('guard_name', config('custom_guards.default.user'))->get();
        return view('backend.admin.client_users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientUser $request)
    {
        $created = ClientUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $created->syncRoles($request->roles);

        return redirect()->route('admin.client-users.index')->with('success', 'New User Successfully Created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ClientUser $client_user)
    {
        return view('backend.admin.client_users.show', compact('client_user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientUser $client_user)
    {
        $roles = Role::where('guard_name', config('custom_guards.default.user'))->get();
        return view('backend.admin.client_users.edit', compact('client_user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientUser $request, ClientUser $client_user)
    {
        $client_user->name = $request->name;
        $client_user->email = $request->email;
        if (! empty($request->password)) {
            $client_user->password = Hash::make($request->password);
        }
        $client_user->save();
        $client_user->syncRoles($request->roles);

        return redirect()->route('admin.client-users.index')->with('success', 'Successfully Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientUser $client_user)
    {
        $client_user->delete();
        return ResponseHelper::success();
    }

    public function trash(ClientUser $client_user)
    {
        $client_user->trash();
        return ResponseHelper::success();
    }

    public function restore(ClientUser $client_user)
    {
        $client_user->restore();
        return ResponseHelper::success();
    }
}
