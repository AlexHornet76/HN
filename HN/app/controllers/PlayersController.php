<?php
    require_once 'app/models/Teams.php';
    require_once 'app/models/Player.php';
    
    class PlayersController{
        public static function getPlayersByTeam($team_id){
            $players = Player::getPlayersByTeam($team_id);
            require_once 'HN/app/views/players/playersInATeam.php';
        }
        public static function createPlayer() {
            require_once 'app/views/players/createPlayer.php';
        }

        public static function insertPlayer()
        {
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $age = $_POST['age'];
            $position = $_POST['position'];
            $nationality = $_POST['nationality'];
            $team_id = $_POST['team_id'];
            Player::createPlayer($first_name, $last_name, $age, $position, $nationality, $team_id);

            header("Location: teamDetails.php?team_id=" . $team_id);
            exit();
        }

        public static function deletePlayer()
        {
            $player_id = $_POST['player_id'];
            $team_id = $_POST['team_id'];
            
            // Delete related records in player_statistics
            global $pdo;
            $stmt = $pdo->prepare('DELETE FROM player_statistics WHERE player_id = :player_id');
            $stmt->bindValue(':player_id', $player_id, PDO::PARAM_INT);
            $stmt->execute();
            
            // Now delete the player
            Player::deletePlayer($player_id);
            
            header("Location: teamDetails.php?team_id=" . $team_id);
            exit();
        }
    
        public static function getPlayersByTeamJson() {
            if (isset($_GET['team_id'])) {
                $team_id = $_GET['team_id'];
                $players = Player::getPlayersByTeam($team_id);
                header('Content-Type: application/json');
                echo json_encode($players);
                exit(); 
            } else {
                header('Content-Type: application/json');
                echo json_encode(['error' => 'team_id not provided']);
                exit();
            }
        }
    }
?>