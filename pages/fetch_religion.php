<?php
/**************************************************************/
/**********************insert religion*************************/
/**************************************************************/
function fetch_religion($occ) {
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
		HAVING(COUNT(*) > 10)
	}
}
SPARQL;

	global $graphStore, $sparqlClient;

	$graph = $sparqlClient->query($sparql);
	var_dump($graphStore->insertIntoDefault($graph, 'rdfxml'));
}
?>
