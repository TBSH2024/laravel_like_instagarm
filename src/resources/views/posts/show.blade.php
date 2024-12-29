@extends('layouts.app')

@section('title', '投稿詳細')

@section('content')

@if(session('message'))
  <x-post-messages :type="session('type')" :message="session('message')" />
@endif

<div class="grid grid-cols-1 gap-4 my-4">
  <div class="overflow-hidden shadow-lg rounded-lg h-90 w-80 md:w-80 cursor-pointer m-auto shadow-lg">
  @if ($post->postImages->count() > 0)
  <div class="swiper">
    <div class="swiper-wrapper">
    @foreach ($post->PostImages as $image)
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
  </div>
  <div class="grid grid-cols-1">
    @can ('update', $post)
    <div class="justify-self-center mb-12">
    <a class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:text-green-500 dark:hover:text-white dark:bg-green-800 dark:text:green-400 dark:hover:text-gray dark:hover:bg-gray-700 w-36" href="{{ route('post.edit', ['post' => $post]) }}">編集する</a>
    </div>
    <div class="justify-self-center mb-12">
    <form action="{{ route('post.delete', ['post' => $post]) }}" method="POST">
      @csrf
      <button type="submit" class="text-white bg-red-500 hover:text-white hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:text-white-500 dark:hover:text-white dark:text:white-400 dark:hover:text-gray dark:hover:bg-gray-700 w-36" href="{{ route('post.delete', ['post' => $post]) }}" onClick="return confirmDeletion()">投稿を削除</button>
    </form>
    </div>
    @endcan
  </div>
</div>
</div>
<script>
  function confirmDeletion() {
    return confirm('本当に削除しますか？');
  }
</script>
@endsection