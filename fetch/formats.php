<pre>
<?php
require_once("../libraries/EasyRdf.php");

$rdfxml = EasyRdf_Format::getFormat("rdfxml");
$rdfxml->setMimeTypes(array("application/rdf+xml" => 2.0));

var_dump(EasyRdf_Format::getFormats());

?>
</pre>
