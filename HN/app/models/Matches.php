<?php
    class Matches{
        public static function getAllMatches(){
            global $pdo;
            $query = "SELECT home_team.name as home_team_name, 
            away_team.name as away_team_name, 
            home_team_goals, away_team_goals, 
            date_played, home_team_id, away_team_id, matches.id
            FROM matches
            JOIN teams as home_team ON home_team.id = matches.home_team_id
            JOIN teams as away_team ON away_team.id = matches.away_team_id";
            $stmt = $pdo->query($query);
            $matches = $stmt->fetchAll();
            return $matches;
        }
        public static function createMatch($home_team_id, $away_team_id, $home_team_goals, $away_team_goals, $date_played){
            global $pdo;
            $query = "INSERT INTO matches (home_team_id, away_team_id, home_team_goals, away_team_goals, date_played) 
            VALUES (:home_team_id, :away_team_id, :home_team_goals, :away_team_goals, :date_played)";
            $stmt = $pdo->prepare($query);
            $stmt->execute(array(
                'home_team_id' => $home_team_id,
                'away_team_id' => $away_team_id,
                'home_team_goals' => $home_team_goals,
                'away_team_goals' => $away_team_goals,
                'date_played' => $date_played
            ));
            return $pdo->lastInsertId();
        }
        public static function deleteMatch($match_id){
            global $pdo;
            $query = "DELETE FROM matches WHERE id = :match_id";
            $stmt = $pdo->prepare($query);
            $stmt->execute(array('match_id' => $match_id));
        }
        public static function getMatchById($match_id){
            global $pdo;
            $query = "SELECT * FROM matches WHERE id = :match_id";
            $stmt = $pdo->prepare($query);
            $stmt->execute(array('match_id' => $match_id));
            return $stmt->fetch();
        }
        public static function updateMatch($match_id, $home_team_id, $away_team_id, $home_team_goals, $away_team_goals, $date_played){
            global $pdo;
            $query = "UPDATE matches SET home_team_id = :home_team_id, away_team_id = :away_team_id, home_team_goals = :home_team_goals, away_team_goals = :away_team_goals, date_played = :date_played WHERE id = :match_id";
            $stmt = $pdo->prepare($query);
            $stmt->execute(array(
                'home_team_id' => $home_team_id,
                'away_team_id' => $away_team_id,
                'home_team_goals' => $home_team_goals,
                'away_team_goals' => $away_team_goals,
                'date_played' => $date_played,
                'match_id' => $match_id
            ));
        }
    }
?>