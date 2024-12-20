<?php
require_once 'app/models/Teams.php';
require_once 'app/models/Player.php';

class TeamsController {
    public static function index() {
        $teams = Teams::getAllTeams();
        require_once 'app/views/teams/index.php';
    }

    public static function rankings() {
        $rankings = Teams::getRankings();
        require_once 'app/views/teams/rankings.php';
    }

    public static function show() {
        if (!isset($_SESSION["request_user"])) {
            header("Location: login");
            return;
        }
        $team_id = $_GET['team_id'];
        $team = Teams::getTeamById($team_id);
        $players = Player::getPlayersByTeam($team_id);
        require_once 'app/views/teams/teamDetails.php';
    }
}
?>