<!DOCTYPE html>
<html>
<head>
    <title>Update Match</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app/views/matches/CSS/create.css">
</head>
<body>
    <header>
        <h1>Update Match</h1>
    </header>
    <main>
        <form action="updateMatch" method="POST" id="update-match-form">
            <input type="hidden" id="match_id" name="match_id" value="<?php echo $match['id']; ?>">
            <div id="match-details">
                <h2>Match Details</h2>
                <div class="input-group">
                    <label for="date_played">Date:</label>
                    <input type="date" id="date_played" name="date_played" required value="<?php echo $match['date_played']; ?>">
                </div>
            </div>

            <div class="team-sections">
                <div class="team-section">
                    <h2>Home Team</h2>
                    <div class="input-group">
                        <label for="home_team_goals">Goals:</label>
                        <input type="number" id="home_team_goals" name="home_team_goals" required min="0" value="<?php echo $match['home_team_goals']; ?>">
                    </div>
                    <div class="input-group">
                        <label for="home_team_id">Select Team:</label>
                        <select id="home_team_id" name="home_team_id" required onchange="updateAwayTeamOptions(); updatePlayers(this.value, 'home');">
                            <option value="">Select a team</option>
                            <?php
                                foreach($teams as $team) {
                                    $selected = $team['id'] == $match['home_team_id'] ? 'selected' : '';
                                    echo "<option value='{$team['id']}' {$selected}>{$team['name']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div id="home_team_players">
                        <?php foreach ($home_team_players as $player): ?>
                            <div class='player-item'>
                                <p><strong><?php echo $player['first_name'] . " " . $player['last_name']; ?></strong></p>
                                <div class='player-stats'>
                                    <div class='stat-item'>
                                        <label for='player_<?php echo $player['id']; ?>_goals'>Goluri:</label>
                                        <input type='number' id='player_<?php echo $player['id']; ?>_goals' name='player_<?php echo $player['id']; ?>_goals' required min='0' value='<?php echo $player['goals']; ?>'>
                                    </div>
                                    <div class='stat-item'>
                                        <label for='player_<?php echo $player['id']; ?>_assists'>Asisturi:</label>
                                        <input type='number' id='player_<?php echo $player['id']; ?>_assists' name='player_<?php echo $player['id']; ?>_assists' required min='0' value='<?php echo $player['assists']; ?>'>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="team-section">
                    <h2>Away Team</h2>
                    <div class="input-group">
                        <label for="away_team_goals">Goals:</label>
                        <input type="number" id="away_team_goals" name="away_team_goals" required min="0" value="<?php echo $match['away_team_goals']; ?>">
                    </div>
                    <div class="input-group">
                        <label for="away_team_id">Select Team:</label>
                        <select id="away_team_id" name="away_team_id" required onchange="updateHomeTeamOptions(); updatePlayers(this.value, 'away');">
                            <option value="">Select a team</option>
                            <?php
                                foreach($teams as $team) {
                                    $selected = $team['id'] == $match['away_team_id'] ? 'selected' : '';
                                    echo "<option value='{$team['id']}' {$selected}>{$team['name']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div id="away_team_players">
                        <?php foreach ($away_team_players as $player): ?>
                            <div class='player-item'>
                                <p><strong><?php echo $player['first_name'] . " " . $player['last_name']; ?></strong></p>
                                <div class='player-stats'>
                                    <div class='stat-item'>
                                        <label for='player_<?php echo $player['id']; ?>_goals'>Goluri:</label>
                                        <input type='number' id='player_<?php echo $player['id']; ?>_goals' name='player_<?php echo $player['id']; ?>_goals' required min='0' value='<?php echo $player['goals']; ?>'>
                                    </div>
                                    <div class='stat-item'>
                                        <label for='player_<?php echo $player['id']; ?>_assists'>Asisturi:</label>
                                        <input type='number' id='player_<?php echo $player['id']; ?>_assists' name='player_<?php echo $player['id']; ?>_assists' required min='0' value='<?php echo $player['assists']; ?>'>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="submit-section">
                <input type="submit" value="Update Match">
            </div>
        </form>
    </main>
    <script src="app/views/matches/JS/edit.js"></script>
</body>
</html>