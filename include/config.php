<?php
/* Place for the configuration global variables */

error_reporting(E_ALL);
ini_set('display_errors', 'On');


define("REMOTE_SPARQL_ENDPOINT", 
	"http://dbpedia.org/sparql");
define("LOCAL_QUERY_ENDPOINT", 
	"http://iwa2.cf:8080/openrdf-sesame/repositories/iwa");
define("LOCAL_UPDATE_ENDPOINT", 
	"http://iwa2.cf:8080/openrdf-sesame/repositories/iwa/statements");
?>
