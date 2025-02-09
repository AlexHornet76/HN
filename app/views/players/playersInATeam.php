<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/picnic">
    <title>Users</title>
</head>
<body>
<h1>Players in a Team</h1>
<table>
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Position</th>
        <th>Nationality</th>
    </tr>
    <?php foreach ($players as $player) : ?>
        <tr>
            <td><?= htmlspecialchars($player["first_name"], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($player["last_name"], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($player["position"], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($player["nationality"], ENT_QUOTES, 'UTF-8') ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>