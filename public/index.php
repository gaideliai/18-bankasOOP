<?php

use App\App;
use App\API;

require '..\vendor\autoload.php';

App::start();


_d(App::getUriParams());
_d($_SESSION);
_d($_POST);
_d(API::getRate());