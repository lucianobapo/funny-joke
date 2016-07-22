@extends('layouts.app')

@section('customHeadMetaTags')
    <meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}">
    <meta property="og:site_name" content="{{ app('mandante')->getSiteName() }}">
    <meta property="og:url" content="{{ url($_SERVER['REQUEST_URI']) }}">

    {{--<meta property="article:published_time" content="2016-07-03T08:02:13+00:00">--}}
    {{--<meta property="article:section" content="Desenhos">--}}
    {{--<meta property="article:tag" content="Teste qual super-herói você seria">--}}

    <meta property="og:type" content="article">
    <meta property="og:image" content="{{ url($fileName) }}">
    <meta property="og:image:width" content="800">
    <meta property="og:image:height" content="420">
    <meta property="og:title" content="{{ $joke->title }}">
    <meta property="og:description" content="{{ $joke->description }}">

    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $joke->title }}">
    <meta name="twitter:description" content="{{ $joke->description }}">
    <meta name="twitter:image" content="{{ url($fileName) }}">
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
                        <p>
                            <img class="img-responsive" src="{{ $fileName }}">
                        </p>
                    @else
                        <div class="well"><em>Sem Imagem</em></div>
                    @endif

                    <div class="fb-like"
                         data-href="{{ url($_SERVER['REQUEST_URI']) }}"
                         data-layout="button_count"
                         data-action="like"
                         data-size="large"
                         data-show-faces="false"
                         data-share="false">
                    </div>

                    <div class="fb-share-button"
                         data-href="{{ url($_SERVER['REQUEST_URI']) }}"
                         data-layout="button_count" data-size="large"
                         data-mobile-iframe="true">
                        <a class="fb-xfbml-parse-ignore" target="_blank"
                           href="https://www.facebook.com/sharer/sharer.php?u={{ url($_SERVER['REQUEST_URI']) }}&amp;src=sdkpreparse">
                            Compartilhar
                        </a>
                    </div>

                    {{ link_to_route('joke.jokeMake', 'Fazer Teste', [
                                'id'=>\Auth::user()->provider_id,
                                'joke'=>$joke[$joke->getRouteKeyName()],
                            ],
                        ['class'=>'btn btn-primary ']) }}
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
