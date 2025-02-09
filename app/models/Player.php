<?php
class Player {
    public static function getAllPlayers() {
        global $pdo;
        $sql = "SELECT * FROM players";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPlayersByTeam($team_id) {
        global $pdo;
        $sql = "SELECT players.*, teams.name as team_name
                FROM players 
                JOIN teams ON players.team_id = teams.id
                WHERE team_id = :team_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array('team_id' => $team_id));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPlayerById($player_id) {
        global $pdo;
        $sql = "SELECT * FROM players WHERE id = :player_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array('player_id' => $player_id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function createPlayer($first_name, $last_name, $age, $position, $nationality, $team_id) {
        global $pdo;
        $sql = "INSERT INTO players (first_name, last_name, age, position, nationality, team_id) 
                VALUES (:first_name, :last_name, :age, :position, :nationality, :team_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            'first_name' => $first_name, 
            'last_name' => $last_name, 
            'age' => $age, 
            'position' => $position,
            'nationality' => $nationality,
            'team_id' => $team_id
        ));
    }

    public static function deletePlayer($player_id) {
        global $pdo;
        $sql = "DELETE FROM players WHERE id = :player_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array('player_id' => $player_id));
    }
}
?>