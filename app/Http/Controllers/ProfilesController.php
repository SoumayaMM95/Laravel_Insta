<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cache;

class ProfilesController extends Controller
{
  public function index(User $user) //passed in user
  {
      //if the user is auth then lets grab the auth user following
      //is the auth user following contains the passed in user otherwise return false
      //false means not following
      $follows = (auth()->user()) ? auth()->user()->following->contains($user->id):false;

      //$postsCount = $user->posts->count();
      //$followersCount= $user->profile->followers->count();
      //$followingCount = $user->following->count();

      $postsCount = Cache::remember(
        'count.posts.'.$user->id,
        now()->addSeconds(30),
        function() use ($user){
          return $user->posts->count();
        });

      $followersCount = Cache::remember(
        'count.followers.'.$user->id,
        now()->addSeconds(30),
        function() use ($user){
          return $user->profile->followers->count();
        });

      $followingCount = Cache::remember(
        'count.following.'.$user->id,
        now()->addSeconds(30),
        function() use ($user){
          return $user->following->count();
        });


      return view('profiles.index',compact('user','follows','postsCount','followersCount','followingCount'));
  }

  public function edit(User $user)
  {
    $this->authorize('update',$user->profile);

    return view('profiles.edit',compact('user'));
  }

  public function update(User $user)
  {
    $this->authorize('update',$user->profile);

    $data = Request()->validate([
      'title'=>'required',
      'description'=>'required',
      'url'=>'url',
      'image'=>'',
    ]);


    if(request('image')){
      $imagepath = request('image')->store('profile','public');
      $image = Image::make(public_path("storage/{$imagepath}"))->fit(1000,1000);
      $image->save();

      $imageArray=['image'=>$imagepath];
    }

    //we added auth so no one can edit the profile if its not the actual user and the user is logged in
    //auth()->user()->profile->update($data);

    auth()->user()->profile->update(array_merge(
      $data, // the data array have a key of image (the old image)
      $imageArray ?? []// this array overwrite that image, but if the image array is not set default to an empty array; the empty array will not overwrite anything.
    ));

    return redirect("/profile/{$user->id}");

  }
}
