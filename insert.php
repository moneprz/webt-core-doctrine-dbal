<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Game Round</title>
    <style>
    </style>
</head>
<body>
<h1>Insert Game Round</h1>
<form action="insert.php" method="post">
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
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "rps_tournament";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $player = $_POST["player"];
    $symbol = $_POST["symbol"];

    $sql = "INSERT INTO game_rounds (player, symbol) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $player, $symbol);

    if ($stmt->execute()) {
        echo "<p>Game round inserted successfully!</p>";
    } else {
        echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>
</body>
</html>
