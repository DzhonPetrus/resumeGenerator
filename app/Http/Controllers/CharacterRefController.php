<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CharacterRefController extends Controller
{
    public function showAllCharacterRef()
    {
        $characterRef = DB::select('SELECT * FROM CharacterRef');

        return $characterRef;
    }

    public function showAllCharacterRefByUserId($userId)
    {
        $characterRef = DB::select('SELECT * FROM CharacterRef WHERE userId=?', [$userId]);
        return $characterRef;
    }

    public function showOneCharacterRef($charRefId)
    {
        $characterRef = DB::select('SELECT * FROM CharacterRef WHERE charRefId=?', [$charRefId]);
        return $characterRef;
    }


    public function addCharacterRef(Request $request)
    {

        $this->validate($request, [
            'userId' => 'required',
            'name' => 'required',
            'jobTitle' => 'required',
            'contactNo' => 'required',
            'email' => 'required'
        ]);

        $query = "EXEC addCharacterRef @_userId=?, @_name=?, @_jobTitle=?,@_contactNo=?, @_email=?";

        $characterRef = DB::insert($query, [$request->userId, $request->name, $request->jobTitle, $request->contactNo, $request->email]);

        return response()->json(['CharacterRef created successfully',$characterRef], 201);
    }



    public function updateCharacterRef(Request $request)
    {

        $this->validate($request, [
            'userId' => 'required',
            'name' => 'required',
            'jobTitle' => 'required',
            'contactNo' => 'required',
            'email' => 'required'
        ]);

        $query = "EXEC updateCharacterRef @_charRefId=?, @_name=?, @_jobTitle=?,@_contactNo=?, @_email=?";

        $characterRef = DB::update($query, [$request->charRefId, $request->name, $request->jobTitle, $request->contactNo, $request->email]);


        return response()->json(['CharacterRef updated successfully',$characterRef], 200);
    }



    public function deleteCharacterRef($charRefId)
    {
        $query = 'EXEC deleteCharacterRef @_charRefId=?';
        DB::delete($query, [$charRefId]);

        return response()->json(['CharacterRef Deleted successfully', $query], 200);
    }
}
