<?php
    $routes = [
        "HN/users/index" => ["UserController", "index"],
        "HN/teams/rankings" => ["TeamsController", "rankings"],
        "HN/teamDetails.php" => ["TeamsController", "show"],
        "HN/index" => ["TeamsController", "rankings"],
        "HN/index1.php" => ["MatchesController", "index"],
        "HN/createPlayer.php" => ["PlayersController", "createPlayer"],
        "HN/process_create_player.php" => ["PlayersController", "insertPlayer"],
        "HN/insertPlayer" => ["PlayersController", "insertPlayer"],
        "HN/deletePlayer" => ["PlayersController", "deletePlayer"],
        "HN/topScorers" => ["StatisticsController", "topScorers"],
        "HN/createMatch" => ["MatchesController", "createMatch"],
        "HN/insertMatch" => ["MatchesController", "insertMatch"],
        "HN/deleteMatch" => ["MatchesController", "deleteMatch"],
        "HN/getPlayersByTeamJson" => ["PlayersController", "getPlayersByTeamJson"],
        "HN/matches" => ["MatchesController", "index"],
        "HN/editMatch.php" => ["MatchesController", "editMatch"],
        "HN/getStats.php" => ["StatisticsController", "getStats"],
        "HN/updateMatch" => ["MatchesController", "updateMatch"],
        "HN/login" => ["AuthController", "login"],
        "HN/logout" => ["AuthController", "logout"],
        "HN/register" => ["AuthController", "register"],
        "HN/profile" => ["UserController", "profile"],
        "HN/users" => ["UserController", "index"],
        "HN/deleteUser" => ["UserController", "delete"],
        "HN/updateUser" => ["UserController", "update"],
        "HN/createUser" => ["UserController", "create"],
        "HN/makeAdmin" => ["UserController", "makeAdmin"],
        "HN/search" => ["UserController", "search"],
    ];

    class Router {
        private $uri;
    
        public function __construct() {
            // Get the current URI
            $this->uri = trim($_SERVER["REQUEST_URI"], "/");
            $this->uri = strtok($this->uri, '?');
        }
        
        public function direct() {
            global $routes;
            $this->uri = strtok($this->uri, '?');
            if (array_key_exists($this->uri, $routes)) {
                [$controller, $method] = $routes[$this->uri];
                require_once "app/controllers/{$controller}.php";
                return $controller::$method();
            }
            require_once "app/views/404.php";
        }
    }
?>
