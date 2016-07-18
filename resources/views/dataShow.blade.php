@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h1>{{ $data->nome }}</h1></div>

                    <div class="panel-body">
                        <p>{{ $data->descricao }}</p>
                        <p>{{ $data->cidade->estado->nome }}</p>
                        <p>{{ $data->cidade->nome }}</p>
                        <p>{{ $data->bairro }}</p>
                        <p>{{ $data->endereco }}</p>
                        <p>{{ $data->complemento }}</p>
                        <p>{{ $data->cep }}</p>
                        <p>{{ $data->telefone }}</p>
                        <p>{{ $data->email }}</p>
                        <p>{{ $data->site }}</p>
                        <p>{{ $data->fabricantes }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection