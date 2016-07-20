@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ app('trans',['Dashboard']) }}</div>

                <div class="panel-body">
                    You are logged in!

                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">{{ app('trans',['List', ['name' => app('mandante')->getJokeName()]]) }}</h1>
                        </div>

                        @forelse(isset($data)?$data:[] as $item)
                            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                                <p class="jokeTitle">{{ $item->title }}</p>
                                <p class="text-right"><em>{{ $item->description }}</em></p>

                                <a class="thumbnail" href="/joke/{{ $item[$item->getRouteKeyName()] }}">
                                    <img class="img-responsive" src="/fileFit/400x300/{{ $item->file }}"
                                         title="{{ $item->title }}"
                                         alt="{{ $item->title }}">
                                </a>
                            </div>
                        @empty
                            <div class="col-lg-12">
                                <div class="well"><em>Sem Registros</em></div>
                            </div>
                        @endforelse


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
