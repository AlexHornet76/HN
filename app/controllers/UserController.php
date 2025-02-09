<?php
require_once 'app/models/User.php';

class UserController {
    static function token_validation() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verifică dacă token-ul CSRF este setat și valid
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                http_response_code(403); // Interzicere acces
                echo "Invalid CSRF token.";
                exit();
            }
        }
    }

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

    public static function index() {
        if (!isset($_SESSION["request_user"])) {
            require_once 'app/views/404.php';
            return;
        }
        self::token_validation();
        $users = User::getAllUsers();
        require_once 'app/views/users/index.php';
    }

    public static function profile() {
        self::token_validation();
        if (isset($_POST["profile"])) {
            $_SESSION["profile"]["user"] = $_POST;
            $errors = self::data_validation();
            if (count($errors)) {
                $_SESSION["profile"]["errors"] = $errors;
                header("Location: profile");
                return;
            }
            $existingUser = User::getUserByEmail($_POST["email"]);
            if ($existingUser && $existingUser["id"] != $_POST["id"]) {
                $_SESSION["profile"]["errors"] = ["email_error" => "Email already exists"];
                header("Location: profile");
                return;
            }
            User::updateUser(
                htmlentities($_POST["first_name"]),
                htmlentities($_POST["last_name"]),
                htmlentities($_POST["email"]),
                htmlentities($_SESSION["request_user"]["role_id"]),
                $_POST["id"]
            );
            $_SESSION["request_user"] = [
                "first_name" => $_POST["first_name"],
                "last_name" => $_POST["last_name"],
                "email" => $_POST["email"],
                "id" => $_POST["id"],
                "role_id" => $_SESSION["request_user"]["role_id"]
            ];
            header("Location: profile");
            return;
        }
        if (!isset($_SESSION["profile"]["user"])) {
            $user = User::getUserById($_SESSION["request_user"]["id"]);
            $_SESSION["profile"]["user"] = [
                "first_name" => $user["first_name"],
                "last_name" => $user["last_name"],
                "email" => $user["email"],
                "id" => $user["id"],
                "role_id" => $user["role_id"]
            ];
        }
        require_once 'app/views/users/profile.php';
    }

    public static function delete() {
        User::deleteUser($_POST["id"]);
        header("Location: users");
    }

    public static function create() {
        self::token_validation();
        if (isset($_POST["is_post"])) {
            // POST => create user
            $_SESSION["create_user"]["user"] = $_POST;
            $existingUser = User::getUserByEmail($_POST["email"]);
            if ($existingUser) {
                $_SESSION["create_user"]["errors"] = ["email_error" => "Email already exists"];
                header("Location: createUser");
                return;
            }
            $errors = self::data_validation();
            if (count($errors)) {
                $_SESSION["create_user"]["errors"] = $errors;
                header("Location: create");
                return;
            }
            $pass = password_hash($_POST["password"], PASSWORD_DEFAULT);

            User::createUser(
                htmlentities($_POST["first_name"]),
                htmlentities($_POST["last_name"]),
                htmlentities($_POST["email"]),
                $pass,
                htmlentities($_POST["role_id"])
            );
            header("Location: users");
        }
        // GET => show form
        if (!isset($_SESSION["create_user"]["user"])) {
            $_SESSION["create_user"]["user"] = [
                "first_name" => "",
                "last_name" => "",
                "email" => "",
            ];
        }
        $roles = UserRole::getAllRoles();
        require_once "app/views/users/create.php";
    }

    public static function makeAdmin() {
        $user = User::getUserById($_POST["id"]);
        if ($user) {
            User::updateRole($user["id"], 1);
        }
        header("Location: users");
    }

    public static function search() {
        if (isset($_GET["email"])) {
            $email = htmlentities($_GET['email']);
            $user = User::getUserByEmail($email);
            if ($user) {
                $users = [$user];
                $is_search = true;
            } else {
                $error_message = "No user found with email: $email";
                $users = User::getAllUsers();
            }
        } else {
            $users = User::getAllUsers();
            $is_search = false;
            $error_message = "Please enter an email to search";
        }
        require_once 'app/views/users/index.php';
    }
}
?>