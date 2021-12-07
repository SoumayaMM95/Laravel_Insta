<?php

namespace App\Http\Controllers;

use App\post;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function index()
    {
      //grab all user_id of the user that the auth user is following
      $users = auth()->user()->following()->pluck('profiles.user_id');

      //$posts = Post::whereIn('user_id', $users)->orderBy('created_at','DESC')->get();
      //$posts = Post::whereIn('user_id', $users)->latest()->get();
//paginate is used to limit the number of shown posts in a single page
// with('user') is used to fetsh all the user in one query 
      $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5);
      //dd($posts);
      return view('posts.index',compact('posts'));
    }


    public function create()
    {
      return view('posts.create');
    }


    public function store()
    {
      $data = request()->validate([
        'caption' => 'required',
        'image' => ['required', 'image'],
      ]);

      $imagepath = request('image')->store('uploads','public');

      $image = Image::make(public_path("storage/{$imagepath}"))->fit(1200,1200);
      $image->save();

      auth()->user()->posts()->create([
        'caption'=>$data['caption'],
        'image'=> $imagepath,
      ]);

      //dd($imagepath);

      return redirect('/profile/'. auth()->user()->id);

    }

    public function show(\App\Post $post)
    {
      return view('posts.show', compact('post'));
    }

}
