<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Post;

class PagesController extends Controller
{
    public function index() {
        // $title = 'Welcome';
        // return view('pages.index')->with('title', $title);
        $storage = Redis::connection();

        $popular = $storage->zRevRange('articleViews', 0, 0);

        foreach ($popular as $value) {
            // echo $value;
            $id = str_replace('article:', '', $value);
            // echo "article ".$id." is popular"."<br>";
        }
        
        $posts = Post::all()->where('id', $id);
        return view('pages.index')->with('posts', $posts);
    }

}
