<!DOCTYPE html>
<html>
<head>
    <title>Create Player</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app/views/players/CSS/createPlayer.css">
</head>
<body>
    <?php 
    $team_id = filter_input(INPUT_GET, 'team_id', FILTER_SANITIZE_NUMBER_INT); 
    ?>
    <form action="insertPlayer" method="POST">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required><br>
        
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required><br>
        
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required><br>
        
        <label for="position">Position:</label>
        <select id="position" name="position" required>
            <option value="">Select a position</option>
            <option value="GOALKEEPER">GOALKEEPER</option>
            <option value="PIVOT">PIVOT</option>
            <option value="LEFT WING">LEFT WING</option>
            <option value="LEFT BACK">LEFT BACK</option>
            <option value="CENTER BACK">CENTER BACK</option>
            <option value="RIGHT BACK">RIGHT BACK</option>
            <option value="RIGHT WING">RIGHT WING</option>
        </select><br>
        
        <label for="nationality">Nationality:</label>
        <input type="text" id="nationality" name="nationality" required><br>
        
        <input type="hidden" id="team_id" name="team_id" value="<?php echo $team_id; ?>">
        <input type="submit" value="Create Player">
    </form>
</body>
</html>