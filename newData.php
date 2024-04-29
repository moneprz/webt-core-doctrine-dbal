<?php

$conn = require "./connection.php";

$queryBuilder = $conn->createQueryBuilder();


$p1 = false;
$p2 = false;

$queryBuilder
    ->select('name')
    ->from('player');

$allPlayers = $queryBuilder->fetchAllAssociative();

for ($i = 0; $i < sizeof($allPlayers); $i++) {
    if ($_POST['player1']  == $allPlayers[$i]['name']) {
        $p1 = true;
    }
    if ($_POST['player2']  == $allPlayers[$i]['name']) {
        $p2 = true;
    }
}


if ($p1 == false) {
    $queryBuilder
        ->insert('player')
        ->values(['name' => ':player1'])
        ->setParameter('player1', $_POST['player1']);

    $queryBuilder->executeQuery();
}


if ($p2 == false) {
    $queryBuilder
        ->insert('player')
        ->values(['name' => ':player2'])
        ->setParameter('player2', $_POST['player2']);

    $queryBuilder->executeQuery();
}


$queryBuilder
    ->select('p1.pk_id')
    ->from('player', 'p1')
    ->where('p1.name = :player1')
    ->setParameter('player1', $_POST['player1']);

$player1ID = $queryBuilder->fetchOne();


$queryBuilder
    ->select('p2.pk_id')
    ->from('player', 'p2')
    ->where('p2.name = :player2')
    ->setParameter('player2', $_POST['player2']);

$player2ID = $queryBuilder->fetchOne();


$queryBuilder
    ->select('s1.pk_id')
    ->from('symbol', 's1')
    ->where('s1.bezeichnung = :symbol1')
    ->setParameter('symbol1', $_POST['symbol1']);

$sym1ID = $queryBuilder->fetchOne();


$queryBuilder
    ->select('s2.pk_id')
    ->from('symbol', 's2')
    ->where('s2.bezeichnung = :symbol2')
    ->setParameter('symbol2', $_POST['symbol2']);

$sym2ID = $queryBuilder->fetchOne();


$queryBuilder
    ->insert('round')
    ->values([
        'fk_id' => 1,
        'fk_player1' => ':player1ID',
        'fk_symbol1' => ':sym1ID',
        'date' => ':date',
        'time' => ':time',
        'fk_player2' => ':player2ID',
        'fk_symbol2' => ':sym2ID'
    ])
    ->setParameters([
        'player1ID' => $player1ID,
        'sym1ID' => $sym1ID,
        'date' => date('Y-m-d', strtotime($_POST['date'])),
        'time' => $_POST['time'],
        'player2ID' => $player2ID,
        'sym2ID' => $sym2ID
    ]);

$queryBuilder->executeQuery();

header("Location: index.php");
