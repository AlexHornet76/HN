<?php
class Matches {
    public static function getAllMatches() {
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

    public static function createMatch($home_team_id, $away_team_id, $home_team_goals, $away_team_goals, $date_played) {
        global $pdo;

        // Verifică dacă meciul există deja
        $query = "SELECT * FROM matches WHERE home_team_id = :home_team_id AND away_team_id = :away_team_id AND date_played = :date_played";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(
            'home_team_id' => $home_team_id,
            'away_team_id' => $away_team_id,
            'date_played' => $date_played
        ));
        $existing_match = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing_match) {
            // Meciul există deja, nu face nimic
            return $existing_match['id'];
        }

        // Inserare meci în tabela matches
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

        // Obține ID-ul ultimului meci inserat
        $match_id = $pdo->lastInsertId();
        
            // Actualizează tabela league pentru echipa gazdă
            self::updateLeague($home_team_id, $home_team_goals, $away_team_goals);
        
            // Actualizează tabela league pentru echipa oaspete
            self::updateLeague($away_team_id, $away_team_goals, $home_team_goals);
        
            return $match_id;
        }
        
        public static function updateLeague($team_id, $goals_scored, $goals_conceded) {
            global $pdo;
        
            // Obține datele curente ale echipei din tabela league
            $query = "SELECT * FROM league WHERE team_id = :team_id";
            $stmt = $pdo->prepare($query);
            $stmt->execute(array('team_id' => $team_id));
            $team = $stmt->fetch(PDO::FETCH_ASSOC);
        
            // Calculează noile valori pentru statistici
            $matches_played = $team['matches_played'] + 1;
            $goals_scored_total = $team['goals_scored'] + $goals_scored;
            $goals_conceded_total = $team['goals_conceded'] + $goals_conceded;
        
            // Determină rezultatul meciului
            if ($goals_scored > $goals_conceded) {
                $wins = $team['wins'] + 1;
                $points = $team['points'] + 3;
                $draws = $team['draws'];
                $losses = $team['losses'];
            } elseif ($goals_scored == $goals_conceded) {
                $draws = $team['draws'] + 1;
                $points = $team['points'] + 1;
                $wins = $team['wins'];
                $losses = $team['losses'];
            } else {
                $losses = $team['losses'] + 1;
                $points = $team['points'];
                $wins = $team['wins'];
                $draws = $team['draws'];
            }
        
            // Actualizează tabela league cu noile valori
            $query = "UPDATE league SET 
                      matches_played = :matches_played, 
                      goals_scored = :goals_scored, 
                      goals_conceded = :goals_conceded, 
                      wins = :wins, 
                      draws = :draws, 
                      losses = :losses, 
                      points = :points 
                      WHERE team_id = :team_id";
            $stmt = $pdo->prepare($query);
            $stmt->execute(array(
                'matches_played' => $matches_played,
                'goals_scored' => $goals_scored_total,
                'goals_conceded' => $goals_conceded_total,
                'wins' => $wins,
                'draws' => $draws,
                'losses' => $losses,
                'points' => $points,
                'team_id' => $team_id
            ));
        }


        public static function deleteMatch($match_id) {
            global $pdo;
        
            // Obține detaliile meciului șters
            $query = "SELECT * FROM matches WHERE id = :match_id";
            $stmt = $pdo->prepare($query);
            $stmt->execute(array('match_id' => $match_id));
            $match = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if ($match) {
                // Scade statisticile meciului din clasamentul echipelor implicate
                self::updateLeagueOnDelete($match['home_team_id'], $match['home_team_goals'], $match['away_team_goals']);
                self::updateLeagueOnDelete($match['away_team_id'], $match['away_team_goals'], $match['home_team_goals']);
        
                // Șterge meciul din baza de date
                $query = "DELETE FROM matches WHERE id = :match_id";
                $stmt = $pdo->prepare($query);
                $stmt->execute(array('match_id' => $match_id));
            }
        }
        
        public static function updateLeagueOnDelete($team_id, $goals_scored, $goals_conceded) {
            global $pdo;
        
            // Obține datele curente ale echipei din tabela league
            $query = "SELECT * FROM league WHERE team_id = :team_id";
            $stmt = $pdo->prepare($query);
            $stmt->execute(array('team_id' => $team_id));
            $team = $stmt->fetch(PDO::FETCH_ASSOC);
        
            // Calculează noile valori pentru statistici
            $matches_played = $team['matches_played'] - 1;
            $goals_scored_total = $team['goals_scored'] - $goals_scored;
            $goals_conceded_total = $team['goals_conceded'] - $goals_conceded;
        
            // Determină rezultatul meciului
            if ($goals_scored > $goals_conceded) {
                $wins = $team['wins'] - 1;
                $points = $team['points'] - 3;
            } elseif ($goals_scored == $goals_conceded) {
                $draws = $team['draws'] - 1;
                $points = $team['points'] - 1;
            } else {
                $losses = $team['losses'] - 1;
            }
        
            // Actualizează tabela league cu noile valori
            $query = "UPDATE league SET 
                      matches_played = :matches_played, 
                      goals_scored = :goals_scored, 
                      goals_conceded = :goals_conceded, 
                      wins = :wins, 
                      draws = :draws, 
                      losses = :losses, 
                      points = :points 
                      WHERE team_id = :team_id";
            $stmt = $pdo->prepare($query);
            $stmt->execute(array(
                'matches_played' => $matches_played,
                'goals_scored' => $goals_scored_total,
                'goals_conceded' => $goals_conceded_total,
                'wins' => $wins ?? $team['wins'],
                'draws' => $draws ?? $team['draws'],
                'losses' => $losses ?? $team['losses'],
                'points' => $points ?? $team['points'],
                'team_id' => $team_id
            ));
        }

        public static function getMatchById($match_id){
            global $pdo;
            $query = "SELECT * FROM matches WHERE id = :match_id";
            $stmt = $pdo->prepare($query);
            $stmt->execute(array('match_id' => $match_id));
            return $stmt->fetch();
        }
        public static function updateMatch($match_id, $home_team_id, $away_team_id, $home_team_goals, $away_team_goals, $date_played) {
            global $pdo;

            // Obține detaliile meciului vechi
            $query = "SELECT * FROM matches WHERE id = :match_id";
            $stmt = $pdo->prepare($query);
            $stmt->execute(array('match_id' => $match_id));
            $old_match = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($old_match) {
                // Scade statisticile vechi din clasamentul echipelor implicate
                self::updateLeagueOnDelete($old_match['home_team_id'], $old_match['home_team_goals'], $old_match['away_team_goals']);
                self::updateLeagueOnDelete($old_match['away_team_id'], $old_match['away_team_goals'], $old_match['home_team_goals']);

                // Actualizează meciul în baza de date
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

                // Adaugă noile statistici în clasamentul echipelor implicate
                self::updateLeague($home_team_id, $home_team_goals, $away_team_goals);
                self::updateLeague($away_team_id, $away_team_goals, $home_team_goals);
            }
        }
        public static function matchExists($home_team_id, $away_team_id)
        {
            global $pdo;
            $query = "SELECT * FROM matches WHERE home_team_id = :home_team_id AND away_team_id = :away_team_id";
            $stmt = $pdo->prepare($query);
            $stmt->execute(array('home_team_id' => $home_team_id, 'away_team_id' => $away_team_id));
            return $stmt->fetchColumn()>0;
        }
    }
?>