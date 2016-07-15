<?php

class AddController
{
    public function actionAdd()
    {
        $content = "`Lorem Ipsum - це текст-\"риба\", що використовується в друкарстві та дизайні. Lorem Ipsum є, фактично,
             стандартною \"рибою\" аж з XVI сторіччя, коли невідомий друкар взяв шрифтову гранку та склав на ній підбірку
             зразків шрифтів. \"Риба\" не тільки успішно пережила п'ять століть, але й прижилася в електронному верстуванні,
             залишаючись по суті незмінною. Вона популяризувалась в 60-их роках минулого сторіччя завдяки виданню зразків
             шрифтів Letraset, які містили уривки з Lorem Ipsum, і вдруге - нещодавно завдяки програмам комп'ютерного
             верстування на кшталт Aldus Pagemaker, які використовували різні версії Lorem Ipsum.`";


        for ($i = 0; $i <= 100; $i++) {
            $random = rand(1000, 10000);
            $name = "Lorem Ipsum -  POST № $random";

            $user = [1, 6, 7, 8, 9];

            $time = date('Y-m-d H-i-s');
            $author = array_rand($user);
            $author = $user[$author];
            $image = "no-image.bmp";
            $content = str_replace("'", '"', $content);
            $name = str_replace("'", '"', $name);


            $data['name'] = $name;
            $data['content'] = $content;
            $data['region'] = rand(18, 41);
            $data['author'] = $author;
            $data['image'] = $image;
            $data['created'] = $time;
            $data['isVisible'] = 1;
            $data['reading'] = rand(10, 100);
            $data['category'] = rand(1, 5);

            $result = DataBase::insertToDB($data, 'post');
        }

    }
}


