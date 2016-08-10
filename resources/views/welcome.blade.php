@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if(config('app.env')=='local')
                @include('unversioned.home-dist')
            @else
                @include('unversioned.home')
            @endif
        </div>
    </div>
</div>
@endsection
