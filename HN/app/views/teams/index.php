<?php
    class Teams{
        public static function getAllTeams(){
            global $pdo;
            $sql = "SELECT * FROM teams";
            $stmt = $pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>