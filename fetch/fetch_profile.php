<pre>
<?php
if(!isset($_GET['occ'])) {
	die("No occupation set");
}
$occ = $_GET['occ'];

require_once("fetch_core.php");

$sparql = <<<SPARQL
PREFIX dbprop: <http://dbpedia.org/property/>
PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
PREFIX dbpedia-owl: <http://dbpedia.org/ontology/>
PREFIX dcterms: <http://purl.org/dc/terms/>
PREFIX iwa: <http://iwa2.cf/>

CONSTRUCT {
	<{$occ}> iwa:genderData [iwa:gender ?gender ;
		iwa:count ?genderCount ].
} WHERE {
	{
		SELECT COUNT(*) AS ?genderCount ?gender
		WHERE {
			?person dbpedia-owl:occupation <{$occ}> .
			?person dbpprop:gender ?gender .
		}
		GROUP BY ?gender
	}
}
SPARQL;

$graph = $sparqlClient->query($sparql);

var_dump($graphStore->insertIntoDefault($graph, 'rdfxml'));

/* insert religion */
$sparql = <<<SPARQL
PREFIX dbprop: <http://dbpedia.org/property/>
PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
PREFIX dbpedia-owl: <http://dbpedia.org/ontology/>
PREFIX dcterms: <http://purl.org/dc/terms/>
PREFIX iwa: <http://iwa2.cf/>

CONSTRUCT {
	<{$occ}> iwa:religionData [iwa:religion ?religion ;
		iwa:count ?religionCount ].
} WHERE {
	{
		SELECT COUNT(*) AS ?religionCount ?religion
		WHERE {
			?person dbpedia-owl:occupation <{$occ}> .
			?person dbpprop:religion ?religion .
		}
		GROUP BY ?religion
	}
}
SPARQL;

$graph = $sparqlClient->query($sparql);

var_dump($graphStore->insertIntoDefault($graph, 'rdfxml'));

?>
</pre>
