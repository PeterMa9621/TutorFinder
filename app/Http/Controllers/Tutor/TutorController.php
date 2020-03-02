<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\Post;
use App\Model\TutoringContent;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TutorController extends Controller
{
    protected $limit = 10;
    protected $offset = -1;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tutors = User::where('is_tutor', true)
            ->where('id', '!=', Auth::id())
            ->get();

        return view('tutors\index', ['tutors' => $tutors]);
    }
}
