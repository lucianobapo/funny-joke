<?php

return [
    'defaultMandante' => env('DEFAULT_MANDANTE', 'ilhanet'),
    'defaultSiteName' => env('DEFAULT_SITE_NAME', 'Funny Joke'),
    'defaultJokeName' => env('DEFAULT_JOKE_NAME', 'Joke'),

    //socialLogin configs
    'socialLogin' => [
        'availableProviders' => ['facebook','google'],

        'google' => [
            'scopes' => [
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/plus.me',
                'https://www.googleapis.com/auth/userinfo.profile',
            ],
            'fields' => [],
        ],
        'facebook' => [
            'scopes' => ['email','user_birthday','user_friends'],
            'fields' => [
                //public_profile
                'id',
                'name',
                'first_name',
                'last_name',
                'age_range',
                'link',
                'gender',
                'locale',
                'picture',
                'timezone',
                'updated_time',
                'verified',
                //email
                'email',
                'birthday',
                'friends',
            ],
        ],
    ],


];