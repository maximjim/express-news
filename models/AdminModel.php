<?php


class AdminModel
{
    public static function getFunctionsAdmin()
    {
        $functions = [];
        $functions['/admin/postInvizList'] = "Проверить добавленные пользователями новости";
        $functions['/admin/usersList'] = "Управление пользователями";
        $functions['/admin/regionList'] = "Управление регионами";

        return $functions;
    }

    public static function getPostsInviz($page)
    {

        $countPostInPage = include(ROOT . '/config/showSettings.php');
        $offset = $page * $countPostInPage['CNT_POST_IN_PAGE_ADMIN'] - $countPostInPage['CNT_POST_IN_PAGE_ADMIN'];

        $sql = "SELECT
                 id, name, content, author,  region, image, created
                 FROM
                 post
                 WHERE
                 isVisible = 0
                 ORDER BY created DESC
                 LIMIT $offset, 5";

        $posts = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        if (is_array($posts)) {
            $posts = Show::setAuthorInfo($posts);
            $posts = Show::setRegionInfo($posts);
            return $posts;
        }
    }

    public static function countAllPageInviz()
    {
        $settings = include(ROOT . '/config/showSettings.php');
        $sql = "SELECT
                count(*) as cnt
                from
                post
                WHERE
                isVisible = 0";
        $countPage = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        $allPost = $countPage['0']['cnt'];
        $countPage = ceil($allPost / $settings['CNT_POST_IN_PAGE_ADMIN']);
        return $countPage;
    }

    public static function isVisiblePost($id)
    {
        $sql = "UPDATE
                post
                SET
                isVisible = 1
                WHERE
                id = $id";
        DataBase::queryDB(DataBase::connectToDB(), $sql);
    }

    public static function deletePost($id)
    {
        $sql = "DELETE
                FROM
                post
                WHERE
                id = $id";
        DataBase::queryDB(DataBase::connectToDB(), $sql);
    }

    public static function usersList($page)
    {
        $countPostInPage = include(ROOT . '/config/showSettings.php');
        $countPostInPage = $countPostInPage['CNT_POST_IN_PAGE_ADMIN'];
        $offset = $page * $countPostInPage - $countPostInPage;

        $sql = "SELECT
                id, name, surname, login, email, isAdmin
                FROM
                user
                LIMIT $offset, $countPostInPage";
        $users = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        return $users;
    }

    public static function deleteUser($id)
    {
        $sql = "DELETE
                FROM
                user
                WHERE
                id = $id";
        DataBase::queryDB(DataBase::connectToDB(), $sql);
    }

    public static function giveAdmin($id)
    {
        $sql = "UPDATE
                user
                SET
                isAdmin = 1
                WHERE
                id =$id";
        DataBase::queryDB(DataBase::connectToDB(), $sql);
    }

    public static function takeAdmin($id)
    {
        $sql = "UPDATE
                user
                SET
                isAdmin = 0
                WHERE
                id =$id";
        DataBase::queryDB(DataBase::connectToDB(), $sql);
    }

    public static function getRegionList($page)
    {
        $countPostInPage = include(ROOT . '/config/showSettings.php');
        $countPostInPage = $countPostInPage['CNT_REGION_IN_PAGE_ADMIN'];
        $offset = $page * $countPostInPage - $countPostInPage;

        $sql = "SELECT
                id, name
                FROM
                region
                LIMIT $offset, $countPostInPage";
        $regions = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        return $regions;
    }

    public static function deleteRegion($id)
    {
        $sql = "DELETE
                FROM
                region
                WHERE
                id = $id";
        DataBase::queryDB(DataBase::connectToDB(), $sql);
    }

    public static function insertRegion()
    {
        $data['name'] = $_POST['name'];
        $result = DataBase::insertToDB($data, 'region');
        if ($result == true) {
            $result = "Регион успешно добавлен!";
        } else {
            $result = "Добавление не вышло, возникла ошибка!";
        }
        return $result;
    }

    public static function getRegionForEdit($id){
        $sql = "SELECT
                id, name
                from
                region
                WHERE
                id = $id";
        $region = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        return $region[0];
    }

    public static function editRegion($id){
        $name = $_POST['name'];
        $name = "'$name'";
        $sql = "UPDATE
                region
                SET
                name = $name
                WHERE
                id = $id";
        $result = DataBase::queryDB(DataBase::connectToDB(), $sql);
        if ($result == true) {
            $result = "Регион успешно отредактирован!";
        } else {
            $result = "Редактирование не вышло, возникла ошибка!";
        }
        return $result;
    }

    public static function countPageUsers()
    {
        $settings = include(ROOT . '/config/showSettings.php');
        $sql = "SELECT
                count(*) as cnt
                from
                user";
        $countPage = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        $allPost = $countPage['0']['cnt'];
        $countPage = ceil($allPost / $settings['CNT_USER_IN_PAGE_ADMIN']);
        return $countPage;
    }

    public static function countPageRegions()
    {
        $settings = include(ROOT . '/config/showSettings.php');
        $sql = "SELECT
                count(*) as cnt
                from
                region";
        $countPage = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        $allPost = $countPage['0']['cnt'];
        $countPage = ceil($allPost / $settings['CNT_REGION_IN_PAGE_ADMIN']);
        return $countPage;
    }

    public static function editPost($id){
        $name = $_POST['newsName'];
        $name = "'$name'";
        $content = $_POST['content'];
        $content = "'$content'";
        $region = $_POST['region'];
        $sql = "UPDATE
                post
                SET
                name = $name,
                content = $content,
                region = $region
                WHERE
                id = $id";
        $result = DataBase::queryDB(DataBase::connectToDB(), $sql);
        if ($result == true) {
            $result = "Новость успешно отредактирована!";
        } else {
            $result = "Редактирование не вышло, возникла ошибка!";
        }
        return $result;
    }

}