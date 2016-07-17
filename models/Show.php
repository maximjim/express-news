<?php


class Show
{

    public static function getRegions()
    {
        $link = dataBase::connectToDB();
        $sql = "SELECT id, name FROM region";
        $regions = dataBase::selectOfDB($link, $sql);
        return $regions;
    }

    public static function getCategories()
    {
        $sql = "SELECT id, name FROM category";
        $categories = dataBase::selectOfDB(DataBase::connectToDB(), $sql);
        return $categories;
    }

    public static function lastFivePostByCategory($categories)
    {

        foreach ($categories as $key => $category) {
            $categ = $category['id'];
            $sql = "SELECT id, name FROM post WHERE category = $categ and isVisible = 1 ORDER BY created DESC LIMIT 5 ";
            $posts = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
            $categories[$key]['posts'] = $posts;
        }

        return $categories;

    }

    public static function setAuthorInfo(array $posts)
    {

        foreach ($posts as &$post) {
            $idAuthor = $post['author'];
            $sql = "SELECT id, login FROM user WHERE id = $idAuthor";
            $author = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
            $post['author'] = $author[0];
        }

        return $posts;
    }

    public static function setPostInfo(array $comments)
    {

        foreach ($comments as &$comment) {
            $idPost = $comment['post'];
            $sql = "SELECT id, name FROM post WHERE id = $idPost";
            $post = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
            $comment['post'] = $post[0];
        }
        return $comments;
    }

    public static function setRegionInfo(array $posts)
    {

        foreach ($posts as &$post) {
            $idRegion = $post['region'];
            $sql = "SELECT id, name FROM region WHERE id = $idRegion";
            $region = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
            $post['region'] = $region[0];
        }

        return $posts;
    }

    public static function setCategoryInfo(array $posts)
    {

        foreach ($posts as &$post) {
            $idCategory = $post['category'];
            $sql = "SELECT id, name FROM category WHERE id = $idCategory";
            $category = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
            $post['category'] = $category[0];
        }

        return $posts;
    }

    public static function getPosts($page)
    {


        $countPostInPage = include(ROOT . '/config/showSettings.php');
        $offset = $page * $countPostInPage['CNT_POST_IN_PAGE'] - $countPostInPage['CNT_POST_IN_PAGE'];

        $sql = "SELECT
                 id, name, content, author, image, region, created, category
                 FROM
                 post
                 WHERE
                 isVisible = true
                 ORDER BY created DESC
                 LIMIT $offset, 5";

        $posts = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        if (is_array($posts)) {
            $posts = Show::setAuthorInfo($posts);
            $posts = Show::setRegionInfo($posts);
            $posts = Show::setCategoryInfo($posts);
            return $posts;
        }
    }


    public static function getOnePost($id)
    {
        $sql = "SELECT
                 id, name, content, author, image, region, created, reading, category
                 FROM
                 post
                 WHERE id = $id and isVisible = 1";

        $post = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        if (is_array($post)) {
            $post = Show::setAuthorInfo($post);
            $post = Show::setRegionInfo($post);
            $post = Show::setCategoryInfo($post);
            $post[0]['comments'] = Comment::getCommentsInPost($id);
            if (is_array($post[0]['comments'])) {
                $post[0]['comments'] = Show::setAuthorInfo($post[0]['comments']);
            }

            return $post[0];
        }
    }

    public static function getPostByRegion($idRegion, $page = 1)
    {

        $countPostInPage = include(ROOT . '/config/showSettings.php');
        $offset = $page * $countPostInPage['CNT_POST_IN_PAGE'] - $countPostInPage['CNT_POST_IN_PAGE'];

        $sql = "SELECT
                 id, name, content, author, image, region, created, category
                 FROM
                 post
                 WHERE region = $idRegion and isVisible = 1
                 ORDER BY created DESC
                 LIMIT $offset, 5";

        $posts = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        if (is_array($posts)) {
            $posts = Show::setAuthorInfo($posts);
            $posts = Show::setRegionInfo($posts);
            $posts = Show::setCategoryInfo($posts);
            return $posts;
        }
    }

    public static function getPostByCategory($idCategory, $page = 1)
    {

        $countPostInPage = include(ROOT . '/config/showSettings.php');
        $offset = $page * $countPostInPage['CNT_POST_IN_PAGE'] - $countPostInPage['CNT_POST_IN_PAGE'];

        $sql = "SELECT
                 id, name, content, author, image, region, created, category
                 FROM
                 post
                 WHERE category = $idCategory and isVisible = 1
                 ORDER BY created DESC
                 LIMIT $offset, 5";

        $posts = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        if (is_array($posts)) {
            $posts = Show::setAuthorInfo($posts);
            $posts = Show::setRegionInfo($posts);
            $posts = Show::setCategoryInfo($posts);
            return $posts;
        }
    }

