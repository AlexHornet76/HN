<!DOCTYPE html>
<html>
<head>
    <title>Create Match</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app/views/matches/CSS/create.css">
</head>
<body>
    <header>
        <h1>Add Match</h1>
    </header>
    <main>

        <form action="insertMatch" method="POST" id="create-match-form">
            <div id="match-details">
                <h2>Match Details</h2>
                <div class="input-group">
                    <label for="date_played">Date:</label>
                    <input type="date" id="date_played" name="date_played" 
                           value="<?= htmlspecialchars($form_data['date_played'] ?? '') ?>" 
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
                               value="<?= htmlspecialchars($form_data['home_team_goals'] ?? '') ?>" 
                               required min="0">
                    </div>
                    <div class="input-group">
                        <label for="home_team_id">Select Team:</label>
                        <select id="home_team_id" name="home_team_id" required 
                                onchange="updateAwayTeamOptions(); updatePlayers(this.value, 'home');">
                            <option value="">Select a team</option>
                            <?php
                            foreach ($teams as $team) {
                                $selected = (isset($form_data['home_team_id']) && $form_data['home_team_id'] == $team['id']) ? 'selected' : '';
                                echo "<option value='{$team['id']}' $selected>{$team['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div id="home_team_players">
                        <!-- Populate players dynamically if form data exists -->
                        <?php if (isset($form_data['home_team_id'])): ?>
                            <?php
                            $home_team_players = PlayerStatistics::getPlayersByTeamId($form_data['home_team_id']);
                            foreach ($home_team_players as $player):
                                $player_goals = htmlspecialchars($form_data["player_{$player['id']}_goals"] ?? 0);
                                $player_assists = htmlspecialchars($form_data["player_{$player['id']}_assists"] ?? 0);
                            ?>
                                <div class="player-item">
                                    <p><strong><?= htmlspecialchars($player['first_name'] . ' ' . $player['last_name']) ?></strong></p>
                                    <div class="player-stats">
                                        <div class="stat-item">
                                            <label for="player_<?= $player['id'] ?>_goals">Goluri:</label>
                                            <input type="number" id="player_<?= $player['id'] ?>_goals" 
                                                   name="player_<?= $player['id'] ?>_goals" 
                                                   value="<?= $player_goals ?>" 
                                                   required min="0">
                                        </div>
                                        <div class="stat-item">
                                            <label for="player_<?= $player['id'] ?>_assists">Asisturi:</label>
                                            <input type="number" id="player_<?= $player['id'] ?>_assists" 
                                                   name="player_<?= $player['id'] ?>_assists" 
                                                   value="<?= $player_assists ?>" 
                                                   required min="0">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="team-section">
                    <h2>Away Team</h2>
                    <div class="input-group">
                        <label for="away_team_goals">Goals:</label>
                        <input type="number" id="away_team_goals" name="away_team_goals" 
                               value="<?= htmlspecialchars($form_data['away_team_goals'] ?? '') ?>" 
                               required min="0">
                    </div>
                    <div class="input-group">
                        <label for="away_team_id">Select Team:</label>
                        <select id="away_team_id" name="away_team_id" required 
                                onchange="updateHomeTeamOptions(); updatePlayers(this.value, 'away');">
                            <option value="">Select a team</option>
                            <?php
                            foreach ($teams as $team) {
                                $selected = (isset($form_data['away_team_id']) && $form_data['away_team_id'] == $team['id']) ? 'selected' : '';
                                echo "<option value='{$team['id']}' $selected>{$team['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div id="away_team_players">
                        <!-- Populate players dynamically if form data exists -->
                        <?php if (isset($form_data['away_team_id'])): ?>
                            <?php
                            $away_team_players = PlayerStatistics::getPlayersByTeamId($form_data['away_team_id']);
                            foreach ($away_team_players as $player):
                                $player_goals = htmlspecialchars($form_data["player_{$player['id']}_goals"] ?? 0);
                                $player_assists = htmlspecialchars($form_data["player_{$player['id']}_assists"] ?? 0);
                            ?>
                                <div class="player-item">
                                    <p><strong><?= htmlspecialchars($player['first_name'] . ' ' . $player['last_name']) ?></strong></p>
                                    <div class="player-stats">
                                        <div class="stat-item">
                                            <label for="player_<?= $player['id'] ?>_goals">Goluri:</label>
                                            <input type="number" id="player_<?= $player['id'] ?>_goals" 
                                                   name="player_<?= $player['id'] ?>_goals" 
                                                   value="<?= $player_goals ?>" 
                                                   required min="0">
                                        </div>
                                        <div class="stat-item">
                                            <label for="player_<?= $player['id'] ?>_assists">Asisturi:</label>
                                            <input type="number" id="player_<?= $player['id'] ?>_assists" 
                                                   name="player_<?= $player['id'] ?>_assists" 
                                                   value="<?= $player_assists ?>" 
                                                   required min="0">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="submit-section">
                <input type="submit" value="Add Match">
            </div>
        </form>
    </main>
    <script src="app/views/matches/JS/create.js"></script>
</body>
</html>
