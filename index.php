<?php

require_once "vendor/autoload.php"; // Adjust the path as necessary

use Doctrine\DBAL\DriverManager;

// Configuration
$connectionParams = [
    'dbname' => 'rps_tournament',
    'user' => 'root',
    'password' => '',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
];

$conn = DriverManager::getConnection($connectionParams);

// Check if database and table exist, if not, create them
$sql = "CREATE DATABASE IF NOT EXISTS rps_tournament";
$conn->executeStatement($sql);
$sql = "USE rps_tournament";
$conn->executeStatement($sql);
$sql = "CREATE TABLE IF NOT EXISTS game_rounds (
    id INT AUTO_INCREMENT PRIMARY KEY,
    player VARCHAR(255) NOT NULL,
    symbol ENUM('rock', 'paper', 'scissors') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->executeStatement($sql);

// Insert test data if the table is empty
$sql = "SELECT COUNT(*) as count FROM game_rounds";
$result = $conn->fetchAssociative($sql);
if ($result["count"] == 0) {
    $data = [
        ['John Doe', 'rock'],
        ['Jane Smith', 'paper'],
        ['Mike Johnson', 'scissors'],
        ['Sarah Lee', 'rock'],
        ['William Brown', 'paper'],
        ['William Browsn', 'paper']
    ];

    foreach ($data as $row) {
        $conn->insert('game_rounds', ['player' => $row[0], 'symbol' => $row[1]]);
    }
}

// Handle insertion of new records
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["player"]) && isset($_POST["symbol"])) {
        $player = $_POST["player"];
        $symbol = $_POST["symbol"];

        $conn->insert('game_rounds', ['player' => $player, 'symbol' => $symbol]);

        echo "<p>Game round inserted successfully!</p>";
    }

    // Handle deletion of records
    if (isset($_POST["id"])) {
        $id = $_POST["id"];

        $conn->delete('game_rounds', ['id' => $id]);

        echo "<p>Game round deleted successfully!</p>";
    }
}

// Fetch data from the database to display in the HTML table
$sql = "SELECT id, player, symbol, created_at FROM game_rounds ORDER BY id DESC";
$result = $conn->executeQuery($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rock Paper Scissors Tournament</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        @media screen and (max-width: 600px) {
            table {
                width: 100%;
            }
            th, td {
                display: block;
                width: 100%;
                margin-bottom: 10px;
            }
            h1, p {
                text-align: center;
            }
            form {
                max-width: 300px;
                margin: 0 auto;
            }
            input[type="text"],
            select,
            input[type="number"],
            input[type="submit"] {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
<h1>Rock Paper Scissors Tournament</h1>
<p>Tournament name: Demo Tournament</p>
<p>Date: January 1, 2023</p>
<table>
    <thead>
    <tr>
        <th>Game Round</th>
        <th>Player</th>
        <th>Symbol</th>
        <th>Date/Time</th>
    </tr>
    </thead>
    <tbody>
    <?php while ($row = $result->fetchAssociative()) {?>
        <tr>
            <td><?= $row["id"]?></td>
            <td><?= $row["player"]?></td>
            <td><?= ucfirst($row["symbol"])?></td>
            <td><?= date('F j, Y g:i A', strtotime($row["created_at"]))?></td>
        </tr>
    <?php }?>
    </tbody>
</table>

<h2>Insert Game Round</h2>
<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
    <label for="player">Player:</label>
    <input type="text" name="player" id="player" required>
    <br>
    <label for="symbol">Symbol:</label>
    <select name="symbol" id="symbol" required>
        <option value="rock">Rock</option>
        <option value="paper">Paper</option>
        <option value="scissors">Scissors</option>
    </select>
    <br>
    <input type="submit" value="Insert">
</form>

<h2>Delete Game Round</h2>
<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
    <label for="id">ID:</label>
    <input type="number" name="id" id="id" required>
    <br>
    <input type="submit" value="Delete">
</form>

</body>
</html>
