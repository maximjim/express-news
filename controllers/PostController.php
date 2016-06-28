<?php

class PostController
{
    public function actionIndex($page = 1)
    {
        $title = "Главная страница портала";
        $regions = Show::getRegions();
        $posts = Show::getPosts($page);
        if (is_array($posts)) {
            $posts = Comment::setCommentCountInPost($posts);
            $lastComment = Show::getLastComment();
        }

        $link = "/post/page=";
        $pages = Show::pagination($page, Show::countAllPage());
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . "/views/index.phtml");
        require_once(ROOT . '/views/footer.phtml');

    }

    public function actionAdd()
    {
        if (isset($_SESSION['user'])) {
            $regions = Show::getRegions();
            $title = "Добавить новость";
            if (!empty($_POST)) {
                $errors = addNews::checkedErrors();
               $isImage = AddNews::isImage();
                if ($isImage == false) {
                    $errors[] = "Вы выбрали не изображение! Вы можете добавлять только изображения!";
                    require_once(ROOT . '/views/header.phtml');
                    require_once(ROOT . '/views/addNews.phtml');
                    require_once(ROOT . '/views/footer.phtml');
                    die();
                }
                if(empty($errors)) {
                    $result = AddNews::insertNews();
                }
            }

            require_once(ROOT . '/views/header.phtml');
            require_once(ROOT . '/views/addNews.phtml');
            require_once(ROOT . '/views/footer.phtml');
        } else {
            $title = "Ошибка доступа, вы не авторизованы";
            $accessDenied = "Ошибка доступа. Вы не авторизованы, авторизуйтесь для начала!";
            require_once(ROOT . '/views/header.phtml');
            require_once(ROOT . '/views/addNews.phtml');
            require_once(ROOT . '/views/footer.phtml');
        }
    }


    public function actionOnePost($id)
    {
        $post = show::getOnePost($id);
        $title = $post['name'];


        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/oneNews.phtml');
        require_once(ROOT . '/views/footer.phtml');

    }

    public function actionRegion($idRegion, $page = 1)
    {
        $regions = Show::getRegions();
        $posts = Show::getPostByRegion($idRegion, $page);
        if (is_array($posts)) {
            $posts = Comment::setCommentCountInPost($posts);
        }
        $lastComment = Show::getLastComment();
        $title = "Записи в регионе: " . $posts[0]['region']['name'];

        $link = "/region=" . $idRegion . "&page=";
        $pages = Show::pagination($page, Show::countPageByRegion($idRegion));

        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . "/views/index.phtml");
        require_once(ROOT . '/views/footer.phtml');
    }

    public function actionUserPost($idAuthor, $page = 1)
    {
        $regions = Show::getRegions();
        $posts = Show::getPostByUser($idAuthor, $page);
        if (is_array($posts)) {
            $posts = Comment::setCommentCountInPost($posts);
        }
        $lastComment = Show::getLastComment();
        $title = "Записи пользователя: " . $posts[0]['author']['login'];

        $link = "/post/user=" . $idAuthor . "&page=";
        $pages = Show::pagination($page, Show::countPageByUser($idAuthor));

        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . "/views/index.phtml");
        require_once(ROOT . '/views/footer.phtml');
    }

    public function actionAddComment($idPost)
    {
        $post = show::getOnePost($idPost);
        $title = $post['name'];
        if (isset($_POST['comment'])) {
            $errors = Comment::checkedErrors();
            if (empty($errors)) {
                $result = Comment::add();
            }
        }
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/oneNews.phtml');
        require_once(ROOT . '/views/footer.phtml');

    }

    public function actionSearch($page = 1)
    {
        $title = "Поиск по новостям";
        $regions = Show::getRegions();
        $posts = Show::getSearchPosts($page);
        if (is_array($posts)) {
            $posts = Comment::setCommentCountInPost($posts);
        }
        $link = "/search/page=";
        $pages = Show::pagination($page, Show::countAllPageBySearch());
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/search.phtml');
        require_once(ROOT . '/views/footer.phtml');
    }

}