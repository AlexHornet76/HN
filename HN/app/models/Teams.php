<?php
class Teams {
    public static function getAllTeams() {
        global $pdo;
        $sql = "SELECT * FROM teams";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getRankings() {
        global $pdo;
        $sql = "SELECT teams.*, league.* 
                FROM teams 
                JOIN league ON teams.id = league.team_id
                ORDER BY league.points DESC, league.matches_played, league.goals_scored - league.goals_conceded DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTeamById($team_id) {
        global $pdo;
        $sql = "SELECT * FROM teams WHERE id = :team_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array('team_id' => $team_id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>