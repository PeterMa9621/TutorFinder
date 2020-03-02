<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\Post;
use App\Model\TutoringContent;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Integer;

class MyPostController extends Controller
{
    /**
     * @var int
     */
    private $limit;
    /**
     * @var int
     */
    private $offset;

    protected $postService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PostService $postService)
    {
        $this->middleware('auth');
        $this->limit = 10;
        $this->offset = -1;
        $this->postService = $postService;
    }

    /**
     * Show the all my posts.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = $this->postService->getMyPostsWithInfo($this->limit, $this->offset);
        return view('posts\my_posts', ['posts'=>$posts]);
    }

}
