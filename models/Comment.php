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

    public static function add(){
        $data = [];
        $time = date('Y-m-d H-i-s');
        $data['content'] = $_POST['comment'];
        $data['post'] = $_POST['idPost'];
        $data['time'] = $time;
        $result = DataBase::insertToDB($data, 'comment');
         return $result;
    }

    public static function getCommentsInPost($id){

        $sql = "SELECT
                content, author, time
                FROM
                comment
                WHERE
                post = $id";
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
}