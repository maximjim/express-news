<?php

class UserModel
{
    public static function checkedErrors(){

        $errors = [];

        if (!isset($_POST['mail']) or empty($_POST['mail']) ){
            $errors[] = "Вы ввели неправильный email адресс, пожалуйста введите правильный адрес";
        }
        if (!isset($_POST['userName']) or empty($_POST['userName']) or strlen($_POST['userName'])< 4){
            $errors[] = "Вы не ввели имя пользователя, или имя пользователя слишком короткое, минимальная длинна 4 символа";
        }
        if (!isset($_POST['userSurname']) or empty($_POST['userSurname']) or strlen($_POST['userSurname'])< 5){
            $errors[] = "Вы не ввели фамилию пользователя, или фамилия пользователя слишком коротка, минимальная длинна 5 символов";
        }
        if (!isset($_POST['userLogin']) or empty($_POST['userLogin']) or strlen($_POST['userLogin'])< 5){
            $errors[] = "Вы не ввели логин(понадобится для авторизации) пользователя, или логин слишком краток, минимальная длинна 5 символов";
        }
        if (!isset($_POST['userPassword1']) or empty($_POST['userPassword1']) or strlen($_POST['userPassword1'])< 6){
            $errors[] = "Вы не ввели пароль(понадобится для авторизации) пользователя, или пароль слишком краток, минимальная длинна 6 символов";
        }
        if ($_POST['userPassword1'] != $_POST['userPassword1']){
            $errors[] = "Пароли не совпадают! Проверьте правильность введенных данных";
        }

        return $errors;
    }
    public static function checkedLogin(){
        $login = $_POST['userLogin'];
        $login = "'$login'";
        $sql = "SELECT
                *
                FROM
                user
                WHERE
                login = $login";

        $unique = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        return $unique;
    }

    public static function registerUser(){
        $data = [];
        $data['login'] = $_POST['userLogin'];
        $data['password'] = $_POST['userPassword1'];
        $data['name'] = $_POST['userName'];
        $data['surname'] = $_POST['userSurname'];
        $data['email'] = $_POST['mail'];

        $result = DataBase::insertToDB($data, 'user');

        if($result == true){
            $result = "Вы успешно зарегистрировались";
        } else {
            $result = "Регистрация не удалась. Что то пошло не так.";
        }
        return $result;
    }

    public static function getUser(){
        $login = $_POST['userLogin'];
        $login = "'$login'";
        $password = $_POST['userPassword'];
        $password = "'$password'";

        $sql = "SELECT
                *
                FROM
                user
                WHERE
                login = $login
                AND password = $password";

        $user = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        if($user == false){
            return "Такого пользователя не существует, возможно введена неверная комбинация логина или пароля!";
        }else {
           $result =  UserModel::userLogin($user);
            return $result;
        }
    }

    public static function userLogin(array $user){
        $_SESSION['user'] = $user[0];
        return "Вы успешно вошли на сайт.";
    }

    public static function userLogout(){
        unset($_SESSION['user']);
    }

    public static function updateUser(){
        $id = $_POST['id'];
        $login = $_POST['userLogin'];
        $password = $_POST['userPassword1'];
        $name = $_POST['userName'];
        $surname = $_POST['userSurname'];
        $email = $_POST['mail'];

        $login = "'$login'";
        $password = "'$password'";
        $name = "'$name'";
        $surname = "'$surname'";
        $email = "'$email'";

        $sql = "UPDATE
                user
                SET
                login = $login, password = $password, name = $name, surname = $surname, email = $email
                WHERE id = $id";

        $result = DataBase::queryDB(DataBase::connectToDB(), $sql);

        if($result == true){
            return "Профиль успешно обновлен!";
        } else {
            return "При выполнении запроса возникла ошибка! нам очень жаль.";
        }


    }
}