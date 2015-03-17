<?php

if (!isset($_GET['q'])) {
    die('Click a profession link');
}
$occ = $_GET['q'];

require_once ("../libraries/sparqllib.php");

$sparql = <<<SPARQL
PREFIX dbpedia-owl: <http://dbpedia.org/ontology/> 
PREFIX dbpprop: <http://dbpedia.org/property/>
PREFIX foaf: <http://xmlns.com/foaf/0.1/> 
PREFIX xsd:    <http://www.w3.org/2001/XMLSchema#> 
PREFIX dcterms: <http://purl.org/dc/terms/>
PREFIX category: <http://dbpedia.org/resource/Category:>
PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

SELECT DISTINCT ?person ?date ?religion (GROUP_CONCAT(?place;separator="<br>") AS ?birthPlace)  ?gender
WHERE { 
   ?occ dcterms:subject <{$occ}> .
   ?person dbpedia-owl:occupation ?occ.
   OPTIONAL {?person dbpedia-owl:birthDate ?date.}
   OPTIONAL {?person dbpprop:religion ?religion.}
   OPTIONAL {?person dbpedia-owl:birthPlace ?place. }
   OPTIONAL {?person dbpprop:gender ?gender.}
} GROUP BY ?person ?date ?religion ?gender
SPARQL;

$data = sparql_get("http://dbpedia.org/sparql", $sparql);

$table = '';


if (!isset($data)) {
    $table.= "<p>Error: " . sparql_errno() . ": " . sparql_error() . "</p>";
} else{


$table.= "<table border='1'>";
$table.= "<tr>";
foreach ($data->fields() as $field) {
    $table.= "<th>$field</th>";
}
$table.= "</tr>";

foreach ($data as $row) {
    $table.= "<tr>";
    foreach ($data->fields() as $field) {
    	if(isset($row[$field]))
        	$table.= "<td>$row[$field]</td>";
    	else
    		$table .="<td></td>";
    }
    $table.= "</tr>";
}
$table.= "</table>";
}
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