<?php
    require_once 'app/models/Matches.php';
    require_once 'config/pdo.php';

    $matches = Matches::getAllMatches();
    require_once 'HN/app/views/matches/index.php';

?>