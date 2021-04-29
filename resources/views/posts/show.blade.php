@extends('layouts.app')

@section('title', $post['title'])

@section('main')

@if($post['is_new'])
<div>A new blog post</div>
@else
<div>An old blog post</div>
@endif

@unless ($post['is_new'])
    <div>It is an old post... using unless </div>
@endunless

<h1>{{ $post['title'] }}</h1>
<p>{{  $post['content'] }}</p>

@isset($post['has_comments'])
    <div>The post has some comments... using isset</div>
@endisset

@endsection