<?php

if (!isset($_GET['q'])) {
    die('Click a profession link');
}
$occ = $_GET['q'];

require_once ("../libraries/sparqllib.php");

$sparql = <<<SPARQL
PREFIX ont: <http://dbpedia.org/ontology/> 
PREFIX dbprop: <http://dbpedia.org/property/>
PREFIX foaf: <http://xmlns.com/foaf/0.1/> 
PREFIX xsd:    <http://www.w3.org/2001/XMLSchema#> 
SELECT ?name ?date WHERE { 
   ?t ont:occupation <{$occ}> .
   ?t ont:birthDate ?date. 
   ?t foaf:name ?name . 
   ?t a ont:Person
  
}
LIMIT 10000000
SPARQL;

$data = sparql_get("http://dbpedia.org/sparql", $sparql);

if (!isset($data)) {
    $table.= "<p>Error: " . sparql_errno() . ": " . sparql_error() . "</p>";
}

$table = '';

$table.= "<table border='1'>";
$table.= "<tr>";
foreach ($data->fields() as $field) {
    $table.= "<th>$field</th>";
}
$table.= "</tr>";

foreach ($data as $row) {
    $table.= "<tr>";
    foreach ($data->fields() as $field) {
        $table.= "<td>$row[$field]</td>";
    }
    $table.= "</tr>";
}
$table.= "</table>";
?>



<html><body bgcolor="#FFFFCC">
  <head>
  </head>
  <body>
    <?php
      print $table; 
    ?>
  </body>
</html>