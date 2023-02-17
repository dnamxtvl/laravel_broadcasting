<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function index(Request $request)
    {
        $listRoles = $this->role->orderBy('created_at')->paginate(20);

        return view('roles.index', compact('listRoles'));
    }

    public function create()
    {
        $listPermissions = config('role');

        return view('roles.create', compact('listPermissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role_name' => 'required|max:255|unique:roles,name',
        ]);

        $listPermissions = $request->except(['_token', 'role_name']);

        DB::beginTransaction();
        try {
            $role = new Role();
            $role->name = $request->role_name;
            $role->guard_name = 'web';
            $role->save();

            if ($role && count($listPermissions)) {
                $role->givePermissionTo(array_keys($listPermissions));
            }
            DB::commit();

            return redirect()->route('roles.index')->with('success', 'Thêm role thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('roles.index')->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $role = $this->role->findOrFail($id);
        $listPermissions = $role->permissions()->pluck('name')->toArray();

        return view('roles.edit', compact('role', 'listPermissions'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'role_name' => 'required|max:255|unique:roles,name,'. $id,
        ]);

        $role = $this->role->findOrFail($id);
        $listPermissions = $request->except(['_token', 'role_name', '_method']);
        
        DB::beginTransaction();
        try {
            $role->name = $request->role_name;
            $role->save();

            if ($role && count($listPermissions)) {
                $role->syncPermissions(array_keys($listPermissions));
            }
            DB::commit();

            return redirect()->route('roles.index')->with('success', 'Cập nhật role thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('roles.index')->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $role = $this->role->findOrFail($id);
        try {
            DB::table('model_has_roles')->where('role_id', $id)->delete();
            $deletedPermissionIds = $role->permissions()->pluck('id')->toArray();
            DB::table('model_has_permissions')->whereIn('permission_id', $deletedPermissionIds)->delete();
            $role->permissions()->detach();
            $role->delete();
            return redirect()->route('roles.index')->with('success', 'Xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->route('roles.index')->with('error', $e->getMessage());
        }
    }
}
