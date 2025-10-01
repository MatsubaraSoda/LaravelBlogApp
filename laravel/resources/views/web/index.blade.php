@extends('web.layouts.app')

@section('title', 'Laravel Blog')

@section('content')
@include('web.components.page-header', [
    'background' => 'web/assets/img/home-bg.jpg',
    'title' => 'Laravel Blog',
    'subtitle' => '博客搭建练习',
    'type' => 'site'
])

<!-- Main Content-->
<div class="container px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">
            @foreach($posts as $index => $post)
            <!-- Post preview-->
            <div class="post-preview">
                <a href="{{ route('web.post', $post->slug) }}">
                    <h2 class="post-title">{{ $post->title }}</h2>
                    @if($post->subtitle)
                    <h3 class="post-subtitle">{{ $post->subtitle }}</h3>
                    @endif
                </a>
                <p class="post-meta">
                    发布者
                    <a href="#!">{{ $post->user->name }}</a>
                    于 {{ $post->formatted_published_at }}
                </p>
            </div>
            @if($index < count($posts) - 1)
            <!-- Divider-->
            <hr class="my-4" />
            @endif
            @endforeach
            <!-- Pager-->
            <!-- <div class="d-flex justify-content-end mb-4"><a class="btn btn-primary text-uppercase" href="#!">更早的文章 →</a></div> -->
        </div>
    </div>
</div>
@endsection