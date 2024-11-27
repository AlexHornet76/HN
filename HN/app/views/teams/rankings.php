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
<div class="button-container">
    <button onclick="window.location.href='topScorers'">Top Scorers</button>
    <button onclick="window.location.href='matches'">Matches</button>
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
            <td><?= $position++?></td>
            <td><a href="teamDetails.php?team_id=<?= $team['id'] ?>"><?= $team["name"] ?></td>
            <td><?= $team["matches_played"] ?></td>
            <td><?= $team["wins"] ?></td>
            <td><?= $team["draws"] ?></td>
            <td><?= $team["losses"] ?></td>
            <td><?= $team["goals_scored"] ?></td>
            <td><?= $team["goals_conceded"] ?></td>
            <td><?= $team["points"] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
<script src="app/views/teams/JS/rankings.js"></script>
</body>
</html>
