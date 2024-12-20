<?php
require_once "app/models/User.php";

class AuthController {
    static function data_validation() {
        $errors = [];
        $len_name = strlen($_POST['last_name']);
        if (!isset($_POST['last_name']) || !preg_match('/^[a-zA-Z]{1,32}$/', $_POST['last_name'])) {
            $errors['last_name_error'] = 'Last name must contain only letters and be between 1 and 32 characters';
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email_error'] = 'Invalid email format';
        }
        if (isset($_POST['password'])) {
            $password = $_POST['password'];
            if (strlen($password) < 8) {
                $errors['password_error'] = 'Password must be at least 8 characters';
            } elseif (!preg_match('/[a-z]/', $password)) {
                $errors['password_error'] = 'Password must contain at least one lowercase letter, one uppercase letter, one digit and one special character';
            } elseif (!preg_match('/[A-Z]/', $password)) {
                $errors['password_error'] = 'Password must contain at least one lowercase letter, one uppercase letter, one digit and one special character';
            } elseif (!preg_match('/[0-9]/', $password)) {
                $errors['password_error'] = 'Password must contain at least one lowercase letter, one uppercase letter, one digit and one special character';
            } elseif (!preg_match('/[\W_]/', $password)) {
                $errors['password_error'] = 'Password must contain at least one lowercase letter, one uppercase letter, one digit and one special character';
            }
        }
        if (isset($_POST['role_id']) && !UserRole::getRole($_POST['role_id'])) {
            $errors['role_error'] = 'Invalid role';
        }

        return $errors;
    }

    public static function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verifică dacă token-ul CSRF este setat și valid
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                http_response_code(403); // Interzicere acces
                echo "Invalid CSRF token.";
                exit();
            }
        }

        if (isset($_POST["reg"])) {
            $_SESSION["register_user"]["user"] = $_POST;
            $existingUser = User::getUserByEmail($_POST["email"]);
            if ($existingUser) {
                $_SESSION["register_user"]["errors"] = ["email_error" => "Email already exists"];
                header("Location: register");
                return;
            }
            $errors = self::data_validation();
            if (count($errors)) {
                $_SESSION["register_user"]["errors"] = $errors;
                header("Location: register");
                return;
            }
            $role_id = 2;
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
            User::createUser(
                htmlentities($_POST["first_name"]),
                htmlentities($_POST["last_name"]),
                htmlentities($_POST["email"]),
                $password,
                htmlentities($role_id)
            );
            session_destroy();
            header("Location: login");
        }

        if (!isset($_SESSION["register_user"]["user"])) {
            $_SESSION["register_user"]["user"] = [
                "first_name" => "",
                "last_name" => "",
                "email" => "",
            ];
        }

        $roles = UserRole::getAllRoles();
        require_once "app/views/auth/register.php";
    }

    public static function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verifică dacă token-ul CSRF este setat și valid
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                http_response_code(403); // Interzicere acces
                echo "Invalid CSRF token.";
                exit();
            }
        }

        if (isset($_SESSION["request_user"])) {
            header("Location: /HN");
            return;
        }

        if (!isset($_POST["email"])) {
            require_once "app/views/auth/login.php";
            return;
        }

        // POST
        $email = htmlentities($_POST["email"]);
        $pass = $_POST["password"];
        $user = User::getUserByEmail($email);
        if (!$user || !password_verify($pass, $user["password"])) {
            $_SESSION["login_error"] = "Invalid email or password!";
            require_once "app/views/auth/login.php";
        } else {
            // login successful
            $_SESSION["request_user"] = $user;
            header("Location: /HN/index");
        }
    }

    public static function logout() {
        session_start();
        session_destroy();
        header("Location: /HN/login");
    }
}
?>