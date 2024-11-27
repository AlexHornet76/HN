<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app/views/matches/CSS/index.css">
    <title>Matches</title>
</head>
<body>
    <button onclick="window.location.href='createMatch'" class="create-match-button">Add a match</button>
    <div class="container">
        <?php foreach ($matches as $match) : ?>
            <div class="match">
                <div class="team-row">
                    <a href="teamDetails.php?team_id=<?= $match['home_team_id'] ?>" class="team-name"><?= $match['home_team_name'] ?></a>
                    <span class="score"><?= $match['home_team_goals'] ?></span>
                </div>
                <div class="team-row">
                    <a href="teamDetails.php?team_id=<?= $match['away_team_id'] ?>" class="team-name"><?= $match['away_team_name'] ?></a>
                    <span class="score"><?= $match['away_team_goals'] ?></span>
                </div>
                <div class="button-container">
                <div class="buttons">
                    <form action="deleteMatch" method="POST" class="delete-form">
                        <input type="hidden" name="match_id" value="<?= $match['id'] ?>">
                        <button type="submit" class="delete-button">X</button>
                    </form>
                    <button onclick="window.location.href='editMatch.php?match_id=<?= $match['id'] ?>'" class="edit-button">Edit</button>
                </div>
                <div class="date-container">
                    <div class="date"><?= (new DateTime($match['date_played']))->format('d.m.Y') ?></div>
                </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <a href="index.php">
        <img src="/HN/logo.png" class="logo" alt="Logo">
    </a>
</body>

</html>