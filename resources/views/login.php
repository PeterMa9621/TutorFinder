<h1>
    Login Page
</h1>
<?php
$posts = App\Post::all();
$url = route('login');
echo $url;
echo $posts;