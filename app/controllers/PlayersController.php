<?php
require_once 'app/models/Teams.php';
require_once 'app/models/Player.php';
require_once 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

class PlayersController {
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
    public static function getPlayersByTeam($team_id) {
        $players = Player::getPlayersByTeam($team_id);
        require_once 'HN/app/views/players/playersInATeam.php';
    }

    public static function createPlayer() {
        if (!isset($_SESSION["request_user"])) {
            require_once 'app/views/404.php';
            return;
        }
        require_once 'app/views/players/createPlayer.php';
    }

    public static function insertPlayer() {
        self::token_validation();
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

    public static function deletePlayer() {
        self::token_validation();
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
    public static function uploadExcel(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['excel_file'])) {
            $team_id = $_POST['team_id'];
            $file = $_FILES['excel_file']['tmp_name'];
        
            $spreadsheet = IOFactory::load($file);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();
            
            // Verifică formatul fișierului
            $expectedColumns = ['First Name', 'Last Name', 'Age', 'Position', 'Nationality'];
            $header = $data[0];
            
            if ($header !== $expectedColumns) {
                echo "Invalid file format. Please ensure the file has the correct columns: " . implode(", ", $expectedColumns);
                exit();
            }
            
            // Elimină antetul din date
            array_shift($data);
        
            foreach ($data as $row) {
                if (count($row) !== 5) {
                    echo "Invalid row format. Each row must have exactly 5 columns.";
                    exit();
                }
                
                $first_name = $row[0];
                $last_name = $row[1];
                $age = $row[2];
                $position = $row[3];
                $nationality = $row[4];
                
                // Verifică dacă toate câmpurile sunt completate
                if (empty($first_name) || empty($last_name) || empty($age) || empty($position) || empty($nationality)) {
                    echo "Invalid data. All fields are required.";
                    exit();
                }
                
                Player::createPlayer($first_name, $last_name, $age, $position, $nationality, $team_id);
            }
        
            header("Location: teamDetails.php?team_id=$team_id");
        }
    }
}
    
?>
    

