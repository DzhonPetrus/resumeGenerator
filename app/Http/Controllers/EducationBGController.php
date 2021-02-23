<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EducationBGController extends Controller
{
    public function showAllEducationBG()
    {
        $educationBG = DB::select('SELECT * FROM EducationBG');

        return $educationBG;
    }

    public function showOneEducationBG($educationId)
    {
        $educationBG = DB::select('SELECT * FROM EducationBG WHERE educationId=?', [$educationId]);
        return $educationBG;
    }


    public function addEducationBG(Request $request)
    {

        $this->validate($request, [
            'userId' => 'required',
            'studyType' => 'required',
            'course' => 'nullable',
            'location' => 'required',
            'startDate' => 'required',
            'endDate' => 'nullable'
        ]);

        $query = "EXEC addEducationBG @_userId=?, @_studyType=?, @_course=?,@_location=?, @_startDate=?, @_endDate=?";

        $educationBG = DB::insert($query, [$request->userId, $request->studyType, $request->course, $request->location, $request->startDate, $request->endDate]);

        return response()->json('EducationBG created successfully', 201);
    }



    public function updateEducationBG(Request $request)
    {


        $this->validate($request, [
            'educationId' => 'required',
            'studyType' => 'required',
            'course' => 'nullable',
            'location' => 'required',
            'startDate' => 'required',
            'endDate' => 'nullable'
        ]);

        $query = "EXEC updateEducationBG @_educationId=?, @_studyType=?, @_course=?,@_location=?, @_startDate=?, @_endDate=?";

        $educationBG = DB::update($query, [$request->educationId, $request->studyType, $request->course, $request->location, $request->startDate, $request->endDate]);

        return response()->json('EducationBG updated successfully', 200);
    }



    public function deleteEducationBG($educationId)
    {
        $query = 'EXEC deleteEducationBG @_educationId=?';
        DB::delete($query, [$educationId]);

        return response()->json('EducationBG Deleted successfully', 200);
    }
}
