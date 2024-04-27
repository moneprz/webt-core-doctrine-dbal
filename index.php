<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rock Paper Scissors Tournament</title>
    <style>
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
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "rps_tournament";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, player, symbol, created_at FROM game_rounds ORDER BY id DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["player"] . "</td>";
            echo "<td>" . ucfirst($row["symbol"]) . "</td>";
            echo "<td>" . date('F j, Y g:i A', strtotime($row["created_at"])) . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No game rounds found</td></tr>";
    }

    $conn->close();
    ?>
    </tbody>
</table>
</body>
</html>
