<pre>
<?php
require_once("fetch_core.php");

require_once("fetch_gender.php");
require_once("fetch_religion.php");
require_once("fetch_tweets.php");
$occ_t = $_GET['q'];
$occ_n = $_GET['n'];


// limit of 180 request per 15 min
fetch_tweets($occ_t, explode(" ",$occ_n)[0]);	

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

SELECT DISTINCT ?occ ?label
WHERE { 
	?occ dcterms:subject <{$occ_t}> .
	?occ rdfs:label ?label.
	filter(langMatches(lang(?label),"EN"))
} 
SPARQL;

$data = sparql_get("http://dbpedia.org/sparql", $sparql);

if (!isset($data)) {
    print "<p>Error: " . sparql_errno() . ": " . sparql_error() . "</p>";
} else {
	foreach ($data as $row) {
		$occ_url = $row['occ'];
		$name = $row['label'];
		// remove parenthesis with content to improve twitter results
		$name = preg_replace("/\([^)]+\)/","",$name); 
		fetch_gender($occ_url);
		fetch_religion($occ_url);
	}
}

?>
</pre>
