<?php
function getMidPoint($points) {
    $combined['x'] = 0;
    $combined['y'] = 0;
    $combined['z'] = 0;
    $totweight = 0;
    
    foreach ($points as $point) {
        
        /* convert to radians */
        $point['latitude'] = $point['latitude'] * (M_PI / 180.0);
        $point['longitude'] = $point['longitude'] * (M_PI / 180.0);
        
        $point['X'] = cos($point['latitude']) * cos($point['longitude']);
        $point['Y'] = cos($point['latitude']) * sin($point['longitude']);
        $point['Z'] = sin($point['latitude']);
        
        $weight = 1;
        
        //floatval($point['weight']);
        $totweight+= $weight;
        
        $combined['x']+= $point['X'] * $weight;
        $combined['y']+= $point['Y'] * $weight;
        $combined['z']+= $point['Z'] * $weight;
    }
    if ($totweight == 0) return;
    
    $combined['x'] = $combined['x'] / $totweight;
    $combined['y'] = $combined['y'] / $totweight;
    $combined['z'] = $combined['z'] / $totweight;
    
    $lon = atan2($combined['y'], $combined['x']);
    $hyp = sqrt($combined['x'] * $combined['x'] + $combined['y'] * $combined['y']);
    $lat = atan2($combined['z'], $hyp);
    
    /* convert back to degrees */
    $lat = $lat * 180.0 / M_PI;
    $lon = $lon * 180.0 / M_PI;
    
    $midpoint['latitude'] = $lat;
    $midpoint['longitude'] = $lon;
    
    return $midpoint;
}

function calculate_average_date($dates) {
    $total = 0;
    
    foreach ($dates as $date) {

    	$now = new DateTime("now");
		$date3 = DateTime::createFromFormat('Y-m-d',$date);
		$interval = $date3->diff($now);
		$seconds = $interval->days*86400 + $interval->h*3600 
           + $interval->i*60 + $interval->s;
        $total+= $seconds;
    }
    $average_diff = round(($total / count($dates)));
    $average_diff = "".$average_diff." seconds";
    $now->sub(DateInterval::createFromDateString($average_diff));
    echo "<p>".date_format($now, 'Y-m-d')."</p>";
}

function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
}
?>