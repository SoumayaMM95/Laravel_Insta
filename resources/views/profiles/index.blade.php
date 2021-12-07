@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-4 pt-5 pl-5">
        <img src="{{$user->profile->profileImage() }}" class="rounded-circle w-100">
      </div>

      <div class="col-8 pt-5">
        <div class="d-flex pb-3 justify-content-between align-items-baseline">
          <div class="d-flex align-items-center">
            <div class="h3 pr-5">
              {{ $user->username }}
            </div>
            <!--<button class="btn btn-primary ml-4">Follow</button>-->
            <follow-button user-id="{{$user->id}}" follows="{{$follows}}"></follow-button>
          </div>

          <!--if the user is authorized to update then show this button-->
          @can('update',$user->profile)
          <a href="/p/create" >Add new post</a>
          @endcan
        </div>

        <!--if the user is authorized to update then show this button-->
        @can('update',$user->profile)
        <a href="/profile/{{$user->id}}/edit" >Edit profile</a>
        @endcan

        <div class="d-flex">
          <div class="pr-5"><strong>{{ $postsCount }}</strong> posts</div>
          <div class="pr-5"><strong>{{ $followersCount }}</strong> followers</div>
          <div class="pr-5"><strong>{{ $followingCount }}</strong> following</div>
        </div>

        <div class="pt-4 font-weight-bold">{{ $user->profile->title }}</div>
        <div>{{ $user->profile->description }}</div>
        <div><a href="#">{{ $user->profile->url }}</a></div>
      </div>
    </div>
    <div class="row d-flex pt-5">

@foreach ($user->posts as $post)
    <div class="col-4 pb-4">
      <a href="/p/{{$post->id}}">
        <img src="/storage/{{ $post->image }}" class="w-100">
      </a>
    </div>
@endforeach
    </div>


</div>
@endsection
