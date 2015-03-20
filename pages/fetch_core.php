<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once("libraries/EasyRdf.php");

// JSON-LD converts some URI's to literals - NO! bad JSONLD parser!
EasyRdf_Format::unregister("jsonld");

// The next default is turtle, which is VERY slow to either parse or download.
// Set RDF/XML to the next preferred format.
$rdfxml = EasyRdf_Format::getFormat("rdfxml");
$rdfxml->setMimeTypes(array("application/rdf+xml" => 2.0));

use \EasyRdf_Graph as Graph;
use \EasyRdf_GraphStore as GraphStore;

$sparqlClient = new EasyRdf_Sparql_Client("http://dbpedia.org/sparql");
$graphStore = new GraphStore('http://iwa2.cf:8080/openrdf-sesame/repositories/iwa/statements');

?>
