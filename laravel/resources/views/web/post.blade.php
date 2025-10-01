@extends('web.layouts.app')

@section('title', $post->title . ' - Laravel Blog')

@section('content')
@include('web.components.page-header', [
    'background' => 'web/assets/img/post-bg.jpg',
    'title' => $post->title,
    'subtitle' => $post->subtitle,
    'type' => 'post',
    'post' => $post
])

<!-- Post Content-->
<article class="mb-4">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7 markdown-body">
                {!! $post->content_html !!}                
            </div>
        </div>
    </div>
</article>
@endsection