<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Tutor;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($id)
    {
        $user = User::findOrFail($id);
        // Display Name => Column Name
        $user_attributes = [
            'Name' => 'name',
            'Email' => 'email',
            'Wechat' => 'wechat',
            'Facebook' => 'facebook',
        ];
        $tutor_attributes = [
            'I can tutor' => 'can_tutor',
        ];
        $tutor = null;
        if($user->is_tutor){
            $tutor = Tutor::findOrFail($user->tutor_id);
        }
        return view('auth\profile', ['user' => $user, 'tutor'  => $tutor, 'user_attributes' => $user_attributes, 'tutor_attributes' => $tutor_attributes]);
    }

    public function modify(Request $request, $id){
        $user = User::findOrFail($id);
        $name = $request['name'];
        $email = $request['email'];
        $is_tutor = $request['is_tutor'];
        $wechat = $request['wechat'];
        $facebook = $request['facebook'];

        $user->name = $name;
        $user->email = $email;
        $user->is_tutor = $is_tutor=='on'?1:0;
        $user->wechat = $wechat;
        $user->facebook = $facebook;
        $user->save();
        return redirect(route('profile', ['id'=>$id]));
    }

    public function upload(Request $request, $id){
        $extension = $request->file('file')->extension();
        $filename = $request->user()->id . '.' . $extension;
        $user = Auth::user();
        if($id == $user->id){
            $request->file('file')->storeAs(
                'public\avatars', $filename
            );
            $avatar_url = asset('storage/avatars/' . $filename);
            $user->avatar = $avatar_url;
            $user->save();
            return $avatar_url;
        }
        return 'Error';
    }
}
