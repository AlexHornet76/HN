<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Scorers</title>
    <link rel="stylesheet" href="app/views/statistics/top.css">
</head>
<body>
    <a href="index">
        <img src="/HN/logo.png" class="logo" alt="Logo">
    </a>
    <div class="message">Click the logo to return to the homepage</div>
    <h1>Top Scorers</h1>
    <table>
        <tr>
            <th>Position</th>
            <th>Player</th>
            <th>Team</th>
            <th>Goals</th>
            <th>Assists</th>
        </tr>
        <?php 
        $position = 1;
        foreach ($players as $player) : ?>
            <tr>
                <td><?= htmlspecialchars($position++, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($player["first_name"], ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($player["last_name"], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($player["team_name"], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($player["total_goals"], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($player["total_assists"], ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
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
