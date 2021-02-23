<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showOneUser($userId)
    {
        $user = DB::select('SELECT * FROM Users WHERE userId=?', [$userId]);

        return $user;
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = DB::raw('EXEC addUser @_username=?, @_password=?', [$request->username, $request->password]);

        return response()->json($user, 201);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = DB::select('EXEC loginUser @_username=?, @_password=?', [$request->username, $request->password]);

        return response()->json($user);
    }

    public function updateUserisActive(Request $request)
    {
        $this->validate($request, [
            'userId' => 'required',
            'isActive' => 'required',
        ]);
        $user = DB::update('EXEC updateUserisActive @_userId=?, @_isActive=?', [$request->userId, $request->isActive]);

        $user = $this->showOneUser($request->userId);

        return response()->json($user, 200);
    }
}
