<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EducationBGController extends Controller
{
    public function showAllEducationBGByUserId($userId)
    {
        $educationGBs = DB::select('SELECT * FROM EducationBG WHERE userId=? ORDER BY startDate DESC', [$userId]);

        return $educationGBs;
    }

    public function showAllEducationBG()
    {
        $educationBG = DB::select('SELECT * FROM EducationBG ORDER BY startDate DESC');

        return $educationBG;
    }

    public function showOneEducationBG($educationId)
    {
        $educationBG = DB::select('SELECT * FROM EducationBG WHERE educationId=? ORDER BY startDate DESC', [$educationId]);
        return $educationBG;
    }


    public function addEducationBG(Request $request)
    {

        $this->validate($request, [
            'userId' => 'required',
            'studyType' => 'required',
            'course' => 'nullable',
            'institution' => 'required',
            'location' => 'required',
            'startDate' => 'required',
            'endDate' => 'nullable'
        ]);

        $query = "EXEC addEducationBG @_userId=?, @_studyType=?, @_course=?, @_institution=?, @_location=?, @_startDate=?, @_endDate=?";

        $educationBG = DB::insert($query, [$request->userId, $request->studyType, $request->course,$request->institution, $request->location, $request->startDate, $request->endDate]);

        return response()->json(['EducationBG created successfully',$educationBG], 201);
    }



    public function updateEducationBG(Request $request)
    {


        $this->validate($request, [
            'educationId' => 'required',
            'studyType' => 'required',
            'course' => 'nullable',
            'institution' => 'required',
            'location' => 'required',
            'startDate' => 'required',
            'endDate' => 'nullable'
        ]);

        $query = "EXEC updateEducationBG @_educationId=?, @_studyType=?, @_course=?, @_institution=?, @_location=?, @_startDate=?, @_endDate=?";

        $educationBG = DB::update($query, [$request->educationId, $request->studyType, $request->course, $request->institution, $request->location, $request->startDate, $request->endDate]);

        return response()->json(['EducationBG updated successfully',$educationBG], 200);
    }



    public function deleteEducationBG($educationId)
    {
        $query = 'EXEC deleteEducationBG @_educationId=?';
        DB::delete($query, [$educationId]);

        return response()->json(['EducationBG Deleted successfully',$query], 200);
    }
}
