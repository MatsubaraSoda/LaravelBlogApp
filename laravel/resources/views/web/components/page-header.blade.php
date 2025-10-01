@props([
    'background' => 'web/assets/img/home-bg.jpg',
    'title' => '',
    'subtitle' => '',
    'type' => 'site',  // site, page, post
    'post' => null
])

<header class="masthead" style="background-image: url('{{ asset($background) }}')">
    <div class="container position-relative px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                @if($type === 'site')
                    <div class="site-heading">
                        <h1>{{ $title }}</h1>
                        @if($subtitle)
                            <span class="subheading">{{ $subtitle }}</span>
                        @endif
                    </div>
                @elseif($type === 'page')
                    <div class="page-heading">
                        <h1>{{ $title }}</h1>
                    </div>
                @elseif($type === 'post')
                    <div class="post-heading">
                        <h1>{{ $title }}</h1>
                        @if($subtitle)
                            <h2 class="subheading">{{ $subtitle }}</h2>
                        @endif
                        <span class="meta">
                            发布者
                            <a href="#!">{{ $post->user->name }}</a>
                            于 {{ $post->formatted_published_at }}
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</header>
