<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Game Round</title>
    <style>
        <!-- Same CSS as in User Story 1 -->
    </style>
</head>
<body>
<h1>Delete Game Round</h1>
<form action="delete.php" method="post">
    <label for="id">ID:</label>
    <input type="number" name="id" id="id" required>
    <br>
    <input type="submit" value="Delete">
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

    $id = $_POST["id"];

    $sql = "DELETE FROM game_rounds WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<p>Game round deleted successfully!</p>";
    } else {
        echo "<p>Error: " . $sql . "<br>" . $conn->error ."</p>";
    }

    $stmt->close();
    $conn->close();
}
?>
</body>
</html>
