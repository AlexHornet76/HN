<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Scorers</title>
    <link rel="stylesheet" href="app/views/statistics/top.css">
</head>
<body>
    <a href="index">
        <img src="/HN/logo.png" class="logo" alt="Logo">
    </a>
    <div class="message">Click the logo to return to the homepage</div>
    <h1>Archive</h1>
    <table>
        <tr>
            <th>Year</th>
            <th>Team</th>
        </tr>
        <?php 
        $position = 1;
        foreach ($archiveData as $data) : ?>
            <tr>
            <td><?= htmlspecialchars($data["year"]) ?></td>
            <td><?= htmlspecialchars($data["team"]) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const message = document.getElementsByClassName('message')[0];
            let visible = false;
            setInterval(() => {
                message.style.opacity = visible ? 0 : 1;
                visible = !visible;
            }, 1000); 
        });
    </script>
</body>
</html>
