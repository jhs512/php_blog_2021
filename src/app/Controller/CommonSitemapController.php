<?php

namespace App\Controller;

use App\Container\Container;
use App\Controller\Controller;

class CommonSitemapController extends Controller
{
    use Container;

    public function actionShowCurrent()
    {
        $prodSiteBaseUrl = $this->application()->getProdSiteBaseUrl();
        $articles = $this->articleService()->getForPrintArticles();
        $sitemapItems = [];

        foreach ( $articles as $article ) {
            $sitemapItems[] = [
                'url' => $prodSiteBaseUrl . '/usr/article/detail?id=' . $article['id'],
                'updateDate' => $article['updateDate']
            ];
        }

        $filePath = __DIR__ . '/../../../public/sitemap.xml';
        
        $cacheDuration = 60 * 60 * 24 * 3;
        makeSitemapXml($filePath, $cacheDuration, $sitemapItems);

        $renderFilePath = $filePath;

        require_once $this->getViewPath("common/renderFile");
    }
}