<?php

$conn = require "./connection.php";

$queryBuilder = $conn->createQueryBuilder();

$queryBuilder
    ->select('r.pk_id AS round, p1.name AS player1', 's1.bezeichnung AS symbol1', 
            'r.date', 'r.time', 
            's2.bezeichnung AS symbol2', 'p2.name AS player2')
    ->from('round', 'r')
    ->join('r', 'player', 'p1', 'r.fk_player1 = p1.pk_id')
    ->join('r', 'player', 'p2', 'r.fk_player2 = p2.pk_id')
    ->join('r', 'symbol', 's1', 'r.fk_symbol1 = s1.pk_id')
    ->join('r', 'symbol', 's2', 'r.fk_symbol2 = s2.pk_id');

$results = $queryBuilder->fetchAllAssociative();

$queryBuilder
    ->select('s.bezeichnung')
    ->from('symbol', 's');

$allSymbols = $queryBuilder->fetchAllAssociative();
$allSymbols = array_unique($allSymbols, SORT_REGULAR);


$symbols = file_get_contents('./symbols.html');

$row = file_get_contents('./row.html');

$template = file_get_contents('./template.html');

$keys = array_keys($results[0]);

$rowDone = '';

$symbDone = '';


for ($i = 0; $i < sizeof($results); $i++) {
    for ($j = 0; $j < sizeof($keys); $j++) {
        if ($j == 0) {
            $info = str_replace('{{ ' . $keys[$j] . ' }}', $results[$i][$keys[$j]], $row);
        } else {
            $info = str_replace('{{ ' . $keys[$j] . ' }}', $results[$i][$keys[$j]], $info);
        }
    }
    $rowDone .= $info;
}


for ($i = 0; $i < sizeof($allSymbols); $i++) {
    
    $info = str_replace('{{ symbol }}', $allSymbols[$i]['bezeichnung'], $symbols);
    
    $symbDone .= $info;

}


$template = str_replace('{{ row }}', $rowDone, $template);

$template = str_replace('{{ symbols }}', $symbDone, $template);

echo $template;

