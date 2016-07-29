<?php

namespace App\Http\Controllers\Auth;

use App\Services\UserService;
use App\Traits\TraitSocialite;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    use TraitSocialite;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected $userService;
    protected $socialProviders;

    /**
     * Create a new authentication controller instance.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->userService = $userService;
        $this->socialProviders = implode(',', config('ilhanet.socialLogin.availableProviders'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $providerRequired = empty($this->socialProviders)?'laravel':'laravel,'.$this->socialProviders;
        return Validator::make($data, [
            'provider_name' => 'in:'.$providerRequired,
            'name' => 'required_without:provider_name|max:255',
//            'email' => 'required_without:provider|email|max:255|unique:users',
            'email' => 'required_without:provider_name|email|max:255|unique:users,email,NULL,id,provider_name,NULL',
            'password' => 'required_without:provider_name|min:6|confirmed',
        ]);
    }

    /**
     * Get a validator for an incoming social user request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorSocialUser(array $data)
    {
        $providerRequired = empty($this->socialProviders)?'laravel':'laravel,'.$this->socialProviders;
        return Validator::make($data, [
            'provider_name' => 'required|in:'.$providerRequired,
            'provider_id' => 'required|numeric',
//            'name' => 'required_without:provider|max:255',
            'email' => 'required|email|max:255|unique:users,email,NULL,id,provider_id,'.$data['provider_id'],
//            'password' => 'required_without:provider|min:6|confirmed',
        ]);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
//        dd($request->all());
        $providerRequired = empty($this->socialProviders)?'laravel':'laravel,'.$this->socialProviders;
        $this->validate($request, [
            'provider_name' => 'in:'.$providerRequired,
            $this->loginUsername() => 'required_without:provider_name',
            'password' => 'required_without:provider_name',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $attributes = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ];
        return $this->userService->create($attributes);
    }

    /**
     * @param string $provider
     * @param $socialUser
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function processSocialUser($provider, $socialUser, $request)
    {
        $userFromDatabase = $this->userService->findFirst([
            'provider_name' => $provider,
            'provider_id' => $socialUser->getId(),
        ]);

        if (is_null($userFromDatabase)) {
            $validatorSocialUser = $this->validatorSocialUser([
                'provider_name' => $provider,
                'provider_id' => $socialUser->getId(),
                'email' => $socialUser->getEmail(),
            ]);

            if ($validatorSocialUser->fails()) {
                return redirect()->to('register')
                    ->withErrors($validatorSocialUser->getMessageBag()->get('email'));
            }

            $userFromDatabase = $this->userService->create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'password' => bcrypt(config('services.' . $provider . '.client_id')),
                'provider_name' => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
            ]);
        }

        Auth::guard($this->getGuard())->login($userFromDatabase);

        if ($request->session()->has('back'))
            return redirect($request->session()->get('back'));
        else
            return redirect($this->redirectPath());
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $data = $request->all();

        if (isset($data['provider_name']) && array_search($data['provider_name'],config('ilhanet.socialLogin.availableProviders'))!==false){
            return $this->redirectToProvider($data['provider_name']);
        }

        Auth::guard($this->getGuard())->login($this->create($data));

        return redirect($this->redirectPath());
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $data = $request->all();

        if (isset($data['provider_name']) && array_search($data['provider_name'],config('ilhanet.socialLogin.availableProviders'))!==false){
            return $this->redirectToProvider($data['provider_name']);
        }

        $credentials = $this->getCredentials($request);



        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }
        dd($credentials);
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles && ! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }
}
