<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app/views/auth/register.css">
    <title>Profile</title>
</head>
<body>
    <a href="index">
        <img src="/HN/logo.png" class="logo" alt="Logo">
    </a>
    <div class="message">Click the logo to return to the homepage</div>
    <div class="container">
        <div class="box form-box">
            <form action="profile" method="post">
                <input type="hidden" name="profile" value="1">
                <input type="hidden" name="id" value="<?= htmlspecialchars($_SESSION['profile']['user']['id'], ENT_QUOTES, 'UTF-8') ?>">

                <div class="field input">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" id="first_name" value="<?= htmlspecialchars($_SESSION['profile']['user']['first_name'], ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="field input">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" id="last_name" value="<?= htmlspecialchars($_SESSION['profile']['user']['last_name'], ENT_QUOTES, 'UTF-8') ?>">
                </div>
                <p style="color: red;">
                    <?php 
                    if (isset($_SESSION['profile']["errors"]['last_name_error'])):
                        echo htmlspecialchars($_SESSION['profile']["errors"]['last_name_error'], ENT_QUOTES, 'UTF-8');
                        unset($_SESSION['profile']["errors"]['last_name_error']);
                    endif;
                    ?>
                </p>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" value="<?= htmlspecialchars($_SESSION['profile']['user']['email'], ENT_QUOTES, 'UTF-8') ?>">
                </div>
                <p style="color: red;">
                    <?php 
                    if (isset($_SESSION['profile']["errors"]['email_error'])):
                        echo htmlspecialchars($_SESSION['profile']["errors"]['email_error'], ENT_QUOTES, 'UTF-8');
                        unset($_SESSION['profile']["errors"]['email_error']);
                    endif;
                    ?>
                </p>
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Update Profile">
                </div>
            </form>
        </div>
    </div>
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
