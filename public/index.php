<?php

namespace App;

require_once __DIR__ . "/../vendor/autoload.php";

// 어플리케이션
$application = Container\Container::application();

date_default_timezone_set('Asia/Seoul');
session_start();

// 현재 환경이 개발 혹은 운영인지에 따라
$dbConn = $application->getDbConnectionByEnv();

$application->runByRequestUri($_SERVER['REQUEST_URI']);
