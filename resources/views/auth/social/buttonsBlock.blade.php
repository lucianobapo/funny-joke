@foreach(config('ilhanet.socialLogin.availableProviders') as $provider)
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <button type="submit" name="provider" value="{{ $provider }}" class="btn btn-block btn-social btn-{{ $provider }}">
                <span class="fa fa-{{ $provider }}"></span>
                <i class="fa fa-btn {{ $type=='register'?'fa-user':'fa-sign-in' }}"></i>
                {{ ucfirst($type) }} with {{ ucfirst($provider) }}
            </button>
        </div>
    </div>
@endforeach
<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
        <p class="text-center">-- OR --</p>
    </div>
</div>
<div class="form-horizontal">

</div>

