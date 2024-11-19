<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UsersResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $users = User::latest()->paginate(5);
        return new UsersResource(true, 'List of Users', $users);
    }

    /**
     * store
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string',
            'email'    => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return new UsersResource(true, 'User successfully created!', $user);
    }

    /**
     * show
     *
     * @param mixed $id
     * @return void
     */
    // public function show($id)
    // {
    //     $user = User::find($id);
    //     if (!$user) {
    //         return response()->json(['error' => 'User not found'], 404);
    //     }
    //     return new UsersResource(true, 'User details retrieved!', $user);
    // }

    public function show(Request $request)
{
    $email = $request->input('email');
    $user = User::where('email', $email)->first();

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    return new UsersResource(true, 'User details retrieved!', $user);
}


    /**
     * update
     *
     * @param Request $request
     * @param mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string',
            'email'    => 'required|string|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8', // Password is optional during update
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return new UsersResource(true, 'User successfully updated!', $user);
    }

    /**
     * destroy
     *
     * @param mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->delete();
        return new UsersResource(true, 'User successfully deleted!', null);
    }
}
