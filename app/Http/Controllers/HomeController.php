<?php

namespace App\Http\Controllers;

use App\Model\Course;
use App\Model\Post;
use App\Model\TutoringContent;
use App\Services\PostService;
use App\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    protected $courses = [];
    protected $tutoring_content = [];
    protected $limit = 10;
    protected $offset = 0;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->courses = Course::all();
        $this->tutoring_content = TutoringContent::all();

    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @param PostService $postService
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, PostService $postService)
    {
        #$posts = $postService->getPostsWithInfo($this->limit, $this->offset);
        return view('home');
    }
}
