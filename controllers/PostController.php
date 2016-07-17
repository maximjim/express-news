<?php

class PostController
{
    public function actionIndex($page = 1)
    {
        $title = "Главная страница портала";
        $regions = Show::getRegions();
        $categories = Show::lastFivePostByCategory(Show::getCategories());
        $topCommentators = Show::topFiveCommentators();
        $ActivePosts = Show::ThreActivePost();
        $reklams = Show::getReklamPosts();



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
            $categories = Show::getCategories();
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
                if (empty($errors)) {
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
        $post = Show::getOnePost($id);
        $readNow = rand(0, 5);
        $title = $post['name'];
        Show::addReadNow($readNow, $id, $post['reading']);
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/oneNews.phtml');
        require_once(ROOT . '/views/footer.phtml');

    }

    public function actionRegion($idRegion, $page = 1)
    {
        $regions = Show::getRegions();
        $categories = Show::lastFivePostByCategory(Show::getCategories());
        $ActivePosts = Show::ThreActivePost();
        $topCommentators = Show::topFiveCommentators();
        $reklams = Show::getReklamPosts();
        $posts = Show::getPostByRegion($idRegion, $page);
        if (is_array($posts)) {
            $posts = Comment::setCommentCountInPost($posts);
        }
        $lastComment = Show::getLastComment();
        $title = "Записи в регионе: " . $posts[0]['region']['name'];

        $link = "/region=" . $idRegion . "/page=";
        $pages = Show::pagination($page, Show::countPageByRegion($idRegion));

        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . "/views/index.phtml");
        require_once(ROOT . '/views/footer.phtml');
    }

    public function actionCategory($idCategory, $page = 1)
    {
        $regions = Show::getRegions();
        $categories = Show::lastFivePostByCategory(Show::getCategories());
        $ActivePosts = Show::ThreActivePost();
        $topCommentators = Show::topFiveCommentators();
        $reklams = Show::getReklamPosts();
        $posts = Show::getPostByCategory($idCategory, $page);
        if (is_array($posts)) {
            $posts = Comment::setCommentCountInPost($posts);
        }
        $lastComment = Show::getLastComment();
        $title = "Записи в категории: " . $posts[0]['category']['name'];

        $link = "/category=" . $idCategory . "/page=";
        $pages = Show::pagination($page, Show::countPageByCategory($idCategory));

        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . "/views/index.phtml");
        require_once(ROOT . '/views/footer.phtml');
    }

    public function actionUserPost($idAuthor, $page = 1)
    {
        $regions = Show::getRegions();
        $categories = Show::lastFivePostByCategory(Show::getCategories());
        $ActivePosts = Show::ThreActivePost();
        $topCommentators = Show::topFiveCommentators();
        $reklams = Show::getReklamPosts();
        $posts = Show::getPostByUser($idAuthor, $page);
        if (is_array($posts)) {
            $posts = Comment::setCommentCountInPost($posts);
        }
        $lastComment = Show::getLastComment();
        $title = "Записи пользователя: " . $posts[0]['author']['login'];

        $link = "/post/user=" . $idAuthor . "/page=";
        $pages = Show::pagination($page, Show::countPageByUser($idAuthor));

        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . "/views/index.phtml");
        require_once(ROOT . '/views/footer.phtml');
    }

    public function actionAddComment($idPost)
    {
        $post = Show::getOnePost($idPost);
        if (isset($_POST['comment'])) {
            $errors = Comment::checkedErrors();
            if (empty($errors)) {
                $result = Comment::add($post);
            }
        }
        $post = Show::getOnePost($idPost);

        $title = $post['name'];
        $readNow = rand(0, 5);
        Show::addReadNow($readNow, $idPost, $post['reading']);
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/oneNews.phtml');
        require_once(ROOT . '/views/footer.phtml');

    }

    public function actionSearch($page = 1)
    {
        if (!empty($_POST)) {
            $_SESSION['search'] = $_POST;
        }


        $title = "Поиск по новостям";
        $regions = Show::getRegions();
        $categories = Show::lastFivePostByCategory(Show::getCategories());
        $ActivePosts = Show::ThreActivePost();
        $topCommentators = Show::topFiveCommentators();
        $reklams = Show::getReklamPosts();
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

    public function actionCloseSearch()
    {
        Show::closeSearch();
        $location = $_SERVER['HTTP_REFERER'];
        header("location: $location");
    }

    public function actionLikeComment($id)
    {
        Comment::likeComment($id);
        $location = $_SERVER['HTTP_REFERER'];
        header("location: $location");
    }

    public function actionDislikeComment($id)
    {
        Comment::dislikeComment($id);
        $location = $_SERVER['HTTP_REFERER'];
        header("location: $location");
    }

    public function actionCommentByUser($idUser, $page = 1){
        $user1[] = ['author' => $idUser];
        $user = Show::setAuthorInfo($user1);
        $user = $user[0]['author']['login'];
        $title = "Комментарии пользователя - $user";

        $comments = Show::getCommentByAuthor($idUser, $page);
        $countPage = Show::countPageCommentByUser($idUser);
        $pages = Show::pagination($page, $countPage);
        $link = "/comment/user=$idUser/page=";
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/commentUser.phtml');
        require_once(ROOT . '/views/footer.phtml');
    }

    public function actionGoReklam($id){
        $reklamPost = Show::getReklamPostById($id);
        $result = Show::addTransferToReklamPost($id);
        $link = $reklamPost['link'];
        header("Location: $link");
    }


}