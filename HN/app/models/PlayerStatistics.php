<?php
class PlayerStatistics
{
    public static function createPlayerStatistics($player_id, $match_id, $goals, $assists)
    {
        global $pdo;
        $query = "INSERT INTO player_statistics (player_id, match_id, goals, assists) VALUES (:player_id, :match_id, :goals, :assists)";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(
            'player_id' => $player_id,
            'match_id' => $match_id,
            'goals' => $goals,
            'assists' => $assists
        ));
        return $pdo->lastInsertId();
    }

    public static function getPlayersByTeamId($team_id)
    {
        global $pdo;
        $query = "SELECT * FROM players WHERE team_id = :team_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array('team_id' => $team_id));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTopScorers()
    {
        global $pdo;
        $sql = "SELECT players.first_name, players.last_name, 
                SUM(player_statistics.goals) AS total_goals, 
                SUM(player_statistics.assists) AS total_assists,
                teams.name AS team_name
            FROM player_statistics
            JOIN players ON player_statistics.player_id = players.id
            JOIN teams ON players.team_id = teams.id
            GROUP BY players.id, players.first_name, players.last_name
            ORDER BY total_goals DESC, total_assists DESC
            LIMIT 20";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getStats($match_id, $team_id)
    {
        global $pdo;
        $sql = "SELECT players.first_name, players.last_name, 
                player_statistics.goals as goals, player_statistics.assists as assists,
                player_statistics.player_id AS id
            FROM player_statistics
            JOIN players ON player_statistics.player_id = players.id
            WHERE player_statistics.match_id = :match_id AND players.team_id = :team_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array('match_id' => $match_id, 'team_id' => $team_id));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function updatePlayerStatistics($player_id, $match_id, $goals, $assists)
    {
        global $pdo;
        $query = "UPDATE player_statistics SET goals = :goals, assists = :assists WHERE player_id = :player_id AND match_id = :match_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(
            'player_id' => $player_id,
            'match_id' => $match_id,
            'goals' => $goals,
            'assists' => $assists
        ));
    }
}
?>