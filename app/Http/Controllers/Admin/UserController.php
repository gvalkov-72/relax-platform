<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\Statistic;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->assignRole($request->role);

        return redirect()->route('admin.users.index')->with('success', __('users.messages.created'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users.index')->with('success', __('users.messages.updated'));
    }

    public function show(User $user)
    {
        $user->load(['roles', 'permissions']);

        // Статистики от таблицата statistics
        $stats = Statistic::where('user_id', $user->id)
            ->selectRaw('
                COUNT(*) as total_sessions,
                SUM(duration) as total_duration,
                AVG(duration) as avg_duration
            ')
            ->first();

        return view('admin.users.show', compact('user', 'stats'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', __('users.messages.deleted'));
    }
}