<?php
require_once("fetch_core.php");

//EasyRdf_Format::unregister("jsonld");

$rdfxml = EasyRdf_Format::getFormat("rdfxml");
$rdfxml->setMimeTypes(array("application/rdf+xml" => 2.0));

$sparql = <<<SPARQL
PREFIX dbprop: <http://dbpedia.org/property/>
PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
PREFIX dbpedia-owl: <http://dbpedia.org/ontology/>
PREFIX dcterms: <http://purl.org/dc/terms/>
PREFIX iwa: <http://iwa2.cf/>

CONSTRUCT {
	?occ_t a iwa:Occupation .
	?occ a iwa:Job .
	?occ iwa:workerCount ?count .
	?occ iwa:occupationType ?occ_t .
} WHERE {
	?occ_t skos:broader <http://dbpedia.org/resource/Category:Occupations_by_type> .
	?occ dcterms:subject ?occ_t .
	{
		SELECT COUNT(*) AS ?count ?occ WHERE {
			?occ_t skos:broader <http://dbpedia.org/resource/Category:Occupations_by_type> .
			?occ dcterms:subject ?occ_t .
			?person dbpedia-owl:occupation ?occ .
		}
		GROUP BY ?occ
	}
}
SPARQL;

$graph = $sparqlClient->query($sparql);
//var_dump($graph);

var_dump($graphStore->replaceDefault($graph, 'rdfxml'));

?>
