<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PersonalInfoController extends Controller
{
    public function showAllPersonalInfo()
    {
        $personalInfos = DB::select('SELECT * FROM PersonalInfo');

        return $personalInfos;
    }

    public function showOnePersonalInfo($userId)
    {
        $personalInfo = DB::select('SELECT * FROM PersonalInfo WHERE userId=?', [$userId]);
        return $personalInfo;
    }


    public function updatePersonalInfo(Request $request)
    {

        $this->validate($request, [
            'personalInfoId' => 'required',
            'fName' => 'required',
            'mName' => 'nullable',
            'lName' => 'required',
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
            'zipCode' => 'required',
            'contactNo' => 'required',
            'email' => 'required',
            'birthDate' => 'required',
            'photoURL' => 'nullable'
        ]);

        $query = "EXEC updatePersonalInfo @_personalInfoId=?, @_fName=?, @_mName=?, @_lName=?, @_address=?, @_city=?, @_province=?, @_zipCode=?, @_contactNo=?, @_email=?, @_birthDate=?, @_photoURL=?";

        $personalInfo = DB::update($query, [$request->personalInfoId, $request->fName, $request->mName, $request->lName, $request->address, $request->city, $request->province, $request->zipCode, $request->contactNo, $request->email, $request->birthDate, $request->photoURL]);

        return response()->json('PersonalInfo updated successfully', 200);
    } 
    
    
    public function addPersonalInfo(Request $request)
    {

        $this->validate($request, [
            'userId' => 'required',
            'fName' => 'required',
            'mName' => 'nullable',
            'lName' => 'required',
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
            'zipCode' => 'required',
            'contactNo' => 'required',
            'email' => 'required',
            'birthDate' => 'required',
            'photoURL' => 'nullable'
        ]);

        // setting default photoURL
        $request->photoURL = ($request->photoURL == null) ? "https://iupac.org/wp-content/uploads/2018/05/default-avatar.png" : $request->photoURL;

        $query = "EXEC addPersonalInfo @_userId=?, @_fName=?, @_mName=?, @_lName=?, @_address=?, @_city=?, @_province=?, @_zipCode=?, @_contactNo=?, @_email=?, @_birthDate=?, @_photoURL=?";

        $personalInfo = DB::insert($query, [$request->userId, $request->fName, $request->mName, $request->lName, $request->address, $request->city, $request->province, $request->zipCode, $request->contactNo, $request->email, $request->birthDate, $request->photoURL]);

        return response()->json('PersonalInfo created successfully', 201);
    }

    public function deletePersonalInfo($personalInfoId)
    {
        $query = 'EXEC deletePersonalInfo @_personalInfoId=?';
        DB::delete($query, [$personalInfoId]);

        return response()->json('PersonalInfo Deleted successfully', 200);
    }
}
