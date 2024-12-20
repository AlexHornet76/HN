<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app/views/auth/register.css">
    <title>Create User</title>
</head>
<body>
<img src="/HN/logo.png" class="logo" alt="Logo">

<div class="container">
<div class="box form-box">
    <form action="createUser" method="post">
        <input type="hidden" name="is_post" value="1">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">

        <div class="field input">
        <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" required
            value="<?= isset($_SESSION['create_user']['user']['first_name']) ? htmlspecialchars($_SESSION['create_user']['user']['first_name'], ENT_QUOTES, 'UTF-8') : '' ?>">
        </div>

        <div class="field input">
        <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" required
            value="<?= isset($_SESSION['create_user']['user']['last_name']) ? htmlspecialchars($_SESSION['create_user']['user']['last_name'], ENT_QUOTES, 'UTF-8') : '' ?>">
        </div>
        <p style="color: red;">
            <?php 
            if (isset($_SESSION['create_user']["errors"]['last_name_error'])):
                echo htmlspecialchars($_SESSION['create_user']["errors"]['last_name_error'], ENT_QUOTES, 'UTF-8');
                unset($_SESSION['create_user']["errors"]['last_name_error']);
            endif;
            ?>
        </p>

        <div class="field input">
        <label for="email">Email</label>
            <input type="email" name="email" id="email" required
            value="<?= isset($_SESSION['create_user']['user']['email']) ? htmlspecialchars($_SESSION['create_user']['user']['email'], ENT_QUOTES, 'UTF-8') : '' ?>">
        </div>
        <p style="color: red;">
            <?php 
            if (isset($_SESSION['create_user']["errors"]['email_error'])):
                echo htmlspecialchars($_SESSION['create_user']["errors"]['email_error'], ENT_QUOTES, 'UTF-8');
                unset($_SESSION['create_user']["errors"]['email_error']);
            endif;
            ?>
        </p>

        <div class="field input">
        <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>
        <p style="color: red;">
            <?php 
            if (isset($_SESSION['create_user']["errors"]['password_error'])):
                echo htmlspecialchars($_SESSION['create_user']["errors"]['password_error'], ENT_QUOTES, 'UTF-8');
                unset($_SESSION['create_user']["errors"]['password_error']);
            endif;
            ?>
        </p>

        <div class="field input">
        <label for="role_id">Role</label>
            <select name="role_id" id="role" required>
                <option value="1" <?= isset($_SESSION['create_user']['user']['role_id']) && $_SESSION['create_user']['user']['role_id'] == 1 ? 'selected' : '' ?>>Admin</option>
                <option value="2" <?= isset($_SESSION['create_user']['user']['role_id']) && $_SESSION['create_user']['user']['role_id'] == 2 ? 'selected' : '' ?>>User</option>
            </select>
        </div>

        <div class="field">
            <input type="submit" class="btn" name="submit" value="Create User">
        </div>
    </form>
</div>
</div>
</body>
</html>
