<?php
error_reporting(E_ALL);
require_once ("facebook/fbinit.php");
use Facebook\FacebookRequest;

if ($loggedin) {
    require_once ("fetch_core.php");
    
    echo "<a class='pull-right' href=\"" . $helper->getLogoutUrl($session, "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "?logout=true") . "\">Logout</a><br />";
    //echo "<a href=\"http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "?logout=true\">Destroy my session</a>";
    
    $request = new FacebookRequest($session, 'GET', '/me', array(
        "fields" => "id,name,birthday,religion,gender,location"
    ));
    
    $response = $request->execute();
    

    $graphObject = $response->getGraphObject();
    $id = $graphObject->getProperty('id');
    
    if ($page == "fb_login"){
	    $graph = new \EasyRdf_Graph();
	    $graph->addResource('http://iwa2.cf/' . $id, 'rdf:type', 'http://iwa2.cf/FacebookUser');
	    $graph->add('http://iwa2.cf/' . $id, 'http://iwa2.cf/:fbName', $graphObject->getProperty('name'));
	    $graph->add('http://iwa2.cf/' . $id, 'http://iwa2.cf/:fbBirthday', $graphObject->getProperty('birthday'));
	    $graph->add('http://iwa2.cf/' . $id, 'http://iwa2.cf/:fbGender', $graphObject->getProperty('gender'));
	    $graph->add('http://iwa2.cf/' . $id, 'http://iwa2.cf/:fbLocation', $graphObject->getProperty('location')->getProperty('name'));
	    
	    $graphStore->insertIntoDefault($graph, 'rdfxml');
	}

    echo "<p>Welcome ".$graphObject->getProperty('name')."</p>";
    ?>
    <?php
}
?>
