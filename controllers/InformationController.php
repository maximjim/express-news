<?php


class InformationController
{
    public function actionAbout(){
        $title = "О нас";
        require_once (ROOT . '/views/header.phtml');
        require_once(ROOT . "/views/about.phtml");
        require_once (ROOT . '/views/footer.phtml');
    }

    public function actionContact(){
        $title = "Контакты";
        require_once (ROOT . '/views/header.phtml');
        require_once(ROOT . "/views/contact.phtml");
        require_once (ROOT . '/views/footer.phtml');
    }

    public function actionEmail(){
        $title = "Обратная связь с администратором";
        if(!empty($_POST)){
            $errors = UserModel::checkedErrorsEmail();
            if(empty($errors)){
                $result = UserModel::sentEmail();
            }
        }

        require_once (ROOT . '/views/header.phtml');
        require_once(ROOT . "/views/email.phtml");
        require_once (ROOT . '/views/footer.phtml');
    }
}