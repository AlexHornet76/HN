<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app/views/auth/register.css">
    <title>Login</title>
</head>
<body>
<img src="/HN/logo.png" class="logo" alt="Logo">
      <div class="container">
        <div class="box form-box">
            <header>Login</header>
            <form method="post">
                <!-- Adăugăm un token CSRF -->
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>
                <div class="field">
                <p style="color: red;">
                    <?php 
                    if (isset($_SESSION['login_error'])):
                        echo htmlspecialchars($_SESSION['login_error'], ENT_QUOTES, 'UTF-8');
                        unset($_SESSION['login_error']);
                        endif;
                    ?>
                </p>
                    <input type="submit" class="btn" name="submit" value="Login">
                </div>
                <div class="links">
                    Don't have account? <a href="register">Register</a>
                </div>
            </form>
        </div>
      </div>
</body>
</html>