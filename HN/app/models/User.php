<?php

class User {
    public static function getAllUsers() {
        global $pdo;
        $sql = "SELECT * FROM users";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getUserByEmail($email) {
        global $pdo;
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(":email" => $email));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function createUser($first_name, $last_name, $email, $password, $role_id) {
        global $pdo;
        $sql = "INSERT INTO users (first_name, last_name, email, password, role_id)
                VALUES (:first_name, :last_name, :email, :password, :role_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ":first_name" => $first_name,
            ":last_name" => $last_name,
            ":email" => $email,
            ":password" => $password,
            ":role_id" => $role_id
        ));
    }

    public static function deleteUser($user_id) {
        global $pdo;
        $sql = "DELETE FROM users WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(":user_id" => $user_id));
    }

    public static function updateRole($user_id, $role_id) {
        global $pdo;
        $sql = "UPDATE users SET role_id = :role_id WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ":role_id" => $role_id,
            ":user_id" => $user_id
        ));
    }

    public static function getUserById($user_id) {
        global $pdo;
        $sql = "SELECT * FROM users WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(":user_id" => $user_id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateUser($first_name, $last_name, $email, $role_id, $user_id) {
        global $pdo;
        $sql = "UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, role_id = :role_id WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ":first_name" => $first_name,
            ":last_name" => $last_name,
            ":email" => $email,
            ":role_id" => $role_id,
            ":user_id" => $user_id
        ));
    }
}

class UserRole {
    public static function getAllRoles() {
        global $pdo;
        $sql = "SELECT * FROM user_roles";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getRole($role_id) {
        global $pdo;
        $sql = "SELECT * FROM user_roles WHERE id = :role_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(":role_id" => $role_id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>
