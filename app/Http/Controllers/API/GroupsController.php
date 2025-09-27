<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Group::with('permissions', 'users')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $data = $request->validate([
            'name'        => 'required|string|max:255|unique:groups,name',
            'description' => 'nullable|string',
        ]);

        $group = Group::create($data);

        return response()->json($group, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json($group->load('permissions', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255|unique:groups,name,'.$group->id,
            'description' => 'nullable|string',
        ]);

        
        $group->update($data);

        return response()->json($group);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group->delete();
        return response()->json(['message' => 'Group deleted']);
    }

     public function assignPermissions(Request $request, Group $group)
    {
        $data = $request->validate([
            'permissions' => 'required|array', // IDs of permissions
        ]);

        $group->permissions()->sync($data['permissions']);

        return response()->json([
            'message' => 'Permissions synced successfully',
            'group'   => $group->load('permissions')
        ]);
    }
}
