<?php

class DataBase{

    public static function connectToDB(){
        $path = ROOT . "/config/DBparams.php";
        $dbSet = include($path);
        $DB = mysqli_connect($dbSet['host'], $dbSet['user'], $dbSet['password'], $dbSet['dbName']);
        mysqli_set_charset($DB, 'utf8' );
        return $DB;
    }

    public static function insertToDB( array $data, $table){
        foreach ($data as $key => $value) {
            $values[] = "'$value'";
            $keys[] = $key;
        }
        $value = implode(", ", $values);
        $rows = implode (", ", $keys);
        $sql = "INSERT INTO $table ($rows) VALUES ($value)";
        $result =   mysqli_query(DataBase::connectToDB(), $sql);
         if ($result == false){
             return "Вставка не удалась, возникла ошибка";
         }else {
             return "Сообщение успешно добавлено";
         };
    }

    public static function selectOfDB($link, $sql){
        $select = mysqli_query($link, $sql);
        if (true === $select){
            $result = true;
            return $result;
        }
        if (false === $select) {
            $result = false;
            return $result;
        }
        $result = false;
        while ($line = mysqli_fetch_array($select, MYSQLI_ASSOC)){
            $result[] = $line;
        }
        mysqli_free_result($select);
        return $result;
    }

    public static function queryDB($link, $sql){
        $result = mysqli_query($link, $sql);
        return $result;
    }
}