<?php

use App\App;

require '..\vendor\autoload.php';

App::start();


_d(App::getUriParams());
_d($_SESSION);
if (!empty($_POST)) {
    _d($_POST['balance']);
}