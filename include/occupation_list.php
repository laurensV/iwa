<?php
$sparql = <<<SPARQL
PREFIX ont: <http://dbpedia.org/ontology/> 
PREFIX dbprop: <http://dbpedia.org/property/>
PREFIX foaf: <http://xmlns.com/foaf/0.1/> 
PREFIX xsd:    <http://www.w3.org/2001/XMLSchema#> 
PREFIX category: <http://dbpedia.org/resource/Category:>
PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>

SELECT ?occ ?name WHERE { 
   ?occ skos:broader category:Occupations_by_type.
   ?occ rdfs:label ?name
}
ORDER BY ASC(?occ)
SPARQL;

$data = sparql_get("http://dbpedia.org/sparql", $sparql);

if (!isset($data)) {
    print "<p>Error: " . sparql_errno() . ": " . sparql_error() . "</p>";
} else {
    print "<ul class='occupation_list'>";
    foreach ($data as $row) {
        print "<li><a href='index.php?p=job_profile&q=" . urlencode($row['occ']) . "&n=".$row['name']."'>" . $row['name'] . "</a></li>";
    }
    print "</ul>";
}
?>