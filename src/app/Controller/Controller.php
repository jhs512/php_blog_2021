<?php

namespace App\Controller;

abstract class Controller
{
    function getViewPath($viewName)
    {
        return __DIR__ . '/../../view/' . $viewName . '.php';
    }
}