<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app/views/teams/CSS/teamDetails.css">
    <title>Team Details</title>
</head>
<body>
    <a href="index">
        <img src="/HN/logo.png" class="logo" alt="Logo">
    </a>
    <div class="message">Click the logo to return to the homepage</div>
    <div class="team-details">
        <h1 class="team-name"><?= $team['name'] ?></h1>
        <div class="team-info">
            <p><strong>Coach:</strong> <?= $team['coach'] ?></p>
            <p><strong>Arena:</strong> <?= $team['arena'] ?></p>
        </div>
        <div class="team-logo">
            <img src="<?= $team['photo'] ?>" alt="<?= $team['name'] ?>">
        </div>
        <?php if ($_SESSION['request_user']['role_id'] == 1) : ?>
        <button onclick="window.location.href='createPlayer.php?team_id=<?= $team['id'] ?>'">Create Player</button>
        <?php endif; ?>
    </div>
    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Age</th>
            <th>Position</th>
            <th>Nationality</th>
            <th></th>
        </tr>
        <?php foreach ($players as $player) : ?>
            <tr class="fade-in">
                <td><?= $player["first_name"] ?></td>
                <td><?= $player["last_name"] ?></td>
                <td><?= $player["age"] ?></td>
                <td><?= $player["position"] ?></td>
                <td><?= $player["nationality"] ?></td>
                <td>
                    <form action="deletePlayer" method="POST" style="display: inline;">
                        <input type="hidden" name="player_id" value="<?= $player['id'] ?>">
                        <input type="hidden" name="team_id" value="<?= $_GET['team_id'] ?>">
                        <input type="submit" value="X">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <script src="app/views/teams/JS/teamDetails.js"></script>
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
