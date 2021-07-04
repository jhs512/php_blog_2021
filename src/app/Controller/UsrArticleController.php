<?php

namespace App\Controller;

use App\Container\Container;
use App\Controller\Controller;

class UsrArticleController extends Controller
{
    use Container;

    public function actionShowWrite()
    {
        require_once $this->getViewPath("usr/article/write");
    }

    public function actionDoModify()
    {
        $id = getIntValueOr($_REQUEST['id'], 0);
        $title = getStrValueOr($_REQUEST['title'], "");
        $body = getStrValueOr($_REQUEST['body'], "");

        if (!$id) {
            jsHistoryBackExit("번호를 입력해주세요.");
        }

        if (!$title) {
            jsHistoryBackExit("제목을 입력해주세요.");
        }

        if (!$body) {
            jsHistoryBackExit("내용을 입력해주세요.");
        }

        $article = $this->articleService()->getForPrintArticleById($id);

        if ($article == null) {
            jsHistoryBackExit("${id}번 게시물은 존재하지 않습니다.");
        }

        $actorCanModifyRs = $this->articleService()->getActorCanModify($_REQUEST['App__loginedMember'], $article);

        if ($actorCanModifyRs->isFail()) {
            jsHistoryBackExit($actorCanModifyRs->getMsg());
        }

        $this->articleService()->modifyArticle($id, $title, $body);

        jsLocationReplaceExit("detail?id=${id}", "${id}번 게시물이 수정되었습니다.");
    }

    public function actionDoDelete()
    {
        $id = getIntValueOr($_REQUEST['id'], 0);

        if (!$id) {
            jsHistoryBackExit("번호를 입력해주세요.");
        }

        $article = $this->articleService()->getForPrintArticleById($id);

        if ($article == null) {
            jsHistoryBackExit("${id}번 게시물은 존재하지 않습니다.");
        }

        $actorCanDeleteRs = $this->articleService()->getActorCanDelete($_REQUEST['App__loginedMember'], $article);

        if ($actorCanDeleteRs->isFail()) {
            jsHistoryBackExit($actorCanDeleteRs->getMsg());
        }

        $this->articleService()->deleteArticle($id);

        jsLocationReplaceExit("list", "${id}번 게시물이 삭제되었습니다.");
    }

    public function actionDoWrite()
    {
        $title = getStrValueOr($_REQUEST['title'], "");
        $body = getStrValueOr($_REQUEST['body'], "");

        if (!$title) {
            jsHistoryBackExit("제목을 입력해주세요.");
        }

        if (!$body) {
            jsHistoryBackExit("내용을 입력해주세요.");
        }

        $id = $this->articleService()->writeArticle($_REQUEST['App__loginedMemberId'], $title, $body);

        jsLocationReplaceExit("detail?id=${id}", "${id}번 게시물이 생성되었습니다.");
    }

    public function actionShowList()
    {
        $articles = $this->articleService()->getForPrintArticles();
        $totalCount = $this->articleService()->getTotalArticlesCount();

        require_once $this->getViewPath("usr/article/list");
    }

    public function actionShowDetail()
    {
        $id = getIntValueOr($_REQUEST['id'], 0);

        if ($id == 0) {
            jsHistoryBackExit("번호를 입력해주세요.");
        }

        $article = $this->articleService()->getForPrintArticleById($id);

        if ($article == null) {
            jsHistoryBackExit("${id}번 게시물은 존재하지 않습니다.");
        }

        require_once $this->getViewPath("usr/article/detail");
    }

    public function actionShowModify()
    {
        $id = getIntValueOr($_REQUEST['id'], 0);

        if ($id == 0) {
            jsHistoryBackExit("번호를 입력해주세요.");
        }

        $article = $this->articleService()->getForPrintArticleById($id);

        if ($article == null) {
            jsHistoryBackExit("${id}번 게시물은 존재하지 않습니다.");
        }

        $actorCanModifyRs = $this->articleService()->getActorCanModify($_REQUEST['App__loginedMember'], $article);

        if ($actorCanModifyRs->isFail()) {
            jsHistoryBackExit($actorCanModifyRs->getMsg());
        }

        require_once $this->getViewPath("usr/article/modify");
    }
}