    <style type="text/css">
        body{background: #E6EAEF;}
        .fb-share-button{ margin: 10px 0 10px 0;}
        .botao-fazer-teste a{ width: 98%; height: 40px; padding: 0 1% 0 1%; line-height: 40px; font-size: 16px; color: #fff; background: #5CB85C!important; margin: 0px 0 10px 0; border: 1px solid #3D8D3D!important; }
        .botao-fazer-teste a:hover{background: #449D44!important; color: #fff;}
        .botao-fazer-teste a:active{background: #449D44!important; color: #fff;}

        .botao-refazer-teste a{ width: 98%; height: 40px; padding: 0 1% 0 1%; line-height: 40px; font-size: 16px; color: #727272; background: #F5F5F5!important; margin: 10px 0 10px 0; border: 1px solid #DFDFDF!important; }
        .botao-refazer-teste a:hover{background: #EEEEEE!important; color: #727272;}
        .botao-refazer-teste a:active{background: #EEEEEE!important; color: #727272;}

        .botao-login a{ width: 98%; height: 40px; padding: 0 1% 0 1%; line-height: 40px; color: #ffffff; background: #4267B2!important; margin: 0px 0 10px 0; border: 1px solid #34518D!important; }
        .botao-login a:hover{background: #39599B!important; color: #ffffff;}
        .botao-login a:active{background: #39599B!important; color: #ffffff;}

        .titulo-post {font-size: 25px; color: #333; padding: 0px 0px 10px 0px;}
        .col-lg-4{ }
        .col-lg-8{ padding: 0px!important; margin-bottom: 20px; background: #fff;
            -webkit-border-bottom-right-radius: 10px;
            -webkit-border-bottom-left-radius: 10px;
            -moz-border-radius-bottomright: 10px;
            -moz-border-radius-bottomleft: 10px;
            border-bottom-right-radius: 10px;
            border-bottom-left-radius: 10px;
        }
        .descricao{text-align: center; font-size: 18px; padding: 10px 10px 10px 10px;}

        .banner-topo{ margin: auto; max-width: 998px; margin: 0 0 15px 0; padding: 0px!important;}
        .banner-conteudo{margin: auto; margin: 10px 0 20px 0; }
        .imagem-post{ margin-top: 0px;}

        .mais-posts{ margin: 0 0 50px 0;}

        .jokeTitle{ margin-top: 5px; text-align: center; font-size: 17px; line-height: 20px; padding: 0 10px 10px 10px; white-space: normal!important; font-weight: bolder;}
        .jokeTitle a{text-decoration: none; color: #2F4782; font-weight: bolder; }
        .jokeTitle a:hover{text-decoration: none; color: #4267B2;}
        .thumbnail {border:0; margin: 0px!important; padding: 10px!important 0px!important 0px!important 0px!important;}
        .thumbnail img{ width: 294px; height: 164px; -webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px; transition: all .2s ease-in-out; width: 295px!important; height: 180px!important;}
        .thumbnail img:hover { transform: scale(1.1); }
        .pai-posts{background: #fff; -webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px; min-height: 243px;}

        .titulo-mais-posts {font-size: 25px; color: #333; margin-bottom: -20px;}

        .titulo-aviso {font-size: 16px; color: #333; margin-bottom: 0px; margin-top: 50px; text-align: center; padding: 5px; border-radius: 3px; background: #fff; border-width: 1px;    border-style: dashed;    border-color: #2F4782;}
        .links-footer { text-align: center; margin-top: 20px;}
        .links-footer ul li{ display: inline; }
        .links-footer ul li a{ text-decoration: none; padding: 0 40px 0 0px; font-size:16px; color: #2F4782; font-weight: bolder;}
        .links-footer ul li a:hover{ color: #0F1628; font-weight: bolder; text-decoration: underline;}
        .copy-footer {font-size:16px; color: #333; text-align: center; margin: 0 0 30px 0;}

        .panel-body{ margin: auto; max-width: 998px; border:0; padding: 0px!important; }
        .fb-like{margin-bottom: 10px;}
    </style>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.7&appId=1584544561792934";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="panel-body" style="border:0; ">
    <div class="row">
        <div class="banner-topo">
            <img src="http://testesdivertidos.com/banner-topo.jpg">
        </div>

        <div class="col-lg-8">
            <div class="panel-body text-center">
                <div class="imagem-post">
                    {{--Mostra a imagem do teste se existir--}}
                    @if(isset($joke->file))
                        <p>
                            <a href="javascript: void(0);" data-layout="button_count" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}&amp;src=sdkpreparse','ventanacompartir', 'toolbar=0, status=0, width=570, height=450');"><img class="img-responsive" src="{{ $fileName }}"></a>
                        </p>
                    @else
                        <div class="well"><em>Sem Imagem</em></div>
                    @endif
                </div>

                {{--"Titulo do post"--}}
                @if(!is_null($loginButton))
                    <div class="titulo-post">
                        {{--Mostra o título do teste--}}
                        {{ $joke->title }} Teste e descubra
                     </div>
                @endif

                {{--"Titulo do Post"--}}
                @if(!is_null($jokeMakeButton))
                    <div class="titulo-post">
                        {{--Mostra o título do teste--}}
                        {{ $joke->title }}
                     </div>
                @endif

                {{--Espaço "Descrição"--}}
                @if(!is_null($jokeReMakeButton))
                    <div class="descricao">
                        <p>{{ $joke->description }}</p>
                    </div>

                    {{--Botao share facebook--}}

                    <div class="fb-like" data-href="https://facebook.com/testesdivertidos" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>

                    <a class="btn btn-primary2 btn-lg" style="float: left;width: 89%; margin-left: 1%; color:#fff; background: #4267B2; font-size: 12pt; height: 43px;"
                       href="javascript: void(0);" data-layout="button_count" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}&amp;src=sdkpreparse','ventanacompartir', 'toolbar=0, status=0, width=570, height=450');">
                        <i class="fa fa-facebook-official fa-2x" aria-hidden="true" style="float: left; padding-bottom: 30px!important;"></i>Compartilhe no Facebook
                    </a>

                    {{--Botao share twitter--}}
                    <a class="btn btn-primary3 btn-lg loginBtn"
                       style="float: right; width: 7%; margin-right: 1%; background: #57BBEF; color:#fff; font-size: 12pt;text-align:center;"
                       href="#" onclick="window.open('https://twitter.com/share?url={{ $shareUrl }}&amp;src=sdkpreparse','Faceb','width=660,height=400,resizable,scrollbars=yes,status=1'); return false">
                        <i class='fa fa-twitter'></i>&nbsp;
                    </a>
                @endif

                {{--Botão "Fazer Teste"--}}
                @if(!is_null($jokeMakeButton))

                    <div class="fb-like" data-href="https://facebook.com/testesdivertidos" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>

                    <div class="botao-fazer-teste">
                        {{ $jokeMakeButton }}
                    </div>
                @endif

                {{--Botão "Refazer Teste"--}}
                @if(!is_null($jokeReMakeButton))
                    <div class="botao-refazer-teste">
                        {{ $jokeReMakeButton }}
                    </div>
                @endif

                {{--Botão "Login"--}}
                @if(!is_null($loginButton))                
                    <div class="fb-like" data-href="https://facebook.com/testesdivertidos" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>

                    <div class="botao-login">
                        {{ $loginButton }}
                    </div>
                @endif

                <div class="banner-conteudo">
                    <img src="http://testesdivertidos.com/banner-conteudo.jpg">
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <img src="http://testesdivertidos.com/banner-sidebar.jpg">
        </div>
    </div>
</div>

    <hr style="background-color: #ffffff; width: 100%;  border:0;" />
    <div class="titulo-mais-posts">
        Mais Testes Divertidos pra você:
    </div>
    <hr style="background: #fff; width: 100%;" />

    <div class="mais-posts">

            {{--Lista de repetição, mostra todos os registros de teste--}}
            @forelse(isset($data)?$data:[] as $item)
                <div class="col-lg-4 col-md-3 col-xs-6 thumb" style="margin-bottom: 20px; min-height: 213px;">
                    <div class="pai-posts">
                        {{--Mostra a imagem do teste com um link para o teste--}}
                        <a class="thumbnail" href="{{ route('joke.show',[$item]) }}">
                            <img class="img-responsive" src="{{ route('file.fit',['294x164', $item->file]) }}"
                                 title="{{ $item->title }}"
                                 alt="{{ $item->title }}">
                        </a>

                        {{--Mostra o título do teste--}}
                        <div class="jokeTitle">
                            <a href="{{ route('joke.show',[$item]) }}">{{ $item->title }}</a>
                        </div>
                    </div>
                </div>
            @empty
                {{--Mostra caso nao tenha nenhum teste cadastrado--}}
                <div class="col-lg-12">
                    <div class="well"><em>Sem Registros</em></div>
                </div>
            @endforelse

    </div>

    <hr style="background-color: #ffffff; width: 100%;  border:0;" />
    <div class="titulo-aviso">
        {{ $joke->title }}. Todos os nossos testes são apenas para fins de entretenimento e diversão.
    </div>
    <div class="links-footer">
        <ul>
            <li><a href="#">Sobre</a></li>
            <li><a href="#">Contato</a></li>
            <li><a href="#">Política de Prividade</a></li>
            <li><a href="#">Termos de uso</a></li>
        </ul>
    </div>
    <div class="copy-footer">
        © 2016 - Testes Divertidos, Todos os direitos reservados.
    </div>