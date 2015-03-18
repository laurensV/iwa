<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once("../libraries/EasyRdf.php");

use \EasyRdf_Graph as Graph;
use \EasyRdf_GraphStore as GraphStore;
use \EasyRdf_Sparql_Client as Sparql_Client;

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

// Use a local SPARQL 1.1 Graph Store (eg RedStore)
//$gs = new GraphStore('http://iwa2.cf:8080/openrdf-sesame/repositories/iwa');
$client = new Sparql_Client('http://iwa2.cf:8080/openrdf-sesame/repositories/iwa', 'http://iwa2.cf:8080/openrdf-sesame/repositories/iwa/statements');

// Add the current time in a graph
$graph1 = new Graph();
$graph1->add('http://example.com/test', 'rdfs:label', 'Test');
$graph1->add('http://example.com/test', 'dc:date', time());
$client->insert($graph1);
//$gs->insertIntoDefault($graph1);
// Get the graph back out of the graph store and display it
//$graph2 = $gs->getDefault();
//print $graph2->dump();
?>
</pre>
</body>
</html>
