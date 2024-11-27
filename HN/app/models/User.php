<?php

    class User{
        public static function getAllUsers(){
            global $pdo;
            $sql = "SELECT * FROM users";
            $stmt = $pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

?>