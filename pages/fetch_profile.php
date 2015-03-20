<pre>
<?php
require_once("fetch_core.php");

require_once("fetch_gender.php");
require_once("fetch_religion.php");
require_once("fetch_age.php");

require_once("fetch_tweets.php");
$occ_t = $_GET['q'];
$occ_n = $_GET['n'];


// limit of 180 request per 15 min
fetch_tweets($occ_t, explode(" ", $occ_n)[0]);	

$sparql = <<<SPARQL
PREFIX dcterms: <http://purl.org/dc/terms/>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>

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
		$name = preg_replace("/\([^)]+\)/", "", $name); 
		fetch_gender($occ_url);
		fetch_religion($occ_url);
		fetch_age($occ_url);
	}
}

?>
</pre>
