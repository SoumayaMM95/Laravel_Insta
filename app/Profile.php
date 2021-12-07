<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
  protected $guarded = []; // it mean we want to ignore all the fields, we don't want to insert values
//for disabling mass assignment
//mass assignment is a process  of sending an array of data that will be saved to the specified model at once
// Mass assignment is good, but there are certain security problems behind it.
//guarded specifies which fields are not mass assignable.

//call this function every time we need the profile image (default profile or the profile image that the user uploaded)
  public function profileImage()
  {
    $imagepath = ($this->image) ? $this->image:'profile/by45njP2ViNr5bO5CNndtI3rlI1t1MHjMGEOGUiN.jpg';
    return '/storage/'.$imagepath;
  }


  public function user()
  {
    return $this->belongsTo(User::class);
  }

//a profile can has many users that follow it 
  public function followers()
  {
    return $this->belongsToMany(User::class);
  }

}
