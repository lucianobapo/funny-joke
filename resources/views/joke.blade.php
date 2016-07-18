@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h1>Gerenciamento de Registros</h1></div>

                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {!! Form::model(isset($jokeModel)?$jokeModel:(new App\Joke), ['files' => true,'route' => isset($jokeModel)?['joke.update', $jokeModel->id]:['joke.store']]) !!}
                            <!-- Titulo Form Input -->
                            <div class="form-group">
                                {!! Form::label('title','Título:') !!}
                                {!! Form::text('title',null,['class'=>'form-control']) !!}
                            </div>

                            <!-- Imagem Form Input -->
                            <div class="form-group">
                                {!! Form::label('file','Imagem:') !!}
                                {!! Form::file('file',['class'=>'form-control']) !!}
                            </div>

                            <!-- Enviar Form Input -->
                            <div class="form-group">
                                {!! Form::submit('Enviar',['class'=>'btn btn-primary form-control']) !!}
                            </div>
                        {!! Form::close() !!}

                        <h2>Lista de Registros:</h2>
                        @forelse(isset($jokes)?$jokes:[] as $joke)
                        <ul>
                            <li>
                                {!! Form::open(['method' => 'DELETE', 'route' => ['joke.destroy', $joke->titleSlug] ]) !!}
                                    {{ link_to_route('joke.show', $joke->title, ['joke'=>$joke->titleSlug]) }}
                                    {!! Form::submit('Apagar',['class'=>'btn btn-primary']) !!}
                                {!! Form::close() !!}
{{--                                - {{ link_to_route('joke.destroy', 'Apagar', ['method'=>'DELETE', 'joke'=>$joke->titleSlug]) }}--}}
                            </li>
                        </ul>
                        @empty
                            <em>Sem registros</em>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection