<?php
/**************************************************************/
/*************************insert age***************************/
/**************************************************************/
function fetch_age($occ) {
	$sparql = <<<SPARQL
PREFIX dbpedia-owl: <http://dbpedia.org/ontology/>
PREFIX iwa: <http://iwa2.cf/>

CONSTRUCT {
	<{$occ}> iwa:ageData [iwa:birthYearClass ?year ;
		iwa:count ?dateCount ].
} WHERE {
	{
		SELECT COUNT(*) AS ?dateCount ?year
		WHERE {
			?person dbpedia-owl:occupation <http://dbpedia.org/resource/Farmer> .
			?person dbpedia-owl:birthDate ?date .
	        BIND(ROUND(YEAR(?date)/10.0)*10 AS ?year)
		}
		GROUP BY ?year
	    ORDER BY DESC(?year)
	}
}
SPARQL;

	global $graphStore, $sparqlClient;

	$graph = $sparqlClient->query($sparql);
	var_dump($graphStore->insertIntoDefault($graph, 'rdfxml'));
}
?>
