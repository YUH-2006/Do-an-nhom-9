<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::orderByDesc('created_at')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',user_id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật khách hàng thành công');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // Có thể thêm logic kiểm tra nếu user đang có đơn hàng thì không cho xóa hoặc xóa kèm
        $user->delete();
        return back()->with('success', 'Xóa người dùng thành công');
    }
}
