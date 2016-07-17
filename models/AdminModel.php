<?php


class AdminModel
{
    public static function getFunctionsAdmin()
    {
        $functions = [];
        $functions['/admin/postInvizList'] = "Проверить добавленные пользователями новости";
        $functions['/admin/usersList'] = "Управление пользователями";
        $functions['/admin/regionList'] = "Управление регионами";
        $functions['/admin/categoryList'] = "Управление категориями";
        $functions['/admin/reklamList'] = "Управление рекламой";
        $functions['/admin/commentList'] = "Управление комментариями в категории \"Политика\"";

        return $functions;
    }

    public static function checkErrorsReklam(){
        $errors = [];
        if (!isset($_POST['name']) or empty($_POST['name']) or strlen($_POST['name'])< 4){
            $errors[] = "Вы не заполнили поле имя новости или заголовок короче 3 символов, пожалуйста исправьте ошибки";
        }
        if (!isset($_POST['company']) or empty($_POST['company']) or strlen($_POST['company'])< 1){
            $errors[] = "Вы не заполнили имя компании или имя короче 1 символа, пожалуйста исправьте ошибки";
        }
        if (!isset($_POST['price']) or empty($_POST['price'])){
            $errors[] = "Вы не указали цену, пожалуйста укажите цену";
        }
        if (!isset($_POST['link']) or empty($_POST['link'])){
            $errors[] = "Вы не указали ссыдку для перехода, пожалуйста укажите ссылку";
        }
        return $errors;
    }

    public static function getPostsInviz($page)
    {

        $countPostInPage = include(ROOT . '/config/showSettings.php');
        $offset = $page * $countPostInPage['CNT_POST_IN_PAGE_ADMIN'] - $countPostInPage['CNT_POST_IN_PAGE_ADMIN'];

        $sql = "SELECT
                 id, name, content, author,  region, image, created, category
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
            $posts = Show::setCategoryInfo($posts);
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
        $countPostInPage = $countPostInPage['CNT_USER_IN_PAGE_ADMIN'];
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

    public static function getCommentList($page)
    {
        $countPostInPage = include(ROOT . '/config/showSettings.php');
        $countPostInPage = $countPostInPage['CNT_REGION_IN_PAGE_ADMIN'];
        $offset = $page * $countPostInPage - $countPostInPage;

        $sql = "SELECT
                *
                FROM
                comment
                WHERE
                isVisible = 0
                LIMIT $offset, $countPostInPage";
        $comments = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        return $comments;
    }

    public static function getReklamList($page)
    {
        $countPostInPage = include(ROOT . '/config/showSettings.php');
        $countPostInPage = $countPostInPage['CNT_REKLAM_IN_PAGE_ADMIN'];
        $offset = $page * $countPostInPage - $countPostInPage;

        $sql = "SELECT
                *
                FROM
                reklama
                LIMIT $offset, $countPostInPage";
        $reklams = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        return $reklams;
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

    public static function countPageComments()
    {
        $settings = include(ROOT . '/config/showSettings.php');
        $sql = "SELECT
                count(*) as cnt
                from
                comment
                WHERE
                isVisible = 0";
        $countPage = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        $allPost = $countPage['0']['cnt'];
        $countPage = ceil($allPost / $settings['CNT_REGION_IN_PAGE_ADMIN']);
        return $countPage;
    }

    public static function countPageReklams()
    {
        $settings = include(ROOT . '/config/showSettings.php');
        $sql = "SELECT
                count(*) as cnt
                from
                reklama
                ";
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

    public static function deleteComment($id)
    {
        $sql = "DELETE
                FROM
                comment
                WHERE
                id = $id";
        DataBase::queryDB(DataBase::connectToDB(), $sql);
    }

    public static function showComment($id)
    {
        $sql = "UPDATE
                comment
                SET
                isVisible = 1
                WHERE
                id = $id";
        DataBase::queryDB(DataBase::connectToDB(), $sql);
    }

    public static function getCategoryList($page)
    {
        $countPostInPage = include(ROOT . '/config/showSettings.php');
        $countPostInPage = $countPostInPage['CNT_REGION_IN_PAGE_ADMIN'];
        $offset = $page * $countPostInPage - $countPostInPage;

        $sql = "SELECT
                id, name
                FROM
                category
                LIMIT $offset, $countPostInPage";
        $categories = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        return $categories;
    }

    public static function countPageCategories()
    {
        $settings = include(ROOT . '/config/showSettings.php');
        $sql = "SELECT
                count(*) as cnt
                from
                category";
        $countPage = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        $allPost = $countPage['0']['cnt'];
        $countPage = ceil($allPost / $settings['CNT_REGION_IN_PAGE_ADMIN']);
        return $countPage;
    }

    public static function insertCategory()
    {
        $data['name'] = $_POST['name'];
        $result = DataBase::insertToDB($data, 'category');
        if ($result == true) {
            $result = "Категория успешно добавлена!";
        } else {
            $result = "Добавление не вышло, возникла ошибка!";
        }
        return $result;
    }

    public static function deleteCategory($id)
    {
        $sql = "DELETE
                FROM
                category
                WHERE
                id = $id";
        DataBase::queryDB(DataBase::connectToDB(), $sql);
    }

    public static function getCategoryForEdit($id){
        $sql = "SELECT
                id, name
                from
                category
                WHERE
                id = $id";
        $category = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        return $category[0];
    }

    public static function editCategory($id){
        $name = $_POST['name'];
        $name = "'$name'";
        $sql = "UPDATE
                category
                SET
                name = $name
                WHERE
                id = $id";
        $result = DataBase::queryDB(DataBase::connectToDB(), $sql);
        if ($result == true) {
            $result = "Категория успешно отредактирована!";
        } else {
            $result = "Редактирование не вышло, возникла ошибка!";
        }
        return $result;
    }

    public static function insertReklam()
    {   $data = [];
        $data['name'] = $_POST['name'];
        $data['company'] = $_POST['company'];
        $data['price'] = $_POST['price'];
        $data['link'] = $_POST['link'];
        $result = DataBase::insertToDB($data, 'reklama');
        if ($result == true) {
            $result = "Реклама успешно добавлена!";
        } else {
            $result = "Добавление не вышло, возникла ошибка!";
        }
        return $result;
    }

    public static function deleteReklam($id){
        $sql = "DELETE
                FROM
                reklama
                WHERE
                id = $id";
        DataBase::queryDB(DataBase::connectToDB(), $sql);
    }


}