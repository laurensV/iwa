<?php
if(!isset($_GET['occ'])) {
	die("No occupation set");
}
$occ = $_GET['occ'];

require_once("fetch_core.php");

$localClient = new EasyRdf_Sparql_Client("http://iwa2.cf:8080/openrdf-sesame/repositories/iwa/statements");

$sparql = <<<SPARQL
PREFIX iwa: <http://iwa2.cf/>

DELETE {
	<{$occ}> ?p ?o .
	?node ?p2 ?o2 .
} WHERE {
	<{$occ}> ?p ?o .
	?node ?p2 ?o2 .
	{<{$occ}> iwa:genderData ?node}
	UNION
	{<{$occ}> iwa:religionData ?node}
	UNION
	{<{$occ}> iwa:ageData ?node}
}
SPARQL;

var_dump($localClient->update($sparql));

?>
