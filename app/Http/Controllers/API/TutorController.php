<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Tutor;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TutorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Tutor::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        return response('Not Implemented', 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $tutor_id
     * @return \Illuminate\Http\Response
     */
    public function show($tutor_id)
    {
        $query = '
            SELECT u.id, u.name, u.email, u.is_tutor, u.wechat, u.facebook, u.avatar, t.id as tutor_id, t.can_tutor, t.comment
            FROM users u, tutor t
            WHERE u.id = t.user_id AND t.id = ?';

        $user = DB::select($query, [$tutor_id]);
        return response($user, 200);
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
        $course = Course::findOrFail($id);
        $course->fill($request->all());
        $course->save();
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
        Course::findOrFail($id)->forceDelete();
        return response('OK', 200);
    }
}
