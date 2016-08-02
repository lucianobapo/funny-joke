<style type="text/css">
    body{background: #E6EAEF;}
    .jokeTitle{ margin-top: 5px; text-align: center; font-size: 18px; line-height: 20px; padding: 0 10px 10px 10px; white-space: normal!important; font-weight: bolder;}
    .jokeTitle a{text-decoration: none; color: #2F4782; font-weight: bolder;}
    .jokeTitle a:hover{text-decoration: none; color: #4267B2;}
    .panel-body{ margin: auto; max-width: 998px; border:0; margin-top: -15px!important;}
    .banner-topo{ max-width: 998px; margin: 0 0 20px 0; padding: 0px!important;}
    .thumbnail {border:0; margin: 0px!important; padding: 10px!important 0px!important 0px!important 0px!important;}
    .thumbnail img{ width: 294px; height: 164px; -webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px; transition: all .2s ease-in-out; width: 295px!important; height: 180px!important;}
    .thumbnail img:hover { transform: scale(1.1); }
    .pai-posts{background: #fff; -webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px; min-height: 243px;}

    .titulo-aviso {font-size: 16px; color: #333; margin-bottom: 0px; margin-top: 50px; text-align: center; padding: 5px; border-radius: 3px; background: #fff; border-width: 1px;    border-style: dashed;    border-color: #2F4782;}
    .links-footer { text-align: center; margin-top: 20px;}
    .links-footer ul li{ display: inline; }
    .links-footer ul li a{ text-decoration: none; padding: 0 40px 0 0px; font-size:16px; color: #2F4782; font-weight: bolder;}
    .links-footer ul li a:hover{ color: #0F1628; font-weight: bolder; text-decoration: underline;}
    .copy-footer {font-size:16px; color: #333; text-align: center; margin: 0 0 30px 0;}
</style>

    <div class="panel-body">
        <div class="banner-topo text-center">
            <img src="http://testesdivertidos.com/banner-topo.jpg">
        </div>

        <div class="row">

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

        <div class="titulo-aviso">
            Todos os nossos testes são apenas para fins de entretenimento e diversão.
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

    </div>
