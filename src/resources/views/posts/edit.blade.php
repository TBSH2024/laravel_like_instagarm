@extends('layouts.app')

@section('title', '投稿編集')

@section('content')

<div class="p-8 lg:w-1/2 mx-auto">
   <div class="bg-white rounded-t-lg py-12 px-4 lg:px-24">
      <h1 class="text-center text-lg text-gray-500 font-light">投稿の編集</h1>
      <form  action="{{ route('post.update', ['post' => $post->id]) }}" method="POST" class="mt-6" enctype="multipart/form-data">
      @csrf
      @method('PATCH')
      <div class="relative">
         <label class="mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">画像のアップロード</label>
         <input class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="images" name="images[]" type="file" multiple>
         <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">PNG, JPG, JPEG, GIF.</p>
         @if ($post->postImages->count() > 0)
         @foreach ($post->postImages as $image)
            <img src="{{ asset($image->url) }}" alt="{{ $post->title }}" width="100">
         @endforeach
         @endif
      </div>
      <div class="relative mt-3">
         <label class="mb-2 text-sm font-medium text-gray-900 dark:text-white" for="title">タイトル</label>
         <input class="appearance-none bg-gray-50 border border-gray-300 shadow-sm focus:shadow-md focus:placeholder-gray-600 transition rounded-md w-full py-3 text-gray-600 leading-tight focus:outline-none focus:ring-gray-600 focus:shadow-outline" id="title" type="text" name="title" placeholder="タイトルを入力してください" value="{{ $post->title }}"/>
      </div>
      <div class="relative mt-3">
         <label class="mb-2 text-sm font-medium text-gray-900 dark:text-white" for="body">内容</label>
         <textarea class="appearance-none border border-gray-300 bg-gray-50 shadow-sm focus:shadow-md focus:placeholder-gray-600 transition rounded-md w-full py-3 text-gray-600 leading-tight focus:outline-none focus:ring-gray-600 focus:shadow-outline" id="body" type="text" name="body" rows="4" placeholder="説明を入力してください">{{ $post->body }}</textarea>
      </div>
      <div class="flex items-center justify-center mt-8">
         <button class="text-white py-2 px-4 uppercase rounded bg-indigo-500 hover:bg-indigo-600 shadow hover:shadow-lg font-medium transition transform hover:-translate-y-0.5" type="submit">更新</button>
      </div>
      <input type="hidden" name="id" value="{{ $post->id }}" />
      </form>
   </div>
</div>
@endsection