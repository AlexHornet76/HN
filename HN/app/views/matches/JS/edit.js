document.addEventListener('DOMContentLoaded', function() {
    updateAwayTeamOptions();
    updateHomeTeamOptions();
    updatePlayers(document.getElementById('home_team_id').value, 'home');
    updatePlayers(document.getElementById('away_team_id').value, 'away');
});
var match_id = document.getElementById('match_id').value;
function updateAwayTeamOptions() {
    var homeTeamSelect = document.getElementById('home_team_id');
    var awayTeamSelect = document.getElementById('away_team_id');
    var selectedHomeTeam = homeTeamSelect.value;

    for (var i = 0; i < awayTeamSelect.options.length; i++) {
        if (awayTeamSelect.options[i].value === selectedHomeTeam) {
            awayTeamSelect.options[i].disabled = true;
        } else {
            awayTeamSelect.options[i].disabled = false;
        }
    }
}

function updateHomeTeamOptions() {
    var homeTeamSelect = document.getElementById('home_team_id');
    var awayTeamSelect = document.getElementById('away_team_id');
    var selectedAwayTeam = awayTeamSelect.value;

    for (var i = 0; i < homeTeamSelect.options.length; i++) {
        if (homeTeamSelect.options[i].value === selectedAwayTeam) {
            homeTeamSelect.options[i].disabled = true;
        } else {
            homeTeamSelect.options[i].disabled = false;
        }
    }
}

function updatePlayers(teamId, teamType) {
    if (teamId === "") {
        console.log("No team selected for", teamType);
        document.getElementById(teamType + '_team_players').innerHTML = "";
        return;
    }

    console.log("Fetching players for team ID:", teamId);
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "getStats.php?match_id=" + match_id + "&team_id=" + teamId, true);
    console.log(xhr);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            console.log("XHR readyState:", xhr.readyState);
            console.log("XHR status:", xhr.status);
            console.log("Response Text:", xhr.responseText);
            
            if (xhr.status == 200) {
                try {
                    var players = JSON.parse(xhr.responseText);
                    console.log("Players Data:", players);

                    var playersHtml = "";
                    players.forEach(function(player) {
                        playersHtml += "<div class='player-item'>";
                        playersHtml += "<p><strong>" + player.first_name + " " + player.last_name + "</strong></p>";
                        playersHtml += "<div class='player-stats'>";
                        playersHtml += "<div class='stat-item'>";
                        playersHtml += "<label for='player_" + player.id + "_goals'>Goluri:</label>";
                        playersHtml += "<input type='number' id='player_" + player.id + "_goals' name='player_" + player.id + "_goals' required min='0' value='" + (player.goals || 0) + "'>";
                        playersHtml += "</div>";
                        playersHtml += "<div class='stat-item'>";
                        playersHtml += "<label for='player_" + player.id + "_assists'>Asisturi:</label>";
                        playersHtml += "<input type='number' id='player_" + player.id + "_assists' name='player_" + player.id + "_assists' required min='0' value='" + (player.assists || 0) + "'>";
                        playersHtml += "</div>";
                        playersHtml += "</div>";
                        playersHtml += "</div>";
                    });
                    document.getElementById(teamType + '_team_players').innerHTML = playersHtml;
                } catch (e) {
                    console.error("Error parsing JSON:", e.message);
                    console.error("Raw Response:", xhr.responseText);
                }
            } else {
                console.error("HTTP Error:", xhr.status, xhr.statusText);
                console.error("Raw Response:", xhr.responseText);
            }
        }
    };
    xhr.send();
}