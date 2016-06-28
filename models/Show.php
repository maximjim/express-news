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
            $author = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
            $post['region'] = $author[0];
        }

        return $posts;
    }

    public static function getPosts($page)
    {


        $countPostInPage = include(ROOT . '/config/showSettings.php');
        $offset = $page * $countPostInPage['CNT_POST_IN_PAGE'] - $countPostInPage['CNT_POST_IN_PAGE'];

        $sql = "SELECT
                 id, name, content, author, image, region, created
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
            return $posts;
        }
    }


    public static function getOnePost($id)
    {
        $sql = "SELECT
                 id, name, content, author, image, region, created
                 FROM
                 post
                 WHERE id = $id";

        $post = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        if (is_array($post)) {
            $post = Show::setAuthorInfo($post);
            $post = Show::setRegionInfo($post);
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
                 id, name, content, author, image, region, created
                 FROM
                 post
                 WHERE region = $idRegion and isVisible = 1
                 ORDER BY created DESC
                 LIMIT $offset, 5";

        $posts = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        if (is_array($posts)) {
            $posts = Show::setAuthorInfo($posts);
            $posts = Show::setRegionInfo($posts);
            return $posts;
        }
    }

    public static function getPostByUser($idAuthor, $page = 1)
    {

        $countPostInPage = include(ROOT . '/config/showSettings.php');
        $offset = $page * $countPostInPage['CNT_POST_IN_PAGE'] - $countPostInPage['CNT_POST_IN_PAGE'];

        $sql = "SELECT
                 id, name, content, author, image, region, created
                 FROM
                 post
                 WHERE author = $idAuthor and isVisible = 1
                 ORDER BY created DESC
                 LIMIT $offset, 5";

        $posts = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        if (is_array($posts)) {
            $posts = self::setAuthorInfo($posts);
            $posts = self::setRegionInfo($posts);
            return $posts;
        }
    }

    public static function getSearchPosts($page)
    {
        $countPostInPage = include(ROOT . '/config/showSettings.php');
        $offset = $page * $countPostInPage['CNT_POST_IN_PAGE'] - $countPostInPage['CNT_POST_IN_PAGE'];

        $whereLine = self::formSearchData();
        $sql = "SELECT
                 id, name, content, author, image, region, created
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
        if(is_array($lastComment)) {
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
        if (!empty($_POST['author'])) {
            $authorId = Show::getAuthorIdByName($_POST['author']);
            if (is_array($authorId)) {
                $authorId = $authorId['id'];
                $where['author'] = "and author = " . $authorId;
            }
        }

        if (!empty($_POST['timeStart'])) {
            $timeStart = $_POST['timeStart'] . ' 00:00:00';
            $timeStart = "'$timeStart'";
            $timeStart = " created >= " . $timeStart;
            $where['timeStart'] = $timeStart;
        }

        if (!empty($_POST['timeEnd'])) {
            $timeEnd = $_POST['timeEnd'] . ' 00:00:00';
            $timeEnd = "'$timeEnd'";
            $timeEnd = " created <= " . $timeEnd;
            $where['timeEnd'] = $timeEnd;
        }

        if (!empty($_POST['region'])) {
            $timeEnd = $_POST['timeEnd'] . ' 00:00:00';
            $where['region'] = "region = " . $_POST['region'];
        }

        if (is_array($where)) {
            $whereLine = implode(' and ', $where);

        } else {
            $whereLine = "";
        }


        return $whereLine;
    }
}