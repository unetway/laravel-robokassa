<?php

namespace Unetway\LaravelRobokassa;

use Unetway\Robokassa\Robokassa as BaseRobokassa;

class Robokassa extends BaseRobokassa
{

    public function __construct()
    {
        $config = config('robokassa');

        parent::__construct($config);
    }

}