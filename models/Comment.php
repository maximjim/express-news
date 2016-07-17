<?php

class Comment
{
    public static function checkedErrors(){
        $errors = [];
        if(strlen($_POST['comment']) < 5){
            $errors[] = "Длинна комментария должна быть больше 5 символов";
        }
        return $errors;
    }

    public static function add($post){
        $data = [];
        if($post['category']['name'] == "Политика"){
            $data['isVisible'] = 0;
        }
        $time = date('Y-m-d H-i-s');
        $data['content'] = $_POST['comment'];
        $data['post'] = $_POST['idPost'];
        $data['time'] = $time;
        if( isset($_SESSION['user'])){
            $data['author'] = $_SESSION['user']['id'];
        } else {
            $data['author'] = 1;
        }
        $result = DataBase::insertToDB($data, 'comment');
         return $result;
    }

    public static function getCommentsInPost($id){

        $sql = "SELECT
                id, content, author, time, likes, disLikes
                FROM
                comment
                WHERE
                post = $id and isVisible = 1
                ORDER BY likes DESC";
        $comments = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
        return $comments;
    }

    public static function setCommentCountInPost(array $posts){

        foreach ($posts as &$post) {
            $idPost = $post['id'];
            $sql = "SELECT count(*) as cnt FROM comment WHERE post = $idPost";
            $count = DataBase::selectOfDB(DataBase::connectToDB(), $sql);
            $post['commentCnt'] = $count[0]['cnt'];
        }
        return $posts;
    }

    public static function likeComment($idComment){
        $sql = "UPDATE
                comment
                SET
                likes = likes + 1
                WHERE
                id = $idComment";

        DataBase::queryDB(DataBase::connectToDB(), $sql);
    }

    public static function dislikeComment($idComment){
        $sql = "UPDATE
                comment
                SET
                dislikes = dislikes - 1
                WHERE
                id = $idComment";

        DataBase::queryDB(DataBase::connectToDB(), $sql);
    }
}