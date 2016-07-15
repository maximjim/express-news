<?php


class AdminController
{
    public function actionIndex()
    {
        $title = "Панель Администратора";
        if (isset($_SESSION['user']) and $_SESSION['user']['isAdmin'] == 1) {

            $functions = AdminModel::getFunctionsAdmin();
        } else {
            $accessDenied = "Вы не имеета прав доступа в данный раздел";
        }
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/admin/index.phtml');
        require_once(ROOT . '/views/footer.phtml');
    }

    public function actionPostInvizList($page = 1)
    {
        $title = "Панель Администратора - Редактирование Новостей Пользователей";
        if (isset($_SESSION['user']) and $_SESSION['user']['isAdmin'] == 1) {

            $posts = AdminModel::getPostsInviz($page);


            $link = "/admin/postInvizList/page=";
            $pages = Show::pagination($page, AdminModel::countAllPageInviz());
        } else {
            $accessDenied = "Вы не имеета прав доступа в данный раздел";
        }
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/admin/index.phtml');
        require_once(ROOT . '/views/footer.phtml');

    }

    public function actionIsVisiblePost($idPost)
    { $title = "Панель админитстратора - Добавить пост для просмотра пользователями";
        if (isset($_SESSION['user']) and $_SESSION['user']['isAdmin'] == 1) {
            AdminModel::isVisiblePost($idPost);
            header('location: /admin/postInvizList');
        } else {
            $accessDenied = "Вы не имеете прав доступа к этому разделу!";
        }
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/admin/index.phtml');
        require_once(ROOT . '/views/footer.phtml');
    }

    public function actionDeletePost($idPost)
    {   $title = "Панель админитстратора - Удалить новость";
        if (isset($_SESSION['user']) and $_SESSION['user']['isAdmin'] == 1) {
            AdminModel::DeletePost($idPost);
            $location = $_SERVER['HTTP_REFERER'];
            header("location: $location");
        } else {
            $accessDenied = "Вы не имеете прав доступа к этому разделу!";
        }
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/admin/index.phtml');
        require_once(ROOT . '/views/footer.phtml');
    }

    public function actionUsersList($page = 1)
    {
        $title = "Панель админитстратора - Управление пользователями";
        if (isset($_SESSION['user']) and $_SESSION['user']['isAdmin'] == 1) {
            $users = AdminModel::usersList($page);
            $countPage = AdminModel::countPageUsers();
            $link = "/admin/usersList/page=";
            $pages = Show::pagination($page, $countPage);
        } else {
            $accessDenied = "Вы не имеете прав доступа к этому разделу!";
        }
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/admin/users.phtml');
        require_once(ROOT . '/views/footer.phtml');
    }

    public function actionDeleteUser($id)
    {   $title = "Панель админитстратора - Удалить пользователя";
        if (isset($_SESSION['user']) and $_SESSION['user']['isAdmin'] == 1) {
            AdminModel::deleteUser($id);
            $location = $_SERVER['HTTP_REFERER'];
            header("location: $location");
        } else {
            $accessDenied = "Вы не имеете прав доступа к этому разделу!";
        }
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/admin/users.phtml');
        require_once(ROOT . '/views/footer.phtml');

    }

    public function actionGiveAdmin($id)
    {   $title = "Панель админитстратора - Дать Администратора";
        if (isset($_SESSION['user']) and $_SESSION['user']['isAdmin'] == 1) {
            AdminModel::giveAdmin($id);
            $location = $_SERVER['HTTP_REFERER'];
            header("location: $location");
        } else {
            $accessDenied = "Вы не имеете прав доступа к этому разделу!";
        }
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/admin/regions.phtml');
        require_once(ROOT . '/views/footer.phtml');
    }

    public function actionTakeAdmin($id)
    {   $title = "Панель админитстратора - Забрать администратора";
        if (isset($_SESSION['user']) and $_SESSION['user']['isAdmin'] == 1) {
            AdminModel::takeAdmin($id);
            $location = $_SERVER['HTTP_REFERER'];
            header("location: $location");
        } else {
            $accessDenied = "Вы не имеете прав доступа к этому разделу!";
        }
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/admin/users.phtml');
        require_once(ROOT . '/views/footer.phtml');
    }

    public function actionRegionList($page = 1)
    {
        $title = "Панель админитстратора - Управление регионами";
        if (isset($_SESSION['user']) and $_SESSION['user']['isAdmin'] == 1) {
            $regions = AdminModel::getRegionList($page);
            $countPage = AdminModel::countPageRegions();
            $link = "/admin/regionList/page=";
            $pages = Show::pagination($page, $countPage);
        } else {
            $accessDenied = "Вы не имеете прав доступа к этому разделу!";
        }

        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/admin/regions.phtml');
        require_once(ROOT . '/views/footer.phtml');
    }

    public function actionCategoryList($page = 1)
    {
        $title = "Панель админитстратора - Управление регионами";
        if (isset($_SESSION['user']) and $_SESSION['user']['isAdmin'] == 1) {
            $categories = AdminModel::getCategoryList($page);
            $countPage = AdminModel::countPageCategories();
            $link = "/admin/categoryList/page=";
            $pages = Show::pagination($page, $countPage);
        } else {
            $accessDenied = "Вы не имеете прав доступа к этому разделу!";
        }

        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/admin/categories.phtml');
        require_once(ROOT . '/views/footer.phtml');
    }


