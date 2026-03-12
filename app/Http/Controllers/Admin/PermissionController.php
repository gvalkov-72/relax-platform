<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    public function index()
    {
        $permissions = Permission::paginate(20);

        return view('admin.permissions.index', compact('permissions'));
    }


    public function create()
    {
        return view('admin.permissions.create');
    }


    public function store(Request $request)
    {

        Permission::create([
            'name'=>$request->name
        ]);

        return redirect()->route('admin.permissions.index');
    }


    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }


    public function update(Request $request, Permission $permission)
    {

        $permission->update([
            'name'=>$request->name
        ]);

        return redirect()->route('admin.permissions.index');
    }


    public function destroy(Permission $permission)
    {
        $permission->delete();

        return back();
    }

}