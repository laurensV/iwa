<?php
$occ = $_GET['q'];
$occ_name = $_GET['n'];

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
PREFIX grs: <http://www.georss.org/georss/>

SELECT DISTINCT ?person ?date ?religion ?gender (SAMPLE(?geo) as ?point)
WHERE { 
   ?occ dcterms:subject <{$occ}> .
   ?person dbpedia-owl:occupation ?occ.
   OPTIONAL {?person dbpedia-owl:birthDate ?date.}
   OPTIONAL {?person dbpprop:religion ?religion.}
   OPTIONAL {?person dbpedia-owl:birthPlace ?place.
   			 ?place grs:point ?geo. }
   OPTIONAL {?person dbpprop:gender ?gender.}
} GROUP BY ?person ?date ?religion ?point ?gender
SPARQL;

$data = sparql_get("http://dbpedia.org/sparql", $sparql);

if (!isset($data)) {
    print "<p>Error: " . sparql_errno() . ": " . sparql_error() . "</p>";
} else {
    /* Get all geocoordinates of birth places */
    $points = array();
    $date_array = array();
    foreach ($data as $row) {
        if (isset($row['point'])) {
            $latlon = explode(" ", $row['point']);
            $points[] = array('latitude' => $latlon[0], 'longitude' => $latlon[1]);
        }
        if(isset($row['date']) && $row['date'][0] !="-"){

            $date_array[] = substr($row['date'],0,10);
        }
    }
    
    $persons_table = "<table class='persons'>";
    $persons_table.= "<tr>";
    foreach ($data->fields() as $field) {
        $persons_table.= "<th>$field</th>";
    }
    $persons_table.= "</tr>";
    
    foreach ($data as $row) {
        $persons_table.= "<tr>";
        foreach ($data->fields() as $field) {
            if (isset($row[$field])) $persons_table.= "<td>$row[$field]</td>";
            else $persons_table.= "<td></td>";
        }
        $persons_table.= "</tr>";
    }
    $persons_table.= "</table>";

    print "<h2>$occ_name Profile</h2>";
    print '<div id="chart_div"></div>';
    require_once("graph.php");
    print "Midpoint: ";
    print_r(getMidPoint($points));
    print "<br>Average date of birth: ";
    print calculate_average_date($date_array);
    print "<br>Positive tweet counts in region Amsterdam (50km area):";
    require_once("twitter.php");
    print "<br>Persons with this occupation: $persons_table";
}
?>

