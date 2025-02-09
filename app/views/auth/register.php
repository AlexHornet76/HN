<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app/views/auth/register.css">
    <title>Register</title>
</head>
<body>
<img src="/HN/logo.png" class="logo" alt="Logo">
<div class="container">
<div class="box form-box">
    <form action="register" method="post">
        <input type="hidden" name="reg" value="1">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">

        <div class="field input">
        <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" 
            value="<?= htmlspecialchars($_SESSION['register_user']['user']['first_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="field input">
        <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" 
            value="<?= htmlspecialchars($_SESSION['register_user']['user']['last_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <p style="color: red;">
            <?php 
            if (isset($_SESSION['register_user']["errors"]['last_name_error'])):
                echo htmlspecialchars($_SESSION['register_user']["errors"]['last_name_error'], ENT_QUOTES, 'UTF-8');
                unset($_SESSION['register_user']["errors"]['last_name_error']);
                endif;
            ?>
        </p>

        <div class="field input">
        <label for="email">Email</label>
            <input type="text" name="email" id="email" 
            value="<?= htmlspecialchars($_SESSION['register_user']['user']['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <p style="color: red;">
            <?php 
            if (isset($_SESSION['register_user']["errors"]['email_error'])):
                echo htmlspecialchars($_SESSION['register_user']["errors"]['email_error'], ENT_QUOTES, 'UTF-8');
                unset($_SESSION['register_user']["errors"]['email_error']);
                endif;
            ?>
        </p>

        <div class="field input">
        <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>
        <p style="color: red;">
            <?php 
            if (isset($_SESSION['register_user']["errors"]['password_error'])):
                echo htmlspecialchars($_SESSION['register_user']["errors"]['password_error'], ENT_QUOTES, 'UTF-8');
                unset($_SESSION['register_user']["errors"]['password_error']);
                endif;
            ?>
        </p>

        <div class="field">
            <input type="submit" class="btn" name="submit" value="Register">
        </div>
        <div class="links">
            Already a member? <a href="login">Sign In</a>
        </div>
    </form>
    </div>
    </div>
</body>
</html>