    public static function getPostByUser($idAuthor, $page = 1)
    {

        $countPostInPage = include(ROOT . '/config/showSettings.php');
        $offset = $page * $countPostInPage['CNT_POST_IN_PAGE'] - $countPostInPage['CNT_POST_IN_PAGE'];

        $sql = "SELECT
                 id, name, content, author, image, region, created, category
                 FROM
                 post
                 WHERE author = $idAuthor and isVisible = 1
                 ORDER BY created DESC
                 LIMIT $offset, 5";

        $posts = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        if (is_array($posts)) {
            $posts = self::setAuthorInfo($posts);
            $posts = self::setRegionInfo($posts);
            $posts = Show::setCategoryInfo($posts);
            return $posts;
        }
    }

    public static function getSearchPosts($page)
    {
        $countPostInPage = include(ROOT . '/config/showSettings.php');
        $offset = $page * $countPostInPage['CNT_POST_IN_PAGE'] - $countPostInPage['CNT_POST_IN_PAGE'];

        $whereLine = self::formSearchData();
        $sql = "SELECT
                 id, name, content, author, image, region, created, category
                 FROM
                 post
                 WHERE
                 isVisible = 1 $whereLine
                 ORDER BY created DESC
                 LIMIT $offset, 5";

        $posts = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        if (is_array($posts)) {
            $posts = self::setAuthorInfo($posts);
            $posts = self::setRegionInfo($posts);
            $posts = Show::setCategoryInfo($posts);
            return $posts;
        }
    }

    public static function getLastComment()
    {
        $sql = "SELECT
                content,
                post,
                time
                FROM
                comment
                ORDER BY time DESC
                LIMIT 5";
        $lastComment = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        if (is_array($lastComment)) {
            $lastComment = self::setPostInfo($lastComment);
            return $lastComment;
        }
    }


    public static function countAllPage()
    {
        $settings = include(ROOT . '/config/showSettings.php');
        $sql = "SELECT
                count(*) as cnt
                from
                post
                WHERE
                isVisible = 1";
        $countPage = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        $allPost = $countPage['0']['cnt'];
        $countPage = ceil($allPost / $settings['CNT_POST_IN_PAGE']);
        return $countPage;
    }

    public static function countPageByUser($userId)
    {
        $settings = include(ROOT . '/config/showSettings.php');
        $sql = "SELECT
                count(*) as cnt
                from
                post
                WHERE
                author = $userId and isVisible = 1";
        $countPage = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        $allPost = $countPage['0']['cnt'];
        $countPage = ceil($allPost / $settings['CNT_POST_IN_PAGE']);
        return $countPage;
    }

    public static function countPageByRegion($regionId)
    {
        $settings = include(ROOT . '/config/showSettings.php');
        $sql = "SELECT
                count(*) as cnt
                from
                post
                WHERE
                region = $regionId and isVisible = 1";
        $countPage = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        $allPost = $countPage['0']['cnt'];
        $countPage = ceil($allPost / $settings['CNT_POST_IN_PAGE']);
        return $countPage;
    }

    public static function countPageByCategory($idCategory)
    {
        $settings = include(ROOT . '/config/showSettings.php');
        $sql = "SELECT
                count(*) as cnt
                from
                post
                WHERE
                category = $idCategory and isVisible = 1";
        $countPage = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        $allPost = $countPage['0']['cnt'];
        $countPage = ceil($allPost / $settings['CNT_POST_IN_PAGE']);
        return $countPage;
    }

    public static function countAllPageBySearch()
    {
        $whereLine = self::formSearchData();

        $settings = include(ROOT . '/config/showSettings.php');
        $sql = "SELECT
                count(*) as cnt
                from
                post
                WHERE isVisible = 1 $whereLine";

        $countPage = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        $allPost = $countPage['0']['cnt'];
        $countPage = ceil($allPost / $settings['CNT_POST_IN_PAGE']);
        return $countPage;
    }

    public static function pagination($currentPage, $countPage)
    {
        $pages = [];
        if ($currentPage == 1 and $countPage >= 3) {
            $pages['first'] = null;
            $pages['pre'] = null;
            $pages['cur'] = $currentPage;
            $pages['next'] = $currentPage + 1;
            $pages['last'] = $countPage;
        } elseif ($currentPage == 1 and $countPage < 3 and $countPage >= 2) {
            $pages['first'] = null;
            $pages['pre'] = null;
            $pages['cur'] = $currentPage;
            $pages['next'] = $currentPage + 1;
            $pages['last'] = null;
        } elseif ($currentPage == 1 and $countPage == 1) {
            $pages['first'] = null;
            $pages['pre'] = null;
            $pages['cur'] = $currentPage;
            $pages['next'] = null;
            $pages['last'] = null;
        } elseif ($currentPage == 2 and $countPage == 3) {
            $pages['first'] = null;
            $pages['pre'] = $currentPage - 1;
            $pages['cur'] = $currentPage;
            $pages['next'] = $currentPage + 1;
            $pages['last'] = null;
        } elseif ($currentPage == $countPage and $countPage >= 3) {
            $pages['first'] = 1;
            $pages['pre'] = $currentPage - 1;
            $pages['cur'] = $currentPage;
            $pages['next'] = null;
            $pages['last'] = null;
        } elseif ($currentPage >= $countPage) {
            $pages['first'] = 1;
            $pages['pre'] = null;
            $pages['cur'] = null;
            $pages['next'] = null;
            $pages['last'] = null;
        } else {
            $pages['first'] = 1;
            $pages['pre'] = $currentPage - 1;
            $pages['cur'] = $currentPage;
            $pages['next'] = $currentPage + 1;
            $pages['last'] = $countPage;
        }

        return $pages;
    }

