<?php
require_once 'app/models/Matches.php';
require_once 'app/models/PlayerStatistics.php';
require_once 'app/models/Teams.php';

class MatchesController {
    static function token_validation() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verifică dacă token-ul CSRF este setat și valid
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                http_response_code(403); // Interzicere acces
                echo "Invalid CSRF token.";
                exit();
            }
        }
    }

    public static function index() {
        if (!isset($_SESSION["request_user"])) {
            header("Location: login");
            return;
        }
        $matches = Matches::getAllMatches();
        require_once 'app/views/matches/index.php';
    }

    public static function createMatch() {
        self::token_validation();
        $form_data = $_SESSION['form_data'] ?? [];
        $error_message = $_SESSION['error_message'] ?? '';
        unset($_SESSION['form_data'], $_SESSION['error_message']);
        $teams = Teams::getAllTeams();
        require_once 'app/views/matches/create.php';
    }

    public static function insertMatch() {
        $home_team_id = $_POST['home_team_id'];
        $away_team_id = $_POST['away_team_id'];
        $home_team_goals = intval($_POST['home_team_goals']);
        $away_team_goals = intval($_POST['away_team_goals']);
        $date_played = $_POST['date_played'];

        // Verificăm dacă există deja o înregistrare cu home_team_id și away_team_id
        if (Matches::matchExists($home_team_id, $away_team_id)) {
            $_SESSION['form_data'] = $_POST;
            $_SESSION['error_message'] = "Există deja un meci între aceste echipe!";
            header("Location: createMatch");
            exit();
        }

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

        if ($total_home_player_goals !== $home_team_goals || $total_away_player_goals !== $away_team_goals) {
            // Stocăm datele în sesiune pentru a le afișa
            session_start();
            $_SESSION['form_data'] = $_POST;
            $_SESSION['error_message'] = "Totalul golurilor înscrise de jucători nu coincide cu golurile echipei!";
            header("Location: createMatch");
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

        // Mesaj de succes
        echo "<script>
            alert('Meciul a fost adăugat cu succes!');
            window.location.href = 'matches';
        </script>";
        exit();
    }

    public static function deleteMatch() {
        $match_id = $_POST['match_id'];
        Matches::deleteMatch($match_id);
        header("Location: matches");
        exit();
    }

    public static function updateMatch() {
        self::token_validation();
        $match_id = $_POST['match_id'];
        $home_team_id = $_POST['home_team_id'];
        $away_team_id = $_POST['away_team_id'];
        $home_team_goals = intval($_POST['home_team_goals']);
        $away_team_goals = intval($_POST['away_team_goals']);
        $date_played = $_POST['date_played'];

        // Verificăm dacă există deja o înregistrare cu home_team_id și away_team_id
        if (Matches::matchExists($home_team_id, $away_team_id) 
            && Matches::getMatchById($match_id)['home_team_id'] !== $home_team_id 
            && Matches::getMatchById($match_id)['away_team_id'] !== $away_team_id) {
            $_SESSION['form_data'] = $_POST;
            $_SESSION['error_message'] = "Există deja un meci între aceste echipe!";
            header("Location: editMatch.php?match_id={$match_id}");
            exit();
        }

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
            // Stocăm datele în sesiune pentru a le afișa
            $_SESSION['form_data'] = $_POST;
            $_SESSION['error_message'] = "Totalul golurilor înscrise de jucători nu coincide cu golurile echipei!";
            header("Location: editMatch.php?match_id={$match_id}");
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

        // Mesaj de succes
        echo "<script>
            alert('Meciul a fost actualizat cu succes!');
            window.location.href = 'matches';
        </script>";
        exit();
    }

    public static function editMatch() {
        self::token_validation();
        $match_id = $_GET['match_id'];
        $match = Matches::getMatchById($match_id);
        $teams = Teams::getAllTeams();
        $home_team_players = PlayerStatistics::getPlayersByTeamId($match['home_team_id']);
        $away_team_players = PlayerStatistics::getPlayersByTeamId($match['away_team_id']);
        $form_data = $_SESSION['form_data'] ?? [];
        $error_message = $_SESSION['error_message'] ?? '';
        unset($_SESSION['form_data'], $_SESSION['error_message']);
        require_once 'app/views/matches/edit.php';
    }
}
?>