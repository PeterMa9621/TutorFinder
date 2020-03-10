<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
| https://laravel.com/docs/6.x/routing#redirect-routes
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/home');

Route::get('/posts/my', 'Post\MyPostController@index')->name('my_post');

Route::get('/posts/create', 'Post\CreatePostController@index');

Route::post('/posts/create', 'Post\CreatePostController@create')->name('create_post');

Route::get('posts/{id}', 'Post\PostDetailController@detail')->name('post_detail');

Route::post('posts/{id}/contact', 'Post\PostDetailController@contact')->name('post_contact');

Route::get('posts/{id}/edit', 'Post\PostDetailController@edit')->name('edit_post');

Route::post('posts/{id}/edit', 'Post\PostDetailController@edit')->name('edit_post');

Route::post('posts/{id}/delete', 'Post\PostDetailController@delete')->name('delete_post');

Route::post('posts/{id}/close', 'Post\PostDetailController@close')->name('close_post');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/tutor', 'Tutor\TutorController@index')->name('tutor');

Route::get('/profile/{id}', 'Auth\ProfileController@index')->name('profile');

Route::post('/profile/{id}', 'Auth\ProfileController@modify');

Route::post('/profile/{id}/upload', 'Auth\ProfileController@upload')->name('profile_upload');

Route::apiResources([
    'api/course' => 'API\CourseController',
    'api/cantutor' => 'API\CanTutorController',
    'api/post' => 'API\PostController'
    ]);

Route::get('api/post/list/{offset}', 'API\PostController@getPostsWithInfo');
