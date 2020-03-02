<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\Post;
use App\Model\TutoringContent;
use App\Services\PostService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Integer;

class PostDetailController extends Controller
{

    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Show the application dashboard.
     * @param  Request $request
     * @param  integer  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function detail($id)
    {
        $detail = $this->postService->getPostDetail($id);
        return view('posts\post_detail', ['post' => $detail[0], 'course' => $detail[1], 'tutoring_content' => $detail[2], 'poster' => $detail[3]]);
    }

    public function contact($id){
        if($this->canGetContact()){
            $detail = $this->postService->getPostDetail($id);
            return view('posts\post_detail', ['post' => $detail[0], 'course' => $detail[1], 'tutoring_content' => $detail[2], 'poster' => $detail[3], 'show_contact' => true]);
        } else {
            return response("You don't have permission to view this person's contact information!", 200);
        }
    }

    private function canGetContact(){
        return Auth::user()->is_tutor==true?true:false;
    }

    public function edit(Request $request, $id){
        if($request->isMethod('get')){
            $post = $this->postService->get($id);
            return view('posts\edit_post', ['courses'=>Course::all(), 'tutoring_contents'=>TutoringContent::all(), 'post'=>$post]);
        } elseif($request->isMethod('post')) {
            $post = $this->postService->update($request->all(), $id);
            return redirect(route('post_detail', ['id' => $post->id]));
        }
    }

    public function delete($id){
        $this->postService->delete($id);
        return view('notification\success', ['content'=>'Delete a post successfully!']);
    }

    public function close($id){
        $this->postService->close($id);
        return redirect(route('post_detail', ['id'=>$id]));
    }
}
