<?php
/**************************************************************/
/**********************insert religion*************************/
/**************************************************************/
function fetch_gender($occ) {
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

	global $graphStore, $sparqlClient;

	$graph = $sparqlClient->query($sparql);
	var_dump($graphStore->insertIntoDefault($graph, 'rdfxml'));
}
?>
