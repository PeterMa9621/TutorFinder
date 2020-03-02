<?php


namespace App\Services;


use App\Model\Course;
use App\Model\Post;
use App\Model\TutoringContent;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostService
{
    public function all(){
        return Post::all();
    }

    public function get($id){
        $post = Post::findOrFail($id);
        return $post;
    }

    public function update(array $data, $id){
        $post = Post::findOrFail($id);
        $post->fill($data);
        $post->save();
        return $post;
    }

    public function create(Request $request){
        $post = Post::create([
            'poster' => Auth::id(),
            'tutoring_content' => $request->input('tutoring_content'),
            'when' => $request->input('when'),
            'course' => $request->input('course'),
        ]);
        return $post;
    }

    public function delete($id){
        return Post::findOrFail($id)->forceDelete();
    }

    public function close($id){
        $post = Post::findOrFail($id);
        if($post->closed_at!=null)
            $post->closed_at = null;
        else
            $post->closed_at = date('Y-m-d H:i', time());
        $post->save();
    }

    public function getPostDetail($id){
        $post = Post::findOrFail($id);
        $course = Course::findOrFail($post->course);
        $tutoring_content = TutoringContent::findOrFail($post->tutoring_content);
        $poster = User::findOrFail($post->poster);

        return [$post, $course, $tutoring_content, $poster];
    }

    public function getMyPostsWithInfo($limit, $offset){
        $query = '
            SELECT p.id, p.created_at, p.updated_at, p."when", (c.code || " - " || c.name) as course, t.content as tutoring_content, u.name as username, p.closed_at IS NOT NULL as is_closed
            FROM post p, course c, tutoring_content t, users u
            WHERE p.course = c.id AND p.tutoring_content = t.id AND p.poster = u.id AND u.id = ?
            ORDER BY p.created_at DESC
            LIMIT ?
            OFFSET ?;';
        $posts = DB::select($query, [Auth::id(), $limit, $offset]);
        return $posts;
    }

    public function getPostsWithInfo($limit, $offset){
        $query = '
            SELECT p.id, p.created_at, p.updated_at, p."when", (c.code || " - " || c.name) as course, t.content as tutoring_content, u.name as username 
            FROM post p, course c, tutoring_content t, users u
            WHERE p.course = c.id AND p.tutoring_content = t.id AND p.poster = u.id AND p."when" >= datetime(CURRENT_TIMESTAMP,"localtime") AND p.closed_at IS NULL
            ORDER BY p.created_at DESC
            LIMIT ?
            OFFSET ?;';
        $posts = DB::select($query, [$limit, $offset]);

        return $posts;
    }
}