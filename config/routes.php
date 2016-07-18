<?php
return array(
    'email' => 'information/email',
    // reklama
    'reklam/([0-9]+)' => 'post/goReklam/$1',
    //comments
    'comment/user=([0-9]+)/page=([0-9]+)' => 'post/commentByUser/$1/$2',
    'comment/user=([0-9]+)' => 'post/commentByUser/$1',
    'dislike/comment=([0-9]+)' => 'post/dislikeComment/$1',
    'like/comment=([0-9]+)' => 'post/likeComment/$1',
    //admin controller
    'admin/deleteReklam/id=([0-9]+)' => 'admin/deleteReklam/$1',
    'admin/reklam/add' => 'admin/addReklam',
    'admin/reklamList/page=([0-9]+)' => 'admin/reklamList/$1',
    'admin/reklamList' => 'admin/reklamList',

    'admin/region/add' => 'admin/addRegion',
    'admin/editRegion/region=([0-9]+)' => 'admin/editRegion/$1',
    'admin/deleteRegion/region=([0-9]+)' => 'admin/deleteRegion/$1',
    'admin/regionList/page=([0-9]+)' => 'admin/regionList/$1',
    'admin/regionList' => 'admin/regionList',

    'admin/editCategory/category=([0-9]+)' => 'admin/editCategory/$1',
    'admin/deleteCategory/category=([0-9]+)' => 'admin/deleteCategory/$1',
    'admin/category/add' => 'admin/addCategory',
    'admin/categoryList/page=([0-9]+)' => 'admin/categoryList/$1',
    'admin/categoryList' => 'admin/categoryList',

    'admin/deleteComment/comment=([0-9]+)' => 'admin/deleteComment/$1',
    'admin/showComment/comment=([0-9]+)' => 'admin/showComment/$1',
    'admin/commentList/page=([0-9]+)' => 'admin/commentList',
    'admin/commentList' => 'admin/commentList',

    'admin/takeAdmin/user=([0-9]+)' => 'admin/takeAdmin/$1',
    'admin/giveAdmin/user=([0-9]+)' => 'admin/giveAdmin/$1',
    'admin/deleteUser/user=([0-9]+)' => 'admin/deleteUser/$1',
    'admin/usersList/page=([0-9]+)' => 'admin/usersList/$1',
    'admin/usersList' => 'admin/usersList',

    'admin/editPost/post=([0-9]+)' => 'admin/editPost/$1',
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
    'category=([0-9]+)/page=([0-9]+)' => 'post/category/$1/$2',
    'category=([0-9]+)' => 'post/category/$1',

    'close/search' => 'post/closeSearch',
    'search/page=([0-9]+)' => 'post/search/$1',
    'search' => 'post/search',

    'region=([0-9]+)/page=([0-9]+)' => 'post/region/$1/$2',
    'region=([0-9]+)' => 'post/region/$1',

    'post/user=([0-9]+)/page=([0-9]+)' => 'post/userPost/$1/$2',
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