<?php
    session_start();
    require './vendor/autoload.php';

    (new \Engine\Bootstrap)->appRun();
