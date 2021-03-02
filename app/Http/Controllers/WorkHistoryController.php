<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class WorkHistoryController extends Controller
{
    public function showAllWorkHistoryByUserId($userId)
    {
        $workHistories = DB::select('SELECT * FROM WorkHistory WHERE userId=? ORDER BY startDate DESC', [$userId]);

        return $workHistories;
    }

    public function showAllWorkHistory()
    {
        $workHistories = DB::select('SELECT * FROM WorkHistory ORDER BY startDate DESC');

        return $workHistories;
    }

    public function showOneWorkHistory($workHistoryId)
    {
        $workHistory = DB::select('SELECT * FROM WorkHistory WHERE workHistoryId=? ORDER BY startDate DESC', [$workHistoryId]);
        return $workHistory;
    }


    public function addWorkHistory(Request $request)
    {

        $this->validate($request, [
            'userId' => 'required',
            'jobTitle' => 'required',
            'employer' => 'required',
            'startDate' => 'required',
            'endDate' => 'nullable',
            'location' => 'required',
            'jobDescription' => 'required',
        ]);


        $query = "EXEC addWorkHistory @_userId=?, @_jobTitle=?, @_employer=?, @_startDate=?, @_endDate=?, @_location=?, @_jobDescription = ? ";

        $workHistory = DB::insert($query, [$request->userId, $request->jobTitle, $request->employer, $request->startDate, $request->endDate, $request->location, $request->jobDescription]);

        return response()->json(['Work History created successfully', $workHistory], 201);
    }


    public function updateWorkHistory(Request $request)
    {

        $this->validate($request, [
            'workHistoryId' => 'required',
            'jobTitle' => 'required',
            'employer' => 'required',
            'startDate' => 'required',
            'endDate' => 'nullable',
            'location' => 'required',
            'jobDescription' => 'required',
        ]);

        $query = "EXEC updateWorkHistory @_workHistoryId=?, @_jobTitle=?, @_employer=?, @_startDate=?, @_endDate=?, @_location=?, @_jobDescription = ? ";

        $workHistory = DB::update($query, [$request->workHistoryId, $request->jobTitle, $request->employer, $request->startDate, $request->endDate, $request->location, $request->jobDescription]);

        return response()->json(['WorkHistory updated successfully',$workHistory], 200);
    }



    public function deleteWorkHistory($workHistoryId)
    {
        $query = 'EXEC deleteWorkHistory @_workHistoryId=?';
        DB::delete($query, [$workHistoryId]);

        return response()->json(['WorkHistory Deleted successfully'], 200);
    }
}
