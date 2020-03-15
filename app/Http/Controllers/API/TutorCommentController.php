<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Tutor\TutorComment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TutorCommentController extends Controller
{
    private $limit;

    public function __construct()
    {
        $this->limit = 5;
    }

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
            'user_id' => $request->input('user_id'),
            'parent_comment' => $request->input('parent_comment'),
        ]);
        $tutorComment = $this->get_comment_with_user_info($tutorComment->id);

        $tutorComment[0]->replied_comments = [];
        return new Response($tutorComment, 200);
    }

    private function get_comment_with_user_info($comment_id){
        $query = "SELECT t.id, t.tutor_id, t.content, t.score, t.created_at, t.updated_at, t.parent_comment, u.id as user_id, u.name, u.avatar
                  FROM tutor_comment t, users u
                  WHERE t.user_id = u.id AND t.id = ?
                  ORDER BY t.created_at DESC;";
        $comments = DB::select($query, [$comment_id]);
        return $comments;
    }

    private function get_comments_with_user_info($tutor_id, $parent_id, $offset){
        $query = "SELECT t.id, t.tutor_id, t.content, t.score, t.created_at, t.updated_at, t.parent_comment, u.id as user_id, u.name, u.avatar
                  FROM tutor_comment t, users u
                  WHERE t.user_id = u.id AND t.tutor_id = ? AND t.parent_comment = ?
                  ORDER BY t.created_at DESC
                  LIMIT ? OFFSET ?;";
        $comments = DB::select($query, [$tutor_id, $parent_id, $this->limit, $offset]);
        return $comments;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $tutor_id
     * @return \Illuminate\Http\Response
     */
    public function show($tutor_id, Request $request)
    {
        $offset = 0;
        if($request->input('offset') != null)
            $offset = $request->input('offset');

        $tutor_comments = $this->get_comments_with_user_info($tutor_id, 0, $offset);

        foreach ($tutor_comments as $tutor_comment){
            $parent_id = $tutor_comment->id;

            $replied_comments = $this->get_comments_with_user_info($tutor_id, $parent_id, $offset);

            $tutor_comment->replied_comments = $replied_comments;
        }
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
