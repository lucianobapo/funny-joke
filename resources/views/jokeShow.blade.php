@extends('layouts.app')

@section('customHeadMetaTags')
    <meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}">
    <meta property="og:site_name" content="{{ app('mandante')->getSiteName() }}">
    <meta property="og:url" content="{{ url($_SERVER['REQUEST_URI']) }}">

    {{--<meta property="article:published_time" content="2016-07-03T08:02:13+00:00">--}}
    {{--<meta property="article:section" content="Desenhos">--}}
    {{--<meta property="article:tag" content="Teste qual super-herói você seria">--}}

    <meta property="og:type" content="article">
    <meta property="og:image" content="{{ url('') }}/file/{{ $joke->file }}">
    <meta property="og:title" content="{{ $joke->title }}">
    <meta property="og:description" content="{{ $joke->description }}">

    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $joke->title }}">
    <meta name="twitter:description" content="{{ $joke->description }}">
    <meta name="twitter:image" content="{{ url('') }}/file/{{ $joke->file }}">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>{{ $joke->title }}</h1></div>

                <div class="panel-body text-center">
                    <p><em>{{ $joke->description }}</em></p>
                    @if(isset($joke->file))
                        {{--{{ link_to_route('file.show', $joke->file, ['file'=>$joke->file]) }}--}}
                        <div>
                            <img src="/file/{{ $joke->file }}">
                        </div>
                    @else
                        <em>Sem Imagem</em>
                    @endif

                    <div class="fb-share-button"
                         data-href="{{ url($_SERVER['REQUEST_URI']) }}"
                         data-layout="button_count" data-size="large"
                         data-mobile-iframe="true">
                        <a class="fb-xfbml-parse-ignore" target="_blank"
                           href="https://www.facebook.com/sharer/sharer.php?u={{ url($_SERVER['REQUEST_URI']) }}&amp;src=sdkpreparse">
                            Compartilhar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customFooterScripts')
    <div id="fb-root"></div>
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.7&appId={{ config('services.facebook.client_id') }}}";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
@endsection
