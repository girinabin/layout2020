<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }



    // axios call
    public function statusPost(Request $request){
        $post = Post::where('id',$request->postid)->first();
        $post->published = $request->checked;
        $post->save();
        return $post;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('id','desc')->get();
        return view('admin.posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create',Post::class);
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>['required','max:255'],
            'image' => ['required','image'],
            'post_content'=>['required']
        ]);

        $fileOriginalName = request('image')->getClientOriginalName();
        $fileExtension = request('image')->getClientOriginalExtension();
        $fileName = time().'-'.$fileOriginalName.'-'.$fileExtension;
        request('image')->move(public_path('uploads/posts'),$fileName);
        

        $post = new Post();
        $post->title = request('title');
        $post->content = request('post_content');
        $post->image_url = $fileName;
        $post->userId = Auth::user()->id;
        $post->save();
        return redirect('/posts')->with('success', 'Post Created Successfully!');
        
        
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('edit',Post::class);
        return view('admin.posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $data = request()->validate([
            'title' => 'required|max:255',
            'image' => 'nullable|image',
            'post_content' => 'required'

        ]);
        if($request->hasFile('image')){
            if(file_exists(public_path('uploads/posts/'.$post->image_url))){
                File::delete(public_path('uploads/posts/'.$post->image_url));
            }
            $fileOriginalName = request('image')->getClientOriginalName();
            $fileExtension = request('image')->getClientOriginalExtension();
            $fileName = time().'-'.$fileOriginalName.'-'.$fileExtension;
            request('image')->move(public_path('uploads/posts'),$fileName);
            $post->image_url = $data['fileName'];
        }
        
         

        $post->title = request('title');
        $post->content = request('post_content');
        $post->save();
        return redirect('/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if(file_exists(public_path('uploads/posts/'.$post->image_url))){
            File::delete(public_path('uploads/posts/'.$post->image_url));
        }
        $post->delete();
        return redirect('/posts');
    }
}
