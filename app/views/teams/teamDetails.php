<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app/views/teams/CSS/teamDetails.css">
    <title>Team Details</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <a href="index">
        <img src="/HN/logo.png" class="logo" alt="Logo">
    </a>
    <div class="message">Click the logo to return to the homepage</div>
    <div class="team-details">
        <h1 class="team-name"><?= $team['name'] ?></h1>
        <div class="team-info">
            <p><strong>Coach:</strong> <?= $team['coach'] ?></p>
            <p><strong>Arena:</strong> <?= $team['arena'] ?></p>
        </div>
        <div class="team-logo">
            <img src="<?= $team['photo'] ?>" alt="<?= $team['name'] ?>">
        </div>
        <div class="chart-container">
            <canvas id="nationalityChart" width="200" height="200"></canvas>
        </div>
        <?php if ($_SESSION['request_user']['role_id'] == 1) : ?>
        <button onclick="window.location.href='createPlayer.php?team_id=<?= $team['id'] ?>'">Create Player</button>
        <form action="uploadExcel" method="POST" enctype="multipart/form-data">
            <input type="file" name="excel_file" accept=".xls,.xlsx" required>
            <input type="hidden" name="team_id" value="<?= $team['id'] ?>">
            <input type="submit" value="Upload Excel for Players" class="upload-button">
        </form>
        <?php endif; ?>
    </div>
    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Age</th>
            <th>Position</th>
            <th>Nationality</th>
            <th></th>
        </tr>
        <?php foreach ($players as $player) : ?>
            <tr class="fade-in">
                <td><?= $player["first_name"] ?></td>
                <td><?= $player["last_name"] ?></td>
                <td><?= $player["age"] ?></td>
                <td><?= $player["position"] ?></td>
                <td><?= $player["nationality"] ?></td>
                <td>
                    <form action="deletePlayer" method="POST" style="display: inline;">
                        <input type="hidden" name="player_id" value="<?= $player['id'] ?>">
                        <input type="hidden" name="team_id" value="<?= $_GET['team_id'] ?>">
                        <?php if ($_SESSION["request_user"]["role_id"] == 1): ?>
                            <input type="submit" value="X">
                        <?php endif; ?>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <script src="app/views/teams/JS/teamDetails.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const message = document.getElementsByClassName('message')[0];
    let visible = false;
    setInterval(() => {
        message.style.opacity = visible ? 0 : 1;
        visible = !visible;
    }, 1000); 

    // Colectare date despre naționalitate
    const players = <?= json_encode($players) ?>;
    const nationalityCounts = players.reduce((acc, player) => {
        acc[player.nationality] = (acc[player.nationality] || 0) + 1;
        return acc;
    }, {});

    const labels = Object.keys(nationalityCounts);
    const data = Object.values(nationalityCounts);

    // Creare diagramă gogoasă mai mică
    const ctx = document.getElementById('nationalityChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                label: 'Nationality Distribution',
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(255, 159, 64, 0.6)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: false, // Dezactivează redimensionarea automată
            cutout: '70%', // Ajustează dimensiunea golului din mijloc (70% îl face mai mic)
            layout: {
                padding: 5 // Reduce marginile interne
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { size: 10 } // Font mai mic pentru legendă
                    }
                },
                title: {
                    display: true,
                    text: 'Nationality Distribution of Players',
                    font: { size: 12 } // Diminuează titlul
                }
            }
        }
    });
});

    </script>
</body>
</html>