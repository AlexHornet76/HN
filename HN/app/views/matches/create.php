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
                <input type="date" id="date_played" name="date_played" required>
            </div>
        </div>

        <div class="team-sections">
            <div class="team-section">
                <h2>Home Team</h2>
                <div class="input-group">
                    <label for="home_team_goals">Goals:</label>
                    <input type="number" id="home_team_goals" name="home_team_goals" required min="0">
                </div>
                <div class="input-group">
                    <label for="home_team_id">Select Team:</label>
                    <select id="home_team_id" name="home_team_id" required onchange="updateAwayTeamOptions(); updatePlayers(this.value, 'home');">
                        <option value="">Select a team</option>
                        <?php
                            $teams = Teams::getAllTeams();
                            foreach($teams as $team) {
                                echo "<option value='{$team['id']}'>{$team['name']}</option>";
                            }
                        ?>
                    </select>
                </div>
                <div id="home_team_players"></div>
            </div>

            <div class="team-section">
                <h2>Away Team</h2>
                <div class="input-group">
                    <label for="away_team_goals">Goals:</label>
                    <input type="number" id="away_team_goals" name="away_team_goals" required min="0">
                </div>
                <div class="input-group">
                    <label for="away_team_id">Select Team:</label>
                    <select id="away_team_id" name="away_team_id" required onchange="updateHomeTeamOptions(); updatePlayers(this.value, 'away');">
                        <option value="">Select a team</option>
                        <?php
                            foreach($teams as $team) {
                                echo "<option value='{$team['id']}'>{$team['name']}</option>";
                            }
                        ?>
                    </select>
                </div>
                <div id="away_team_players"></div>
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