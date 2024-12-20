<?php
require_once 'app/models/PlayerStatistics.php';

class StatisticsController {
    public static function topScorers() {
        if (!isset($_SESSION["request_user"])) {
            header("Location: login");
            return;
        }
        $players = PlayerStatistics::getTopScorers();
        require_once 'app/views/statistics/top.php';
    }

    public static function getStats() {
        if (isset($_GET['match_id']) && isset($_GET['team_id'])) {
            $match_id = $_GET['match_id'];
            $team_id = $_GET['team_id'];

            $stats = PlayerStatistics::getStats($match_id, $team_id);

            echo json_encode($stats);
        } else {
            echo json_encode([]);
        }
    }
}
?>