    public static function getAuthorIdByName($login)
    {
        $login = "'$login'";
        $sql = "SELECT
                id
                from
                user
                WHERE
                login = $login";
        $authorId = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        if (is_array($authorId)) {
            return $authorId[0];
        } else {
            return "Такого автора не существует";
        }
    }

    public static function formSearchData()
    {
        $where = null;
        if (!empty($_SESSION['search']['author'])) {
            $authorId = Show::getAuthorIdByName($_SESSION['search']['author']);
            if (is_array($authorId)) {
                $authorId = $authorId['id'];
                $where['author'] = " author = " . $authorId;
            }
        }

        if (!empty($_SESSION['search']['timeStart'])) {
            $timeStart = $_SESSION['search']['timeStart'] . ' 00:00:00';
            $timeStart = "'$timeStart'";
            $timeStart = " created >= " . $timeStart;
            $where['timeStart'] = $timeStart;
        }

        if (!empty($_SESSION['search']['timeEnd'])) {
            $timeEnd = $_SESSION['search']['timeEnd'] . ' 00:00:00';
            $timeEnd = "'$timeEnd'";
            $timeEnd = " created <= " . $timeEnd;
            $where['timeEnd'] = $timeEnd;
        }

        if (!empty($_SESSION['search']['region'])) {
            $where['region'] = " region = " . $_SESSION['search']['region'];
        }

        $whereLine = "";
        if (is_array($where)) {
            foreach ($where as $item) {
                $whereLine .= " and " . $item;
            }
        }
        return $whereLine;
    }

    public static function addReadNow($readNow, $idPost, $reading)
    {
        $allRead = $readNow + $reading;
        $sql = "UPDATE post SET reading = $allRead WHERE id = $idPost";
        DataBase::queryDB(DataBase::connectToDB(), $sql);
    }

    public static function closeSearch()
    {
        unset($_SESSION['search']);
    }

    public static function ThreActivePost()
    {
        $day = date('Y-m-d ');
        $hours = date('H-i-s');
        $time1 = explode('-', $day);
        $time1[2] = $time1[2] - 1;
        $day = implode('-', $time1);
        $date = $day . ' ' . $hours;

        $sql = "SELECT count(*) AS cnt, post
                FROM comment
                WHERE isVisible = 1
                AND time > '2016-07-14 05:00:16'
                GROUP BY post
                ORDER BY cnt DESC
                LIMIT 3";

        $activePostsID = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        //$activePosts = [];
        if (is_array($activePostsID)) {
            foreach ($activePostsID as $item) {
                $activePosts[] = Show::getOnePost($item['post']);
            }
            return $activePosts;
        }
    }

    public static function topFiveCommentators()
    {
        $sql = "SELECT
                count(*) as cnt, author
                FROM comment
                GROUP BY author
                ORDER BY cnt DESC
                LIMIT 5";
        $topCommentators = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        $topCommentators = Show::setAuthorInfo($topCommentators);
        return $topCommentators;
    }

    public static function getCommentByAuthor($id, $page)
    {
        $countPostInPage = include(ROOT . '/config/showSettings.php');
        $countPostInPage = $countPostInPage['CNT_COMMENT_IN_PAGE_ADMIN'];
        $offset = $page * $countPostInPage - $countPostInPage;

        $sql = "SELECT
                id, content, post, time, likes, disLikes, author
                FROM
                comment
                WHERE author = $id and isVisible = 1
                LIMIT $offset, $countPostInPage";
        $comments = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        $comments = Show::setAuthorInfo($comments);
        return $comments;

    }

    public static function countPageCommentByUser($id)
    {
        $settings = include(ROOT . '/config/showSettings.php');
        $sql = "SELECT
                count(*) as cnt
                from
                comment
                WHERE isVisible = 1 and author = $id";

        $countPage = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        $allPost = $countPage['0']['cnt'];
        $countPage = ceil($allPost / $settings['CNT_COMMENT_IN_PAGE_ADMIN']);
        return $countPage;
    }

    public static function getReklamPosts(){
        $sql = "SELECT
                *
                FROM
                reklama
                ORDER BY
                transfer
                DESC";
        $reklamPost = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        return $reklamPost;
    }

    public static function getReklamPostById($id){
        $sql = "SELECT
                *
                FROM
                reklama
                WHERE
                id = $id";
        $reklamPost = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        return $reklamPost[0];
    }

    public static function addTransferToReklamPost($id){
        $sql = "UPDATE
                REKLAMA
                SET
                transfer = transfer +1
                WHERE
                id = $id";
        $result = DataBase::queryDB(DataBase::connectToDB(), $sql);
        return $result;
    }


}