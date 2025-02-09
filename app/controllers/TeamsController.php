<?php
require_once 'app/models/Teams.php';
require_once 'app/models/Player.php';

// Importă PhpSpreadsheet
require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TeamsController {
    public static function index() {
        $teams = Teams::getAllTeams();
        require_once 'app/views/teams/index.php';
    }

    public static function rankings() {
        $rankings = Teams::getRankings();
        require_once 'app/views/teams/rankings.php';
    }

    public static function show() {
        if (!isset($_SESSION["request_user"])) {
            header("Location: login");
            return;
        }
        $team_id = $_GET['team_id'];
        $team = Teams::getTeamById($team_id);
        $players = Player::getPlayersByTeam($team_id);
        require_once 'app/views/teams/teamDetails.php';
    }

    public static function export() {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'A1' => 'Position', 'B1' => 'Team', 'C1' => 'Matches Played',
            'D1' => 'Wins', 'E1' => 'Draws', 'F1' => 'Losses',
            'G1' => 'Goals Scored', 'H1' => 'Goals Conceded', 'I1' => 'Points'
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        $rankings = Teams::getRankings();
        $position = 1;
        $row = 2;

        foreach ($rankings as $team) {
            $sheet->setCellValue('A' . $row, $position++);
            $sheet->setCellValue('B' . $row, $team['name']);
            $sheet->setCellValue('C' . $row, $team['matches_played']);
            $sheet->setCellValue('D' . $row, $team['wins']);
            $sheet->setCellValue('E' . $row, $team['draws']);
            $sheet->setCellValue('F' . $row, $team['losses']);
            $sheet->setCellValue('G' . $row, $team['goals_scored']);
            $sheet->setCellValue('H' . $row, $team['goals_conceded']);
            $sheet->setCellValue('I' . $row, $team['points']);
            $row++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="rankings.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
    public static function archive() {
        $url = 'https://www.flashscore.ro/handbal/germania/bundesliga/arhiva/';
        $html = file_get_contents($url);
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);
    
        // Selectează rândurile care conțin anii și echipele câștigătoare
        $data = $xpath->query('//*[@id="tournament-page-archiv"]')->item(0);
        $data = trim($data->textContent);
    
        // Ajustăm expresia regulată pentru a extrage corect perechile de ani și echipe câștigătoare
        preg_match_all('/Bundesliga (\d{4}\/\d{4})\s+(?!Bundesliga)(.*?)(?=\s+Bundesliga|\z)/s', $data, $matches, PREG_SET_ORDER);
    
        $archiveData = [];
        foreach ($matches as $match) {
            // Ignorăm intrările incomplete și anul 2024/2025
            if (!empty(trim($match[2])) ) {
                $archiveData[] = [
                    'year' => $match[1],
                    'team' => trim($match[2])
                ];
            }
        }
    
        // Trimite datele către view
        require_once 'app/views/teams/archive.php';
    }
}
?>
