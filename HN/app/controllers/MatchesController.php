<?php
    require_once 'app/models/Matches.php';
    require_once 'app/models/PlayerStatistics.php';
    require_once 'app/models/Teams.php';
    class MatchesController{
        public static function index(){
            $matches = Matches::getAllMatches();
            require_once 'app/views/matches/index.php';
        }
        public static function createMatch(){
            require_once 'app/views/matches/create.php';
        }
        public static function insertMatch() {
            $home_team_id = $_POST['home_team_id'];
            $away_team_id = $_POST['away_team_id'];
            $home_team_goals = intval($_POST['home_team_goals']);
            $away_team_goals = intval($_POST['away_team_goals']);
            $date_played = $_POST['date_played'];
        
            // Calculăm golurile înscrise de jucători pentru echipa gazdă
            $home_team_players = PlayerStatistics::getPlayersByTeamId($home_team_id);
            $total_home_player_goals = 0;
            foreach ($home_team_players as $player) {
                $player_id = $player['id'];
                $player_goals = intval($_POST["player_{$player_id}_goals"] ?? 0);
                $total_home_player_goals += $player_goals;
            }
        
            // Calculăm golurile înscrise de jucători pentru echipa oaspete
            $away_team_players = PlayerStatistics::getPlayersByTeamId($away_team_id);
            $total_away_player_goals = 0;
            foreach ($away_team_players as $player) {
                $player_id = $player['id'];
                $player_goals = intval($_POST["player_{$player_id}_goals"] ?? 0);
                $total_away_player_goals += $player_goals;
            }
        
            // Verificăm dacă totalul golurilor jucătorilor coincide cu golurile echipei
            if ($total_home_player_goals !== $home_team_goals || $total_away_player_goals !== $away_team_goals) {
                // Mesaj de eroare
                $error_message = "Totalul golurilor înscrise de jucători nu coincide cu golurile echipei!";
                echo "<script>
                    alert('$error_message');
                    window.history.back();
                </script>";
                exit();
            }
        
            // Inserăm meciul în baza de date
            $match_id = Matches::createMatch($home_team_id, $away_team_id, $home_team_goals, $away_team_goals, $date_played);
        
            // Inserăm statisticile jucătorilor pentru echipa gazdă
            foreach ($home_team_players as $player) {
                $player_id = $player['id'];
                $goals = intval($_POST["player_{$player_id}_goals"] ?? 0);
                $assists = intval($_POST["player_{$player_id}_assists"] ?? 0);
                PlayerStatistics::createPlayerStatistics($player_id, $match_id, $goals, $assists);
            }
        
            // Inserăm statisticile jucătorilor pentru echipa oaspete
            foreach ($away_team_players as $player) {
                $player_id = $player['id'];
                $goals = intval($_POST["player_{$player_id}_goals"] ?? 0);
                $assists = intval($_POST["player_{$player_id}_assists"] ?? 0);
                PlayerStatistics::createPlayerStatistics($player_id, $match_id, $goals, $assists);
            }
        
            // Mesaj de succes (opțional)
            echo "<script>
                alert('Meciul a fost adăugat cu succes!');
                window.location.href = 'matches';
            </script>";
            exit();
        }
        
        
        public static function deleteMatch(){
            $match_id = $_POST['match_id'];
            Matches::deleteMatch($match_id);
            header("Location: matches");
            exit();
        }
        public static function updateMatch() {
            $match_id = $_POST['match_id'];
            $home_team_id = $_POST['home_team_id'];
            $away_team_id = $_POST['away_team_id'];
            $home_team_goals = intval($_POST['home_team_goals']);
            $away_team_goals = intval($_POST['away_team_goals']);
            $date_played = $_POST['date_played'];
        
            // Calculăm golurile înscrise de jucători pentru echipa gazdă
            $home_team_players = PlayerStatistics::getPlayersByTeamId($home_team_id);
            $total_home_player_goals = 0;
            foreach ($home_team_players as $player) {
                $player_id = $player['id'];
                $player_goals = intval($_POST["player_{$player_id}_goals"] ?? 0);
                $total_home_player_goals += $player_goals;
            }
        
            // Calculăm golurile înscrise de jucători pentru echipa oaspete
            $away_team_players = PlayerStatistics::getPlayersByTeamId($away_team_id);
            $total_away_player_goals = 0;
            foreach ($away_team_players as $player) {
                $player_id = $player['id'];
                $player_goals = intval($_POST["player_{$player_id}_goals"] ?? 0);
                $total_away_player_goals += $player_goals;
            }
        
            // Verificăm dacă totalul golurilor jucătorilor coincide cu golurile echipei
            if ($total_home_player_goals !== $home_team_goals || $total_away_player_goals !== $away_team_goals) {
                // Mesaj de eroare
                $error_message = "Totalul golurilor înscrise de jucători nu coincide cu golurile echipei!";
                echo "<script>
                    alert('$error_message');
                    window.history.back();
                </script>";
                exit();
            }
        
            // Actualizăm detaliile meciului
            Matches::updateMatch($match_id, $home_team_id, $away_team_id, $home_team_goals, $away_team_goals, $date_played);
        
            // Actualizăm statisticile jucătorilor pentru echipa gazdă
            foreach ($home_team_players as $player) {
                $player_id = $player['id'];
                $goals = intval($_POST["player_{$player_id}_goals"] ?? 0);
                $assists = intval($_POST["player_{$player_id}_assists"] ?? 0);
                PlayerStatistics::updatePlayerStatistics($player_id, $match_id, $goals, $assists);
            }
        
            // Actualizăm statisticile jucătorilor pentru echipa oaspete
            foreach ($away_team_players as $player) {
                $player_id = $player['id'];
                $goals = intval($_POST["player_{$player_id}_goals"] ?? 0);
                $assists = intval($_POST["player_{$player_id}_assists"] ?? 0);
                PlayerStatistics::updatePlayerStatistics($player_id, $match_id, $goals, $assists);
            }
        
            // Mesaj de succes (opțional)
            echo "<script>
                alert('Meciul a fost actualizat cu succes!');
                window.location.href = 'matches';
            </script>";
            exit();
        }
        public static function editMatch(){
        $match_id = $_GET['match_id'];
        $match = Matches::getMatchById($match_id);
        $teams = Teams::getAllTeams();
        $home_team_players = PlayerStatistics::getPlayersByTeamId($match['home_team_id']);
        $away_team_players = PlayerStatistics::getPlayersByTeamId($match['away_team_id']);
        require_once 'app/views/matches/edit.php';
        }
    }
?>