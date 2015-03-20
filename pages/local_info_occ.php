<?php
$sparql = <<<SPARQL
PREFIX iwa: <http://iwa2.cf/>

SELECT DISTINCT ?fun ?rich ?boring ?danger
WHERE { 
   <{$occ}> iwa:fun ?fun  ;
   			iwa:rich ?rich;
   			iwa:boring ?boring;
   			iwa:danger ?danger.
} 
SPARQL;

$data = sparql_get(LOCAL_QUERY_ENDPOINT, $sparql);

if (!isset($data)) {
    print "<p>Error: " . sparql_errno() . ": " . sparql_error() . "</p>";
} else {
if (!isset($data[0])){
	echo '<div class="alert alert-danger" role="alert">No local info available, please fetch!</div>';
} else {
$row = $data[0];

?>
<h3>Info from tweets</h3>
<div class="progress">
  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $row['fun']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $row['fun']; ?>%">
  Fun
  </div>
</div>

<div class="progress">
  <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?php echo $row['rich']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $row['rich']; ?>%">
	Rich
  </div>
</div>

<div class="progress">
  <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $row['boring']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $row['boring']; ?>%">
	Boring
  </div>
</div>

<div class="progress">
  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?php echo $row['danger']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $row['danger']; ?>%">
	Danger
  </div>
</div>
<?php
}
}

$sparql = <<<SPARQL
PREFIX iwa: <http://iwa2.cf/>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>

SELECT DISTINCT ?type
WHERE { 
   <{$occ}> rdf:type ?type.
} 
SPARQL;

$data = sparql_get(LOCAL_QUERY_ENDPOINT, $sparql);

if (!isset($data)) {
    print "<p>Error: " . sparql_errno() . ": " . sparql_error() . "</p>";
} else {
	print "<h3>Inferred info</h3>";
foreach($data as $row){
	if (endsWith($row['type'], "Job")){
		$name = str_replace("http://iwa2.cf/", "", $row['type']);
		print '<span class="label label-primary">'.$name.'</span> ';
	}
}
}

?>