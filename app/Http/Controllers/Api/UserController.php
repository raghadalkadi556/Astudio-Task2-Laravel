<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('first_name')) {
            $query->where('first_name', $request->first_name);
        }

        if ($request->has('last_name')) {
            $query->where('last_name', $request->last_name);
        }

        if ($request->has('date_of_birth')) {
            $query->where('date_of_birth', $request->date_of_birth);
        }

        if ($request->has('gender')) {
            $query->where('gender', $request->gender);
        }

        return response()->json($query->get());
    }

    public function show($id)
    {
        return response()->json(User::find($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:male,female',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json($user, 201);
    }

    public function update(Request $request)
    {
        $user = User::findOrFail($request->id);

        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->delete();

        return response()->json(null, 204);
    }
}

