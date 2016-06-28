<?php


class UserController
{
    public function actionRegister()
    {

        if (!empty($_POST)) {
            $errors = UserModel::checkedErrors();
            if (empty($errors)) {
                $uniqueLogin = UserModel::checkedLogin();
                if ($uniqueLogin != false) {
                    $errors[] = "Данный логин уже используется, выберите другой";
                }
            }

            if (empty($errors)) {
                $result = UserModel::registerUser();
            }
        }


        $title = "Регистрация пользователя";
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . "/views/register.phtml");
        require_once(ROOT . '/views/footer.phtml');
    }

    public function actionlogin()
    {

        if (!empty($_POST)) {
            $result = UserModel::getUser();
        }
        $title = "Авторизация ";
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . "/views/login.phtml");
        require_once(ROOT . '/views/footer.phtml');
    }

    public function actionLogout()
    {
        UserModel::userLogout();
        header('location: /');
    }

    public function actionProfile()
    {
        $title = "Профиль пользователя";
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . "/views/profile.phtml");
        require_once(ROOT . '/views/footer.phtml');
    }

    public function actionProfileEdit()
    {
        if (!empty($_POST)) {
            $errors = UserModel::checkedErrors();
            if (empty($errors)) {
                $uniqueLogin = UserModel::checkedLogin();
                if ($uniqueLogin != false) {
                    $errors[] = "Данный логин уже используется, выберите другой";
                }
            }
            if (empty($errors)) {
                $result = UserModel::updateUser();
            }

        }
        $title = "Профиль пользователя";
        require_once(ROOT . '/views/header.phtml');
        require_once(ROOT . "/views/profileedit.phtml");
        require_once(ROOT . '/views/footer.phtml');
       if(isset($result) and $result == true){
           UserModel::userLogout();
       }
    }

}