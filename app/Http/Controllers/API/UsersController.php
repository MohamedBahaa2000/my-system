<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($search = $request->query('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name','like',"%{$search}%")
                  ->orWhere('email','like',"%{$search}%")
                  ->orWhere('phone','like',"%{$search}%");
            });
        }

        $users = $query->with('groups')->paginate($request->get('per_page', 10));

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'profile_photo' => 'nullable|image|max:2048',
            'groups'   => 'nullable|array'
        ]);

        // رفع صورة البروفايل لو موجودة
        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        // ربط المستخدم بالجروبات
        if (!empty($data['groups'])) {
            $user->groups()->sync($data['groups']);
        }

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json($user->load('groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'sometimes|required|string|max:255',
            'email'    => 'sometimes|required|email|unique:users,email,'.$user->id,
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
            'profile_photo' => 'nullable|image|max:2048',
            'groups'   => 'nullable|array'
        ]);

        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        if (isset($data['groups'])) {
            $user->groups()->sync($data['groups']);
        }

        return response()->json($user->load('groups'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}
