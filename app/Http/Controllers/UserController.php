<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function index(Request $request)
    {
        $listUsers = $this->user->orderByDesc('created_at')->paginate(20);

        return view('users.index', compact('listUsers'));
    }

    public function create()
    {
        $listRoles = $this->role->all();

        return view('users.create', compact('listRoles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'password' => 'required|max:255',
            'role' => 'required'
        ]);

        $data = $request->except(["_token"]);

        $data['password'] = Hash::make($data['password']);
        
        DB::beginTransaction();
        try {
            $newUser = new User();
            $newUser->password = $data['password'];
            $newUser->name = $data['name'];
            $newUser->email = $data['email'];
            $newUser->save();
            $newUser->assignRole($request->role);
            DB::commit();

            return redirect()->route('users.index')->with('success', 'Created user success!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = $this->user->findOrFail($id);
        $listRoles = $this->role->all();

        return view('users.edit', compact('user', 'listRoles'));
    }

    public function test($id)
    {
        $user = $this->user->findOrFail($id)->name;

        Log::alert('Lấy dữ liệu thành công dòng ' . __LINE__);
        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Lấy data thành công!'
        ]);
    }
}
