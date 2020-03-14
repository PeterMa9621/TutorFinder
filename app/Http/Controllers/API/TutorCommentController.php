<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Tutor\TutorComment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TutorCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = [
            'store' => 'ss'
        ];
        return json_encode($list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tutorComment = TutorComment::create([
            'tutor_id' => $request->input('tutor_id'),
            'content' => $request->input('content'),
            'score' => $request->input('score'),
            'user_id' => $request->input('user_id')
        ]);
        return new Response($tutorComment, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $tutor_id
     * @return \Illuminate\Http\Response
     */
    public function show($tutor_id)
    {
        $tutor_comments = TutorComment::where('tutor_id', $tutor_id)->orderBy('created_at', 'desc')->get();
        return new Response($tutor_comments, 200);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
