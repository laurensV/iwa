<html><body bgcolor="#CCFFCC">
<?php
require_once ("../libraries/sparqllib.php");

$sparql = <<<SPARQL
PREFIX ont: <http://dbpedia.org/ontology/> 
PREFIX dbprop: <http://dbpedia.org/property/>
PREFIX foaf: <http://xmlns.com/foaf/0.1/> 
PREFIX xsd:    <http://www.w3.org/2001/XMLSchema#> 
SELECT ?occ WHERE { 
   ?person dbprop:occupation ?occ 
.
FILTER( 
     regex(str(?occ), "//db")  
  ) 
}
GROUP BY ?occ
ORDER BY ASC(?occ)
LIMIT 10000
SPARQL;

$data = sparql_get("http://dbpedia.org/sparql", $sparql);

if (!isset($data)) {
    print "<p>Error: " . sparql_errno() . ": " . sparql_error() . "</p>";
}

print "<table border='1'>";

foreach ($data as $row) {
    print "<tr>";
    foreach ($data->fields() as $field) {
        print "<td><a href='table.php?q=" . urlencode($row[$field]) . "' target='table'>" . substr($row[$field], 28) . "</a></td>";
    }
    print "</tr>";
}
print "</table>";
?>
</body></html>