<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

//this boot method is what gets called when we are booting up the model
//
    protected static function boot()
    {
      parent::boot ();
      //the created event gets fired whenever a new user gets created
      static::created(function($user){
        $user->profile()->create([
          'title'=> $user->username,
        ]);


        //sending welcome email when creating a new profile using mailtrap
        //grab the username and the password from the mailtrap account (mailtrap.io) and paste it in the .env file
        //use this command to make the mail
        //php artisan make:mail NewUserWelcomeMail -m emails.welcome-email
      //  Mail::to($user->email)->send(new NewUserWelcomeMail()); -->this line of code is not working
      });

    }


    public function posts()
    {
      return $this->hasMany(Post::class)->orderBy('created_at','DESC');
    }

//the user can follow many profiles
    public function following()
    {
      return $this->belongsToMany(Profile::class);
    }

    public function profile()
    {
      return $this->hasOne(Profile::class);
    }
}
