<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="app/views/statistics/top.css">
</head>
<body>
    <a href="index.php">
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
                <td><?= $position++?></td>
                <td><?= $player["first_name"]. ' ' . $player["last_name"] ?></td>
                <td><?= $player["team_name"] ?></td>
                <td><?= $player["total_goals"] ?></td>
                <td><?= $player["total_assists"] ?></td>
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