<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 21/06/16
 * Time: 22:24
 */

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Cache\Repository as CacheRepository;

trait TraitSocialite
{
    /**
     *
     * @var CacheRepository
     */
    protected $cache;

    /**
     * @param $provider
     * @return \Laravel\Socialite\Two\AbstractProvider
     */
    protected function callSocialiteDriver($provider)
    {
        $driver = Socialite::driver($provider);
        if (method_exists($driver, 'fields') && is_callable([$driver, 'fields']))
            $driver->fields(config('ilhanet.socialLogin.'.$provider.'.fields'));

        if (method_exists($driver, 'scopes') && is_callable([$driver, 'scopes']))
            $driver->scopes(config('ilhanet.socialLogin.'.$provider.'.scopes'));

        return $driver;
    }

    /**
     * Redirect the user to the Provider authentication page.
     *
     * @param $provider
     * @param Request $request
     * @return Response
     */
    public function redirectToProvider($provider, Request $request)
    {
        $args = $request->all();

        if (isset($args['back']))
            $this->cache->put(md5($_SERVER['REMOTE_ADDR']), $args['back'], 5);
//            $request->cookie('back', $args['back']);

        return $this->callSocialiteDriver($provider)->redirect();
    }

    /**
     * Obtain the user information from Provider.
     *
     * @param $provider
     * @param Request $request
     * @return Response
     */
    public function handleProviderCallback($provider, Request $request)
    {
        if (array_search($provider,config('ilhanet.socialLogin.availableProviders'))===false)
            dd($provider);

        $state = $request->get('state');
        $request->session()->put('state',$state);

        if(\Auth::check()==false){
            session()->regenerate();
        }

        $abstractProvider = $this->callSocialiteDriver($provider);
//        dd($abstractProvider);
        $user = $abstractProvider->user();
//        dd($user);
        return $this->processSocialUser($provider, $user, $request);

        // OAuth Two Providers
//        $token = $user->token;
//        $refreshToken = $user->refreshToken; // not always provided
//        $expiresIn = $user->expiresIn;

        // OAuth One Providers
//        $token = $user->token;
//        $tokenSecret = $user->tokenSecret;

        // All Providers
//        $user->getId();
//        $user->getNickname();
//        $user->getName();
//        $user->getEmail();
//        $user->getAvatar();
    }

    /**
     * processSocialUser.
     *
     * @param $provider
     * @param $user
     * @param Request $request
     * @return Response
     */
    abstract protected function processSocialUser($provider, $user, Request $request);
}