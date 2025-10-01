<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>@yield('title', 'Laravel Blog')</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('web/assets/favicon.ico') }}" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('web/css/styles.css') }}" rel="stylesheet" />
        <!-- GitHub Markdown CSS 5.8.1 -->
        <link href="{{ asset('web/css/github-markdown-light.css') }}" rel="stylesheet" />
    </head>
    <body>
        @include('web.layouts.navigation')

        @yield('content')

        @include('web.layouts.footer')
        <!-- Core theme JS-->
        <script src="{{ asset('web/js/scripts.js') }}"></script>
    </body>
</html>
