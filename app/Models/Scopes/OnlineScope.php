<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class OnlineScope implements Scope
{

    private $online;

    public function __construct($online = true)
    {
        $this->online = $online;
    }


    public function apply(Builder $builder, Model $model)
    {
        if($this->online) $builder->where('status', 'online');
    }
}
