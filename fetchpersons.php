<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once("libraries/EasyRdf.php");
require_once("libraries/EasyRdf/Parser/JsonLd.php");
require_once("libraries/IRI.php");
require_once("libraries/JsonLD/JsonLD.php");
require_once("libraries/JsonLD/JsonLdSerializable.php");
require_once("libraries/JsonLD/Value.php");
require_once("libraries/JsonLD/TypedValue.php");
require_once("libraries/JsonLD/Quad.php");
require_once("libraries/JsonLD/RdfConstants.php");
require_once("libraries/JsonLD/Processor.php");
require_once("libraries/JsonLD/FileGetContentsLoader.php");
require_once("libraries/JsonLD/RemoteDocument.php");
require_once("libraries/JsonLD/Exception/JsonLdException.php");

use \EasyRdf_Graph as Graph;
use \EasyRdf_GraphStore as GraphStore;

$sparql = <<<SPARQL
PREFIX dbprop: <http://dbpedia.org/property/>
PREFIX category: <http://dbpedia.org/resource/Category:>
PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
PREFIX dbpedia-owl: <http://dbpedia.org/ontology/>
PREFIX dcterms: <http://purl.org/dc/terms/>

CONSTRUCT {
	?person dbpedia-owl:occupation ?occ .
	?person dbpedia-owl:birthPlace ?place .
	?person dbpprop:gender ?gender .
	?person dbpprop:religion ?religion .
	?person dbpedia-owl:birthDate ?date.
} WHERE {
	?person dbpedia-owl:birthPlace ?place .
	OPTIONAL {?person dbpprop:gender ?gender }
	OPTIONAL {?person dbpprop:religion ?religion.}
	OPTIONAL {?person dbpedia-owl:birthDate ?date.}
	{
		SELECT ?person ?occ WHERE {
			?occ_t skos:broader category:Occupations_by_type .
			?occ dcterms:subject ?occ_t .
			?person dbpedia-owl:occupation ?occ .
		}
		ORDER BY ASC(?person)
		LIMIT 1000
		OFFSET 0
	}
}
SPARQL;

?>

<!DOCTYPE html>
<html>
<head>
<title>TripleStore insert</title>
<meta charset="UTF-8">
</head>
<body>
<pre>
<?php
$client = new EasyRdf_Sparql_Client("http://dbpedia.org/sparql");
$gs = new GraphStore('http://iwa2.cf:8080/openrdf-sesame/repositories/iwa/statements');

$graph = $client->query($sparql);
$gs->insertIntoDefault($graph, 'rdfxml');
?>
</pre>
</body>
</html>
