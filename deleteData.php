<?php

$conn = require "./connection.php";

$queryBuilder = $conn->createQueryBuilder();


$queryBuilder
    ->delete('round')
    ->where('pk_id = ' . $_POST['round']);

$queryBuilder->executeQuery();


header("Location: index.php");
