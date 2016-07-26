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

                            <h2>Lista de Registros:</h2>
                            @forelse(isset($data)?$data:[] as $item)
                                <div class="panel panel-default">
                                    <div class="panel-heading">{{ app('trans',['Code']) }}: {{ $item->id }}</div>
                                    <div class="panel-body">
                                        @if(!Auth::guest())
                                            <div class="pull-right">
                                                {{ link_to_route('joke.edit', 'Editar', ['#form','joke'=>$item[$item->getRouteKeyName()]], ['class'=>'btn btn-primary']) }}

                                                <a href="" class="btn btn-primary">Apagar</a>
                                            </div>
                                        @endif
                                        @foreach(isset($fields)?$fields:[] as $key => $field)
                                            @if(is_string($field) && !empty($item[$field]))
                                                <p>{{ ucfirst($field) }}: {{ $item[$field] }}</p>
                                            @elseif(is_array($field) && !empty($item[$field['name']]))
                                                @if(isset($field['component']) && $field['component']=='customFile')
                                                    <div style="display: inline-block">
                                                        <img class="img-responsive" src="/fileFit/200x100/{{ $item[$field['name']] }}"
                                                             title="{{ $item->title }}"
                                                             alt="{{ $item->title }}">
                                                    </div>
                                                @else
                                                    <p>
                                                        {{ isset($field['label'])?$field['label']:ucfirst($field['name']) }}:
                                                        {{ $item[$field['name']] }}
                                                    </p>
                                                @endif

                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                {{--<ul>--}}
                                    {{--<li>--}}
                                        {{--{!! Form::open(['method' => 'DELETE', 'route' => [$routePrefix.'.destroy', $item->titleSlug] ]) !!}--}}
                                            {{--{{ link_to_route($routePrefix.'.show', $item->nome, ['data'=>$item->id]) }} ---}}
                                            {{--<a href="{{ route($routePrefix.'.edit', ['data'=>$item->id]) }}" class="btn btn-primary">Editar</a> ---}}
                                            {{--{!! Form::submit('Apagar',['class'=>'btn btn-primary']) !!}--}}
                                        {{--{!! Form::close() !!}--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                            @empty
                                <div class="well">
                                    <em>Sem registros</em>
                                </div>

                            @endforelse

                            {!! get_class($data)==Illuminate\Pagination\LengthAwarePaginator::class?$data->render():'' !!}

                            @if(!Auth::guest())
                                <a name="form"></a><h2>Formulário de Registros:</h2>
                                {!! Form::model(isset($dataModel)?$dataModel:$dataModelInstance,
                                    isset($customFormAttr)?$customFormAttr:[]+[
                                        'route' => isset($dataModel)?[$routePrefix.'.update', $dataModel->id]:
                                            [$routePrefix.'.store']]) !!}

                                @foreach(isset($fields)?$fields:[] as $key => $field)
                                @if(is_string($field))
                                {{ Form::customText($field) }}
                                @elseif(is_array($field))
                                {{ forward_static_call(
                                    ['Form',$field['component']],
                                    $field['name'],
                                    isset($field['label'])?$field['label']:null,
                                    isset($field['value'])?$field['value']:null,
                                    isset($field['attributes'])?$field['attributes']:null
                                    ) }}
                                @endif
                                @endforeach

                                        <!-- Enviar Form Input -->
                                <div class="form-group">
                                    {!! Form::submit('Enviar',['class'=>'btn btn-primary form-control']) !!}
                                </div>
                                {!! Form::close() !!}
                            @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('customFooterScripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.8/angular.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-file-upload/2.3.4/angular-file-upload.min.js"></script>
@endsection