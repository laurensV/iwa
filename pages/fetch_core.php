<?php
require_once("libraries/EasyRdf.php");

// JSON-LD converts some URI's to literals - NO! bad JSONLD parser!
// By default the JSON-LD parser requires another library anyway so using JSON-LD
// will throw a Class not found exception.
EasyRdf_Format::unregister("jsonld");

// The next default is turtle, which is VERY slow to either parse or download.
// Set RDF/XML to the next preferred format.
$rdfxml = EasyRdf_Format::getFormat("rdfxml");
$rdfxml->setMimeTypes(array("application/rdf+xml" => 2.0));

use \EasyRdf_Graph as Graph;
use \EasyRdf_GraphStore as GraphStore;
use \EasyRdf_Sparql_Client as SparqlClient;

if(!defined("OPEN_REMOTE_ENDPOINT") || OPEN_REMOTE_ENDPOINT) {
	$sparqlClient = new SparqlClient(REMOTE_SPARQL_ENDPOINT);
}
if(!defined("OPEN_LOCAL_GRAPHSTORE") || OPEN_LOCAL_GRAPHSTORE) {
	$graphStore = new GraphStore(LOCAL_UPDATE_ENDPOINT);
}

// Delete script only requires the local endpoint.
if(defined("OPEN_LOCAL_ENDPOINT") && OPEN_LOCAL_ENDPOINT) {
	$localClient = new SparqlClient(LOCAL_UPDATE_ENDPOINT);
}
?>
