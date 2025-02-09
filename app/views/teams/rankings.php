<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>League Rankings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="app/views/teams/CSS/rankings.css">
</head>
<body>
    <img src="/HN/logo.png" class="logo" alt="Logo">
    <h1 class="ml6">
        <span class="text-wrapper">
            <span class="letters">League Rankings</span>
        </span>
    </h1>

    <?php if (isset($_SESSION["request_user"])): ?>
        <a class="log" href="logout">Logout</a>
        <a class="acc" href="profile">Your Account</a>
        <a class="contact" href="contact">Contact</a>
        <?php if ($_SESSION["request_user"]["role_id"] == 1): ?>
            <a class="admin" href="users">Profiles</a>
        <?php endif; ?>
    <?php else: ?>
        <a class="log" href="login">Login</a>
    <?php endif; ?>

    <div class="button-container">
        <button onclick="window.location.href='topScorers'">Top Scorers</button>
        <button onclick="window.location.href='matches'">Matches</button>
        <button onclick="window.location.href='exportRankings'">Export rankings to Excel</button>
        <button onclick="window.location.href='archive'">Archive</button>
    </div>
    <table>
        <tr>
            <th>Position</th>
            <th>Team</th>
            <th>Matches Played</th>
            <th>Wins</th>
            <th>Draws</th>
            <th>Losses</th>
            <th>Goals Scored</th>
            <th>Goals Conceded</th>
            <th>Points</th>
        </tr>
        <?php 
        $position = 1;
        foreach ($rankings as $team) : ?>
            <tr>
                <td><?= htmlspecialchars($position++, ENT_QUOTES, 'UTF-8') ?></td>
                <td>
                    <a href="teamDetails.php?team_id=<?= htmlspecialchars($team['id'], ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($team["name"], ENT_QUOTES, 'UTF-8') ?>
                    </a>
                </td>
                <td><?= htmlspecialchars($team["matches_played"], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($team["wins"], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($team["draws"], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($team["losses"], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($team["goals_scored"], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($team["goals_conceded"], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($team["points"], ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
    <script src="app/views/teams/JS/rankings.js"></script>
</body>
</html>
