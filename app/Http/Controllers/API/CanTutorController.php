<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Tutor\CanTutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CanTutorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(CanTutor::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        CanTutor::create([
            'tutor_id' => $request->input('tutor_id'),
            'course' => $request->input('course'),
        ]);
        return response('OK', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $query = '
            SELECT course.*
            FROM can_tutor, course
            WHERE course = id AND tutor_id = ?;';
        $result = DB::select($query, [$id]);

        return response($result, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return response('OK', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response('OK', 200);
    }
}
