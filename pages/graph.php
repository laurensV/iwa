<?php
require_once ("include/functions.php");
require_once ("include/config.php");
require_once ("libraries/sparqllib.php");

$occ = $_GET['q'];

$sparql = <<<SPARQL
PREFIX dbpedia-owl: <http://dbpedia.org/ontology/> 
PREFIX dbpprop: <http://dbpedia.org/property/>
PREFIX foaf: <http://xmlns.com/foaf/0.1/> 
PREFIX xsd:    <http://www.w3.org/2001/XMLSchema#> 
PREFIX dcterms: <http://purl.org/dc/terms/>
PREFIX category: <http://dbpedia.org/resource/Category:>
PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX grs: <http://www.georss.org/georss/>

SELECT DISTINCT ?person ?date 
WHERE { 
   ?occ dcterms:subject <{$occ}> .
   ?person dbpedia-owl:occupation ?occ.
   OPTIONAL {?person dbpedia-owl:birthDate ?date.}
} GROUP BY ?person ?date
SPARQL;

$data = sparql_get("http://dbpedia.org/sparql", $sparql);

if (!isset($data)) {
    print "<p>Error: " . sparql_errno() . ": " . sparql_error() . "</p>";
} else {
    $date_array = array();
    foreach ($data as $row) {
        if (isset($row['date']) && $row['date'][0] != "-") {
            $date_array[] = substr($row['date'], 0, 10);
        }
    }
}
?>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Birth range');
        data.addColumn('number', 'Number of people');

        data.addRows([
          <?php
            foreach($date_array as $date){
              $date_parts = explode('-', $date);

              $date_parts[0][3] = "0";
              if(intval($date_parts[0]) < 1000 || intval($date_parts[0]) > 2020){
                continue;
              }
              $date_range_end = intval($date_parts[0]) + 10;
              $date_range = $date_parts[0]."-".$date_range_end;
                ?>[<?php echo "\"$date_range\"";?>, 1],<?php
            }       
          ?>
        ]);
         var result = google.visualization.data.group(
    data,
    [0],
    [{'column': 1, 'aggregation': google.visualization.data.sum, 'type': 'number'}]
  );


        var options = {
          title: 'Number of People with this job',
          width: 900,
          height: 500,
          hAxis: {
            format: 'yyyy',
            gridlines: {count: 15}
          },
          vAxis: {
            gridlines: {color: 'none'},
            minValue: 0
          }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));

        chart.draw(result, options);
      }
    </script>