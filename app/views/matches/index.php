<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app/views/matches/CSS/index.css">
    <title>Matches</title>
</head>
<body>
    <?php if ($_SESSION['request_user']['role_id'] == 1) : ?>
        <button onclick="window.location.href='createMatch'" class="create-match-button">Add a match</button>
    <?php endif; ?>
    <div class="container">
        <?php foreach ($matches as $match) : ?>
            <div class="match">
                <div class="team-row">
                    <a href="teamDetails.php?team_id=<?= htmlspecialchars($match['home_team_id'], ENT_QUOTES, 'UTF-8') ?>" class="team-name">
                        <?= htmlspecialchars($match['home_team_name'], ENT_QUOTES, 'UTF-8') ?>
                    </a>
                    <span class="score"><?= htmlspecialchars($match['home_team_goals'], ENT_QUOTES, 'UTF-8') ?></span>
                </div>
                <div class="team-row">
                    <a href="teamDetails.php?team_id=<?= htmlspecialchars($match['away_team_id'], ENT_QUOTES, 'UTF-8') ?>" class="team-name">
                        <?= htmlspecialchars($match['away_team_name'], ENT_QUOTES, 'UTF-8') ?>
                    </a>
                    <span class="score"><?= htmlspecialchars($match['away_team_goals'], ENT_QUOTES, 'UTF-8') ?></span>
                </div>
                <div class="button-container">
                    <div class="buttons">
                        <form action="deleteMatch" method="POST" class="delete-form">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                            <input type="hidden" name="match_id" value="<?= htmlspecialchars($match['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit" class="delete-button">X</button>
                        </form>
                        <button onclick="window.location.href='editMatch.php?match_id=<?= htmlspecialchars($match['id'], ENT_QUOTES, 'UTF-8') ?>'" class="edit-button">
                            Edit
                        </button>
                    </div>
                    <div class="date-container">
                        <div class="date"><?= htmlspecialchars((new DateTime($match['date_played']))->format('d.m.Y'), ENT_QUOTES, 'UTF-8') ?></div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <a href="index">
        <img src="/HN/logo.png" class="logo" alt="Logo">
    </a>
    <div class="message">Click the logo to return to the homepage</div>
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
