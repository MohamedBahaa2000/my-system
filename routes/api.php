<?php

use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\API\GroupsController;
use App\Http\Controllers\API\PermissionsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


Route::get('/test-groups', function () {
    return response()->json(['message' => 'groups route test']);
});





Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user'  => $user
    ]);
});


Route::middleware(['auth:sanctum'])->group(function () {

    // Users
    Route::get('users', [UsersController::class,'index'])->middleware('permission:view_users');
    Route::post('users', [UsersController::class,'store'])->middleware('permission:create_users');
    Route::get('users/{user}', [UsersController::class,'show'])->middleware('permission:view_users');
    Route::put('users/{user}', [UsersController::class,'update'])->middleware('permission:edit_users');
    Route::delete('users/{user}', [UsersController::class,'destroy'])->middleware('permission:delete_users');
    Route::post('users/{user}/groups', [UsersController::class,'assignGroups'])->middleware('permission:assign_roles');

    // Groups
    Route::get('groups', [GroupsController::class, 'index'])->middleware('permission:view_groups');
    Route::post('groups', [GroupsController::class, 'store'])->middleware('permission:create_groups');
    Route::get('groups/{group}', [GroupsController::class, 'show'])->middleware('permission:view_groups');
    Route::put('groups/{group}', [GroupsController::class, 'update'])->middleware('permission:edit_groups');
    Route::delete('groups/{group}', [GroupsController::class, 'destroy'])->middleware('permission:delete_groups');
    Route::post('groups/{group}/permissions', [GroupsController::class,'assignPermissions'])->middleware('permission:assign_permissions');

    // Permissions
    Route::get('permissions', [PermissionsController::class, 'index'])->middleware('permission:view_permissions');
    Route::post('permissions', [PermissionsController::class, 'store'])->middleware('permission:create_permissions');
    Route::get('permissions/{permission}', [PermissionsController::class, 'show'])->middleware('permission:view_permissions');
    Route::put('permissions/{permission}', [PermissionsController::class, 'update'])->middleware('permission:edit_permissions');
    Route::delete('permissions/{permission}', [PermissionsController::class, 'destroy'])->middleware('permission:delete_permissions');
});
