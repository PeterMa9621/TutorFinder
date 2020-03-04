<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\Post;
use App\Model\TutoringContent;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Integer;

class CreatePostController extends Controller
{
    protected $postService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('posts/create_post', ['courses'=>Course::all(), 'tutoring_contents'=>TutoringContent::all()]);
    }

    /**
     * Create a post.
     *
     * @param  Request $request
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Request $request)
    {
        $post = $this->postService->create($request);
        return redirect(route('post_detail', ['id'=>$post->id]));
    }

}
