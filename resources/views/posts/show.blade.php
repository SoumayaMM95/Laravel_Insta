@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-8">
      <img src="/storage/{{$post->image}}" class="w-100">
    </div>
    <div class="col-4">
      <div class="row align-items-baseline">
        <div class="col-3">
          <img src="{{$post->user->profile->profileImage() }}" class="rounded-circle w-100">
        </div>
        <div class="d-flex col-9">
          <p class="font-weight-bold">
            <a href="/profile/{{$post->user->id}}">
              <span class="text-dark">{{$post->user->username}}</span>
            </a>
          </p>
          <a href="#" class="pl-3">Follow</a>
        </div>
      </div>
      <hr>
      <div class="pt-3">
        <p>
          <span class="font-weight-bold">
            <a href="/profile/{{$post->user->id}}">
              <span class="text-dark">{{$post->user->username}}</span>
            </a>
          </span>  {{$post->caption}}
        </p>
      </div>
    </div>
  </div>
</div>

@endsection
