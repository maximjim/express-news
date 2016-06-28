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
}