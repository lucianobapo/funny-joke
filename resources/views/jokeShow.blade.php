@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>{{ $joke->title }}</h1></div>

                <div class="panel-body">
                    @if(isset($joke->file))
                        {{ link_to_route('file.show', $joke->file, ['file'=>$joke->file]) }}
                        <div>
                            <img src="/file/{{ $joke->file }}">
                        </div>
                    @else
                        <em>Sem Imagem</em>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
