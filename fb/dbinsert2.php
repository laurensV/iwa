<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once("../libraries/sparqllib.php");

$query = <<<SPARQL
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>

INSERT {
	<http://example.com/test> rdfs:label "Test"@en .
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
$c = sparql_connect("http://iwa2.cf:8080/openrdf-sesame/repositories/iwa/statements");
var_dump(sparql_query($query, $c));

echo "<p>Error: " . sparql_errno() . ": " . sparql_error() . "</p>";
?>
</pre>
</body>
</html>
