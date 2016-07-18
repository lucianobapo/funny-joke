<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 21/06/16
 * Time: 22:24
 */

namespace App\Traits;

use Illuminate\Http\Response;
use Laravel\Socialite\Facades\Socialite;

trait TraitSocialite
{
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
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return $this->callSocialiteDriver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $user = $this->callSocialiteDriver($provider)->user();

        return $this->processSocialUser($provider, $user);

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
     * @return Response
     */
    abstract protected function processSocialUser($provider, $user);
}