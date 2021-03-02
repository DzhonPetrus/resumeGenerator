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

        if($user === [])
            return response()->json('User does not exist', 404);

        return $user;
    }

    public function showOneUserByUsername($username)
    {
        $user = DB::select('SELECT userId, username FROM Users WHERE username=?', [$username]);

        return $user;
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);


        $userExist = $this->showOneUserByUsername($request->username);

        if(count($userExist) !== 0)
            return response()->json('User already exist');

        $user = DB::insert('EXEC addUser @_username=?, @_password=?', [$request->username, $request->password]);

        return response()->json($this->showOneUserByUsername($request->username), 201);
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

    public function updateUserPassword(Request $request)
    {
        $this->validate($request, [
            'userId' => 'required',
            'password' => 'required',
        ]);
        $user = DB::update('EXEC updateUserPassword @_userId=?, @_password=?', [$request->userId, $request->password]);

        $user = $this->showOneUser($request->userId);

        return response()->json(['Password has been successfully updated', $user], 200);
    }
}
