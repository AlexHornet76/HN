<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app/views/users/CSS/index.css">
    <title>Users</title>
</head>
<body>
<h1>All Users</h1>
<a href="index">
    <img src="/HN/logo.png" class="logo" alt="Logo">
</a>
<div class="message">Click the logo to return to the homepage</div>
<a class="create" href="createUser">Create User</a>

<form action="search" method="GET" class="search-form">
    <input type="text" name="email" placeholder="Enter email to search" required>
    <input type="submit" value="Search">
</form>
<?php if (isset($is_search) && $is_search): ?>
    <form action="users" method="GET" class="search-form">
        <input type="submit" value="Show All Users">
    </form>
<?php endif; ?>

<?php if (isset($error_message) && $error_message): ?>
    <p class="error-message"><?= htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<table>
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Role</th>
        <th></th>
    </tr>
    <?php foreach ($users as $user) : ?>
        <tr class="fade-in">
            <td><?= htmlspecialchars($user["first_name"], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($user["last_name"], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($user["email"], ENT_QUOTES, 'UTF-8') ?></td>
            <td>
                <?= $user["role_id"] == 1 ? 'Admin' : 'User' ?>
            </td>
            <td>
                <?php if ($user["role_id"] != 1): ?>
                    <form action="deleteUser" method="POST" style="display: inline;">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($user["id"], ENT_QUOTES, 'UTF-8') ?>">
                        <input type="submit" value="X">
                    </form>
                    <form action="makeAdmin" method="POST" style="display: inline;">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($user["id"], ENT_QUOTES, 'UTF-8') ?>">
                        <input type="submit" value="Make Admin">
                    </form>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<script src="app/views/users/JS/index.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const message = document.getElementsByClassName('message')[0];
        let visible = false;
        setInterval(() => {
            message.style.opacity = visible ? 0 : 1;
            visible = !visible;
        }, 1000); 
    });
</script>
</body>
</html>
