<?php
    require_once 'app/models/User.php';

    class UserController{
        public static function index(){
            $users = User::getAllUsers();
            require 'app/views/users/index.php';
        }
    }
?>