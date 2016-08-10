<div class="panel panel-default">
    <div class="panel-heading">
        <h1>{{ $joke->title }}</h1>
    </div>

    <div class="panel-body text-center">
        <p><em>{{ $joke->description }}</em></p>
        @if(isset($joke->file))
            <p>
                <img class="img-responsive" src="{{ $fileName }}">
            </p>
        @else
            <div class="well"><em>Sem Imagem</em></div>
        @endif

        <div class="well">
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
        </div>

        {{--Botão "Fazer Teste"--}}
        @if(!is_null($jokeMakeButton))
            <p><a href="{{ $jokeMakeButton }}" class="btn btn-primary">Fazer Teste</a></p>
        @endif

        {{--Botão "Refazer Teste"--}}
        @if(!is_null($jokeReMakeButton))
            <p>
                <a href="{{ $jokeReMakeButton }}" class="btn btn-primary">Tente novamente</a>
            </p>
        @endif

        {{--Botão "Login"--}}
        @if(!is_null($loginButton))
            <p>
                <a href="{{ $loginButton }}" class="btn btn-primary">
                    <i class="fa fa-facebook-official"></i> Conecte-se com Facebook
                </a>
            </p>
        @endif

        @if(config('app.env')=='local')
            @include('unversioned.home-dist')
        @else
            @include('unversioned.home')
        @endif

    </div>
</div>