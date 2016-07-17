<?php

class AddNews
{


    public static function checkedErrors(){
        $errors = [];
        if (!isset($_POST['newsName']) or empty($_POST['newsName']) or strlen($_POST['newsName'])< 20){
            $errors[] = "Вы не заполнили поле заголовок новости или заголовок короче 20 символов, пожалуйста исправьте ошибки";
        }
        if (!isset($_POST['content']) or empty($_POST['content']) or strlen($_POST['content'])< 150){
            $errors[] = "Вы не заполнили текст новости или текст короче 150 символов, пожалуйста исправьте ошибки";
        }
        if (!isset($_POST['region']) or empty($_POST['region'])){
            $errors[] = "Вы не выбрали регион, пожалуйста выберите регион";
        }
        if (!isset($_POST['category']) or empty($_POST['category'])){
            $errors[] = "Вы не выбрали регион, пожалуйста выберите регион";
        }
        return $errors;
    }

    public static function isImage()
    {
        if (!isset($_FILES['image']['tmp_name'])) {
            $result = "Вы не выбрали изображение";
            return $result;
        }else {
            $result = getimagesize($_FILES['image']['tmp_name']);
            return $result;
        }
    }

    public static function copyImage(){
            $link = DataBase::connectToDB();

            $sql = "SELECT MAX(id) FROM post";
            $size_DB = mysqli_query($link, $sql);
            $size = mysqli_fetch_array($size_DB, MYSQLI_ASSOC);
            @mkdir("upload", 0777);
            $image_name = $size['MAX(id)'] + 1;
            copy($_FILES['image']['tmp_name'], "images/" . basename($image_name . ".bmp"));
            $image = $image_name . ".bmp";

        return $image;
    }

    public static function insertNews(){
        $data = [];
        $time = date('Y-m-d H-i-s');
        $author = $_SESSION['user']['id'];
        $image = self::copyImage();
        $content = str_replace("'", '"', $_POST['content']);
        $name = str_replace("'", '"', $_POST['newsName']);

        $data['name'] = $name;
        $data['content'] = $content;
        $data['region'] = $_POST['region'];
        $data['category'] = $_POST['category'];
        $data['author'] = $author;
        $data['image'] = $image;
        $data['created'] = $time;
        $result = DataBase::insertToDB($data, 'post');
        return $result;
    }
}