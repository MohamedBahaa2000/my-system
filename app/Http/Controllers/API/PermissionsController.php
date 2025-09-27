<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;


class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json(Permission::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255|unique:permissions,name',
            'description' => 'nullable|string',
        ]);

        $permission = Permission::create($data);

        return response()->json($permission, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json($permission);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255|unique:permissions,name,'.$permission->id,
            'description' => 'nullable|string',
        ]);

        $permission->update($data);

        return response()->json($permission);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json(['message' => 'Permission deleted']);
    }
}
