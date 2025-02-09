<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app/views/contact/index.css">
    <title>Contact</title>
</head>
<body>
<img src="/HN/logo.png" class="logo" alt="Logo">
      <div class="container">
        <div class="box form-box">
            <header>Contact</header>
            <form method="post" action = "sendEmail">
                <!-- Adăugăm un token CSRF -->
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">

                <div class="field input">
                    <label for="mess">Write anything (suggestions or any ideas)</label>
                    <input type="mess" name="mess" id="mess" autocomplete="off" required>
                </div>
                <div class="field">
                
                    <input type="submit" class="btn" name="submit" value="Send message">
                </div>
            </form>
        </div>
      </div>
</body>
</html>