    public function actionCommentList($page = 1)
    {
        $title = "Панель админитстратора - Управление комментариями";
        if (isset($_SESSION['user']) and $_SESSION['user']['isAdmin'] == 1) {
            $comments = AdminModel::getCommentList($page);
            $countPage = AdminModel::countPageComments();
            $link = "/admin/commentList/page=";
            $pages = Show::pagination($page, $countPage);
        } else {
            $accessDenied = "Вы не имеете прав доступа к этому разделу!";
        }

        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/admin/comments.phtml');
        require_once(ROOT . '/views/footer.phtml');
    }

    public function actionDeleteComment($id)
    {   $title = "Панель админитстратора - Дать Администратора";
        if (isset($_SESSION['user']) and $_SESSION['user']['isAdmin'] == 1) {
            AdminModel::deleteComment($id);
            $location = $_SERVER['HTTP_REFERER'];
            header("location: $location");
        } else {
            $accessDenied = "Вы не имеете прав доступа к этому разделу!";
        }
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/admin/regions.phtml');
        require_once(ROOT . '/views/footer.phtml');
    }

    public function actionShowComment($id)
    {   $title = "Панель админитстратора - Дать Администратора";
        if (isset($_SESSION['user']) and $_SESSION['user']['isAdmin'] == 1) {
            AdminModel::showComment($id);
            $location = $_SERVER['HTTP_REFERER'];
            header("location: $location");
        } else {
            $accessDenied = "Вы не имеете прав доступа к этому разделу!";
        }
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/admin/regions.phtml');
        require_once(ROOT . '/views/footer.phtml');
    }

    public function actionDeleteRegion($id)
    {   $title = "Панель админитстратора - Удалить регион";
        if (isset($_SESSION['user']) and $_SESSION['user']['isAdmin'] == 1) {
            AdminModel::deleteRegion($id);
            $location = $_SERVER['HTTP_REFERER'];
            header("location: $location");
        } else {
            $accessDenied = "Вы не имеете прав доступа к этому разделу!";
        }
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/admin/regions.phtml');
        require_once(ROOT . '/views/footer.phtml');

    }

    public function actionAddRegion()
    {
        $title = "Панель администратора - Добавить регион";
        if (isset($_SESSION['user']) and $_SESSION['user']['isAdmin'] == 1) {
            if (isset($_POST['name'])) {
                $result = AdminModel::insertRegion();
            }

        } else {
            $accessDenied = "Вы не имеете прав доступа к этому разделу!";
        }
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/admin/addRegion.phtml');
        require_once(ROOT . '/views/footer.phtml');
    }

    public function actionEditRegion($id)
    {
        $title = "Панель админитстратора - редактирование региона";
        if (isset($_SESSION['user']) and $_SESSION['user']['isAdmin'] == 1) {
            $region = AdminModel::getRegionForEdit($id);

            if (isset($_POST['name'])) {
                $result = AdminModel::editRegion($id);
            }
        } else {
            $accessDenied = "Вы не имеете прав доступа к этому разделу!";
        }
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/admin/editRegion.phtml');
        require_once(ROOT . '/views/footer.phtml');
    }

    public function actionEditPost($id){
        $title = "Панель админитстратора - редактирование новости";
        if (isset($_SESSION['user']) and $_SESSION['user']['isAdmin'] == 1) {
            $post = Show::getOnePost($id);
            $regions = Show::getRegions();

            if (!empty($_POST)) {
                $errors = addNews::checkedErrors();
                if(empty($errors)){
                    $result = AdminModel::editPost($id);
                }
            }
        } else {
            $accessDenied = "Вы не имеете прав доступа к этому разделу!";
        }
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/admin/editPost.phtml');
        require_once(ROOT . '/views/footer.phtml');
    }

    public function actionAddCategory()
    {
        $title = "Панель администратора - Добавить категорию";
        if (isset($_SESSION['user']) and $_SESSION['user']['isAdmin'] == 1) {
            if (isset($_POST['name'])) {
                $result = AdminModel::insertCategory();
            }

        } else {
            $accessDenied = "Вы не имеете прав доступа к этому разделу!";
        }
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/admin/addCategory.phtml');
        require_once(ROOT . '/views/footer.phtml');
    }

    public function actionDeleteCategory($id)
    {   $title = "Панель админитстратора - Удалить категорию";
        if (isset($_SESSION['user']) and $_SESSION['user']['isAdmin'] == 1) {
            AdminModel::deleteCategory($id);
            $location = $_SERVER['HTTP_REFERER'];
            header("location: $location");
        } else {
            $accessDenied = "Вы не имеете прав доступа к этому разделу!";
        }
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/admin/regions.phtml');
        require_once(ROOT . '/views/footer.phtml');

    }

    public function actionEditCategory($id)
    {
        $title = "Панель админитстратора - редактирование категории";
        if (isset($_SESSION['user']) and $_SESSION['user']['isAdmin'] == 1) {
            $category = AdminModel::getCategoryForEdit($id);

            if (isset($_POST['name'])) {
                $result = AdminModel::editCategory($id);
            }
        } else {
            $accessDenied = "Вы не имеете прав доступа к этому разделу!";
        }
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . '/views/admin/editCategory.phtml');
        require_once(ROOT . '/views/footer.phtml');
    }



}