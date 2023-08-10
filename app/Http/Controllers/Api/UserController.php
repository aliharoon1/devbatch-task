<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index() :JsonResponse
    {
        $user = Auth::user();

        try {
            $this->authorize('viewAny', User::class);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($user->isAdmin()) {
            $users = User::all();
        } elseif ($user->isManager()) {
            $users = User::where('id', $user->id)
            ->orWhere('role_id', Role::where('slug', 'regular_user')->first()->id)
                ->get();
        } else {
            $users = User::where('id', $user->id)->get();
        }

        return response()->json($users);
    }

    public function update(Request $request, User $user): JsonResponse
    {

        $authUser = Auth::user();

        try {
            $this->authorize('update', $user);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        if (!$authUser->isAdmin()) {
           if ($authUser->isManager() && !$user->isRegularUser()) {
                return response()->json(['message' => 'Unauthorized'], 403);
           }
        }

        $user->update($request->all());

        return response()->json(['message' => 'User updated successfully']);
    }

    public function destroy(User $user): JsonResponse
    {

        $authUser = Auth::user();

        try {
            $this->authorize('delete', $user);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if (!$authUser->isAdmin()) {

            if ($authUser->isManager() && !$user->isRegularUser()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
            else if ($authUser->isRegularUser()){
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
