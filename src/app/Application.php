<?php

namespace App;

use App\Interceptor\BeforeActionInterceptor;
use App\Interceptor\Interceptor;
use App\Interceptor\NeedLoginInterceptor;
use App\Interceptor\NeedLogoutInterceptor;

class Application
{
    function getTempSitemapFilePath(): string {
        $envCode = $this->getEnvCode();

        $dir = "";

        if ($envCode == 'dev') {
            $dir = "C:/temp";
        } else {
            $dir = "/tmp";
        }

        if ( !is_dir($dir) ) {
            mkdir($dir);
        }

        $filePath = $dir . "/{$this->getProdSiteDomain()}__sitemap.xml";

        return $filePath;
    }

    function getEnvCode(): string
    {
        if ($_SERVER['DOCUMENT_ROOT'] == '/web/2021_04_full/site00/public') {
            return 'prod';
        }

        return "dev";
    }

    function getProdSiteDomain(): string
    {
        return "bbb.oa.gg";
    }

    function getProdSiteProtocol(): string {
        return "https";
    }

    function getProdSiteBaseUrl() {
        return $this->getProdSiteProtocol() . "://" . $this->getProdSiteDomain();
    }

    public function getDbConnectionByEnv(): \mysqli
    {
        $envCode = $this->getEnvCode();

        if ($envCode == 'dev') {
            $dbHost = "127.0.0.1";
            $dbId = "sbsst";
            $dbPw = "sbs123414";
            $dbName = "php_blog_2021";
        } else {
            $dbHost = "127.0.0.1";
            $dbId = "st__2021_04_full__site00";
            $dbPw = "1234";
            $dbName = "st__2021_04_full__site00";
        }

        $dbConn = mysqli_connect($dbHost, $dbId, $dbPw, $dbName) or die("DB CONNECTION ERROR");

        return $dbConn;
    }

    public function runByRequestUri(string $requestUri)
    {
        if ($requestUri == '/') {
            location302("/usr/article/list");
        }

        list($action) = explode('?', $requestUri);
        $action = substr($action, 1);

        $this->run($action);
    }

    private function runAction(string $action)
    {
        list($controllerTypeCode, $controllerName, $actionFuncName) = explode('/', $action);

        $controllerClassName = "App\\Controller\\" . ucfirst($controllerTypeCode) . ucfirst($controllerName) . "Controller";
        $actionMethodName = "action";

        if (str_starts_with($actionFuncName, "do")) {
            $actionMethodName .= ucfirst($actionFuncName);
        } else {
            $actionMethodName .= "Show" . ucfirst($actionFuncName);
        }

        $usrArticleController = new $controllerClassName();
        $usrArticleController->$actionMethodName();
    }

    private function run(string $action)
    {
        $this->runInterceptors($action);
        $this->runAction($action);
    }

    private function runInterceptors(string $action)
    {
        $run = function (Interceptor...$interceptors) use ($action) {
            foreach ($interceptors as $interceptor) {
                $interceptor->run($action);
            }
        };

        $run(new BeforeActionInterceptor(), new NeedLoginInterceptor(), new NeedLogoutInterceptor());
    }
}
