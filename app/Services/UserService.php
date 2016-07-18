<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 23/06/16
 * Time: 02:17
 */

namespace App\Services;


use App\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    protected $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function findSocialUserOrCreate(array $attributesToFind = [], array $attributesToCreate = []){
        $found = $this->user->where($attributesToFind)->first();
        if(is_null($found)) return $this->create($attributesToCreate);
        else return $found;
    }

    public function create(array $attributes = [])
    {
        if(!isset($attributes['mandante']))
            $attributes['mandante'] = config('ilhanet.defaultMandante');
        return $this->user->create($attributes);
    }
    public function findFirst(array $attributes = [])
    {
        if(!isset($attributes['mandante']))
            if (Auth::guest())
                $attributes['mandante'] = config('ilhanet.defaultMandante');
            else
                $attributes['mandante'] = Auth::user()->mandante;

        return $this->user->where($attributes)->first();
    }
}