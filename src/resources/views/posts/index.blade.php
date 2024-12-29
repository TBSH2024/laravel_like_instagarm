@extends('layouts.app')

@section('title', '投稿一覧')

@section('content')

@if (session('message'))
  <x-post-messages :type="session('type')" :message="session('message')" />
@endif

<div class="container mx-auto grid grid-cols-1 gap-2 my-4 max-w-screen-lg">
  @auth
  <div>
  <a href="/post/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full cursor-pointer my-4">新規投稿</a>
  </div>
  @endauth
<div class="grid grid-cols-3 gap-4 my-4 max-w-screen-lg m-auto">
  @foreach($posts as $post)
  <div class="overflow-hidden shadow-lg rounded-lg h-90 w-80 md:w-80 cursor-pointer m-auto shadow-lg">
    <a href="{{ route('post.show', ['post' => $post]) }}" class="w-full block h-full">
    @if ($post->postImages->count() > 0)
    <div class="swiper">
    <div class="swiper-wrapper">
    @foreach ($post->postImages as $image)
    <div class="swiper-slide">
      <img class="blog photo max-h-40 w-full object-cover" src="{{ asset($image->url) }}" alt="{{ $post->title }}">
    </div>
    @endforeach
    </div>
    <div class="swiper-pagination"></div>

    <!-- If we need navigation buttons -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
    </div>
    @else
      <img alt="blog photo" src="#">
    @endif
    <div class="bg-white dark:bg-gray-800 w-full p-4">
      <p class="text-gray-800 dark:text-white text-xl font-medium mb-2">
        {{ $post->title }}
      </p>
      <p class="text-gray-600 dark:text-gray-300 font-md">
      {{ $post->body }}
      </p>
      <p class="text-gray-300 text-right">
        by: <i>{{ $post->user->name}}</i>
      </p>
    </div>
    </a>
  </div>
  @endforeach
</div>
</div>
@endsection