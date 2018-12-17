<?php

namespace App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Storage;
use Redis;
use DB;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Cache Redis
        // DB::connection()->enableQueryLog();
        // $result = Cache::remember('posts_cache', 1, function()
        // {
        //     return Post::get();
        // });
        
        // $log = DB::getQueryLog();
        // print_r($log);
        // return view('posts.index')->with('posts', $result);


        //tanpa cache
        $posts = Post::all();
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        //handle file upload
        if ($request->hasFile('cover_image')) {
            //get filename with extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //get filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //get extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //filename to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->cover_image = $fileNameToStore;
        // $post->view_count = 0;
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        // return view('posts.show')->with('post', $post);
        $this->id = $id;
        $storage = Redis::connection();

        if ($storage->zScore('articleViews', 'article:'.$id))
        {
            $storage->pipeline(function ($pipe)
            {
                $pipe->zIncrBy('articleViews', 1, 'article:'.$this->id);
                // $pipe->incr('article:'.$this->id.':views');
            });
        }
        else
        {
            $views = $storage->incr('article:'.$this->id.':views');
            $storage->zIncrBy('articleViews', $views, 'article:'.$this->id);

            if ($views == 1) {
                $post->view_count = $views;
                $post->save();
                return view('posts.show')->with('post', $post);
                // return "this is an article with id: ".$id." it has ".$views." views";
            }
        }

        $views = $storage->incr('article:'.$this->id.':views');

        // if ($views == 2) {
        //     $views = $storage->decr('article:'.$this->id.':views');
        // }
        
        $post->view_count = $views;
        $post->save();
        return view('posts.show')->with('post', $post);
        // return "this is an article with id: ".$id." it has ".$views." views";
    } 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        //handle file upload
        if ($request->hasFile('cover_image')) {
            //get filename with extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //get filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //get extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //filename to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }

        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if ($request->hasFile('cover_image')) {
            $post->cover_image = $fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if($post->cover_image != 'noimage.jpg'){
            Storage::delete('public/cover_images/'.$post->cover_image);
        }
        $post->delete();
        return redirect('/posts')->with('success', 'Post Deleted');
    }
}
