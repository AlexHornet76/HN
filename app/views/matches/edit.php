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
            <input type="hidden" id="match_id" name="match_id" value="<?= htmlspecialchars($form_data['match_id'] ?? $match['id']) ?>">
            <input type="hidden" id="csrf_token" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

            <div id="match-details">
                <h2>Match Details</h2>
                <div class="input-group">
                    <label for="date_played">Date:</label>
                    <input type="date" id="date_played" name="date_played" 
                        value="<?= htmlspecialchars($form_data['date_played'] ?? $match['date_played']) ?>" 
                        required>
                </div>
            </div>

            <?php if (!empty($error_message)): ?>
                <p style="color: red; text-align:center"><?= htmlspecialchars($error_message) ?></p>
            <?php endif; ?>

            <div class="team-sections">
                <div class="team-section">
                    <h2>Home Team</h2>
                    <div class="input-group">
                        <label for="home_team_goals">Goals:</label>
                        <input type="number" id="home_team_goals" name="home_team_goals" 
                            value="<?= htmlspecialchars($form_data['home_team_goals'] ?? $match['home_team_goals']) ?>" 
                            required min="0">
                    </div>
                    <div class="input-group">
                        <label for="home_team_id">Select Team:</label>
                        <select id="home_team_id" name="home_team_id" required onchange="updateAwayTeamOptions(); updatePlayers(this.value, 'home');">
                            <option value="">Select a team</option>
                            <?php foreach ($teams as $team): ?>
                                <option value="<?= htmlspecialchars($team['id']) ?>" 
                                        <?= ($form_data['home_team_id'] ?? $match['home_team_id']) == $team['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($team['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div id="home_team_players">
                        <?php foreach ($home_team_players as $player): ?>
                            <div class="player-item">
                                <p><strong><?= htmlspecialchars($player['first_name'] . ' ' . $player['last_name']) ?></strong></p>
                                <div class="player-stats">
                                    <div class="stat-item">
                                        <label for="player_<?= $player['id'] ?>_goals">Goluri:</label>
                                        <input type="number" id="player_<?= $player['id'] ?>_goals" 
                                            name="player_<?= $player['id'] ?>_goals" 
                                            value="<?= htmlspecialchars($form_data["player_{$player['id']}_goals"] ?? $player['goals']) ?>" 
                                            required min="0">
                                    </div>
                                    <div class="stat-item">
                                        <label for="player_<?= $player['id'] ?>_assists">Asisturi:</label>
                                        <input type="number" id="player_<?= $player['id'] ?>_assists" 
                                            name="player_<?= $player['id'] ?>_assists" 
                                            value="<?= htmlspecialchars($form_data["player_{$player['id']}_assists"] ?? $player['assists']) ?>" 
                                            required min="0">
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
                        <input type="number" id="away_team_goals" name="away_team_goals" 
                            value="<?= htmlspecialchars($form_data['away_team_goals'] ?? $match['away_team_goals']) ?>" 
                            required min="0">
                    </div>
                    <div class="input-group">
                        <label for="away_team_id">Select Team:</label>
                        <select id="away_team_id" name="away_team_id" required onchange="updateHomeTeamOptions(); updatePlayers(this.value, 'away');">
                            <option value="">Select a team</option>
                            <?php foreach ($teams as $team): ?>
                                <option value="<?= htmlspecialchars($team['id']) ?>" 
                                        <?= ($form_data['away_team_id'] ?? $match['away_team_id']) == $team['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($team['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div id="away_team_players">
                        <?php foreach ($away_team_players as $player): ?>
                            <div class="player-item">
                                <p><strong><?= htmlspecialchars($player['first_name'] . ' ' . $player['last_name']) ?></strong></p>
                                <div class="player-stats">
                                    <div class="stat-item">
                                        <label for="player_<?= $player['id'] ?>_goals">Goluri:</label>
                                        <input type="number" id="player_<?= $player['id'] ?>_goals" 
                                            name="player_<?= $player['id'] ?>_goals" 
                                            value="<?= htmlspecialchars($form_data["player_{$player['id']}_goals"] ?? $player['goals']) ?>" 
                                            required min="0">
                                    </div>
                                    <div class="stat-item">
                                        <label for="player_<?= $player['id'] ?>_assists">Asisturi:</label>
                                        <input type="number" id="player_<?= $player['id'] ?>_assists" 
                                            name="player_<?= $player['id'] ?>_assists" 
                                            value="<?= htmlspecialchars($form_data["player_{$player['id']}_assists"] ?? $player['assists']) ?>" 
                                            required min="0">
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