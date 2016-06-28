<?php
return array(
    //admin controller
    'admin/region/add' => 'admin/addRegion',
    'admin/editRegion/region=([0-9]+)' => 'admin/editRegion/$1',
    'admin/deleteRegion/region=([0-9]+)' => 'admin/deleteRegion/$1',
    'admin/regionList/page=([0-9]+)' => 'admin/regionList/$1',
    'admin/regionList' => 'admin/regionList',
    'admin/takeAdmin/user=([0-9]+)' => 'admin/takeAdmin/$1',
    'admin/giveAdmin/user=([0-9]+)' => 'admin/giveAdmin/$1',
    'admin/deleteUser/user=([0-9]+)' => 'admin/deleteUser/$1',
    'admin/usersList/page=([0-9]+)' => 'admin/usersList/$1',
    'admin/usersList' => 'admin/usersList',
    'admin/deletePost/post=([0-9]+)' => 'admin/deletePost/$1',
    'admin/isVisible/post=([0-9]+)' => 'admin/isVisiblePost/$1',
    'admin/postInvizList/page=([0-9]+)' => 'admin/postInvizList/$1',
    'admin/postInvizList' => 'admin/postInvizList',
    'admin/index' => 'admin/index',
    'admin' => 'admin/index',
    // InformationController
    'about' => 'information/about',
    'contact' => 'information/contact',
    //reg log out in UserController
    'profile/edit' => 'user/profileEdit',
    'profile' => 'user/profile',
    'login' => 'user/login',
    'logout' => 'user/logout',
    'register' => 'user/register',
    //post navigation in PostController
    'search/page=([0-9]+)' => 'post/search/$1',
    'search' => 'post/search',
    'region=([0-9]+)&page=([0-9]+)' => 'post/region/$1/$2',
    'region=([0-9]+)' => 'post/region/$1',
    'post/user=([0-9]+)&page=([0-9]+)' => 'post/userPost/$1/$2',
    'post/user=([0-9]+)' => 'post/userPost/$1',
    'post/page=([0-9]+)' => 'post/index/$1',
    'post/([0-9]+)' => 'post/onePost/$1',
    //post add and index page PostController
    'post/addcomment/([0-9]+)' => 'post/addComment/$1',
    'post/add' => 'post/add',
    'post' => 'post/index',
    'index.php' => 'post/index',
    '/' => 'post/index',
    '' => 'post/index'
);